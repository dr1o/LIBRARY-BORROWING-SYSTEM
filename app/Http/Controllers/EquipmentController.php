<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Category;

class EquipmentController extends Controller
{
    public function index()
    {
        $all_equipment = Equipment::with('category')->get();
        return view('equipments.index', compact('all_equipment'));
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

    public function destroy(string $id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('equipments.index')
            ->with('success', 'Alat dipindahkan ke sampah!');
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