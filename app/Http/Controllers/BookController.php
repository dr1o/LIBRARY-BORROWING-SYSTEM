<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $query = Book::with('category');
        $categories = Category::all();

        // 1. Filter by Category first (if selected)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 2. Filter by Search text (nested to preserve the category filter)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul_buku', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
            });
        }

        $all_books = $query->get();

        $userBorrowings = Borrowing::where('user_id', $userId)
            ->whereIn('status', ['Menunggu Persetujuan Pinjam','Dipinjam'])
            ->pluck('book_id')
            ->toArray();

        return view('books.index', compact('all_books','userBorrowings', 'categories'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required',
            'category_id' => 'required',
            'stok' => 'required|integer',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul_buku' => 'required',
            'category_id' => 'required',
            'stok' => 'required|integer',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // 🛡️ Bouncer Check
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak: Hanya Admin yang dapat menghapus buku.');
        }

        // 🛡️ NEW: Protect borrowed books
        $activeBorrowings = \App\Models\Borrowing::where('book_id', $id)
            ->whereIn('status', ['Menunggu Persetujuan Pinjam', 'Dipinjam', 'Menunggu Persetujuan Kembali'])
            ->count();

        if ($activeBorrowings > 0) {
            // Throw a warning back to the Admin
            return back()->with('error', '⚠️ Peringatan: Buku tidak dapat dihapus karena sedang dalam masa peminjaman aktif oleh anggota!');
        }

        $book = Book::withTrashed()->findOrFail($id); 
        $book->forceDelete(); 
        
        return back()->with('success', 'Buku berhasil dihapus permanen!');
    }
}