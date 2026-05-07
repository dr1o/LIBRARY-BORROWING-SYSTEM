<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function index(Request $request)
{
    $userId = Auth::id();

    $query = Equipment::with('category');

    // 🔍 SEARCH BAR
    if ($request->has('search')) {
        $query->where('nama_alat', 'like', '%' . $request->search . '%');
    }

    $all_equipment = $query->get();

    // Ambil daftar equipment yang sedang dipinjam atau menunggu
    $userLoans = Loan::where('user_id', $userId)
                    ->whereIn('status', ['Menunggu Persetujuan Pinjam','Dipinjam'])
                    ->pluck('equipment_id')
                    ->toArray();

    return view('equipments.index', compact('all_equipment','userLoans'));
}

    public function create()
    {
        $categories = Category::all();
        return view('equipments.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required',
            'category_id' => 'required',
            'stok' => 'required|integer',
        ]);

        Equipment::create($request->all());

        return redirect()->route('equipments.index')
            ->with('success', 'Alat berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $equipment = Equipment::findOrFail($id);
        $categories = Category::all();

        return view('equipments.edit', compact('equipment', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_alat' => 'required',
            'category_id' => 'required',
            'stok' => 'required|integer',
        ]);

        $equipment = Equipment::findOrFail($id);
        $equipment->update($request->all());

        return redirect()->route('equipments.index')
            ->with('success', 'Data alat berhasil diperbarui!');
    }

    public function destroy($id)
{
    $equipment = Equipment::withTrashed()->findOrFail($id); // include soft deleted
    $equipment->forceDelete(); // hapus permanen
    return back()->with('success', 'Alat berhasil dihapus permanen!');
}

    // 🔥 Kurangi stok 1
    public function decreaseStock($id)
    {
        $equipment = Equipment::findOrFail($id);

        if ($equipment->stok > 0) {
            $equipment->stok -= 1;
            $equipment->save();
        }

        return redirect()->back()->with('success', 'Stok berhasil dikurangi 1!');
    }

    // 🔥 Hapus semua stok
    public function clearStock($id)
    {
        $equipment = Equipment::findOrFail($id);

        $equipment->stok = 0;
        $equipment->save();

        return redirect()->back()->with('success', 'Semua stok dihapus!');
    }
    public function increaseStock($id)
    {
        $equipment = Equipment::findOrFail($id);

        $equipment->stok += 1;
        $equipment->save();

        return redirect()->back()->with('success', 'Stok berhasil ditambah 1');
    }
}