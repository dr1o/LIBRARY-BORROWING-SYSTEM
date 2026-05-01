<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_equipment = \App\Models\Equipment::with('category')->get();
    // PASTIKAN memanggil 'equipments.index', BUKAN 'dashboard'
        return view('equipments.index', compact('all_equipment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil semua kategori agar bisa dipilih di dropdown/select
        $categories = \App\Models\Category::all();
        return view('equipments.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'nama_alat' => 'required',
            'category_id' => 'required',
            'stok' => 'required|integer',
        ]);

        // Simpan ke database
        \App\Models\Equipment::create($request->all());

        // Kembali ke halaman daftar alat dengan pesan sukses
        return redirect()->route('equipments.index')->with('success', 'Alat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('equipments.edit', compact('equipment', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_alat' => 'required',
            'category_id' => 'required',
            'stok' => 'required|integer',
        ]);

        $equipment = \App\Models\Equipment::findOrFail($id);
        $equipment->update($request->all());

        return redirect()->route('equipments.index')->with('success', 'Data alat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
}
