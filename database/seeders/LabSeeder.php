<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LabSeeder extends Seeder
{
    public function run()
    {
        // Categories
        DB::table('categories')->insert([
            ['nama_kategori' => 'Komputer Jaringan', 'created_at'=>now(), 'updated_at'=>now()],
            ['nama_kategori' => 'Embedded', 'created_at'=>now(), 'updated_at'=>now()],
            ['nama_kategori' => 'Software', 'created_at'=>now(), 'updated_at'=>now()],
            ['nama_kategori' => 'Multimedia', 'created_at'=>now(), 'updated_at'=>now()],
        ]);

        // Users
        DB::table('users')->insert([
            ['name' => 'Admin Lab', 'email' => 'admin@lab.com', 'role' => 'admin', 'password' => Hash::make('password123'), 'created_at'=>now(), 'updated_at'=>now()],
            ['name' => 'User Biasa', 'email' => 'user@lab.com', 'role' => 'user', 'password' => Hash::make('password123'), 'created_at'=>now(), 'updated_at'=>now()],
        ]);

        // Equipments example
        DB::table('equipments')->insert([
            ['nama_alat'=>'Router Cisco', 'category_id'=>1, 'stok'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            ['nama_alat'=>'Arduino Uno', 'category_id'=>2, 'stok'=>10, 'created_at'=>now(), 'updated_at'=>now()],
            ['nama_alat'=>'Adobe Photoshop', 'category_id'=>3, 'stok'=>8, 'created_at'=>now(), 'updated_at'=>now()],
            ['nama_alat'=>'Kamera DSLR', 'category_id'=>4, 'stok'=>3, 'created_at'=>now(), 'updated_at'=>now()],
        ]);
    }
}