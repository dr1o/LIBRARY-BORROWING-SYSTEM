<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') abort(403, 'Akses Ditolak.');
        
        // Fetch categories and automatically count how many books are in each
        $categories = Category::withCount('books')->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories'
        ]);

        Category::create($request->all());
        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $category = Category::findOrFail($id);
        
        // Safety check: Don't delete if books are using this category
        if ($category->books()->count() > 0) {
            return back()->with('error', 'Gagal: Kategori ini tidak bisa dihapus karena masih digunakan oleh buku di katalog!');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}