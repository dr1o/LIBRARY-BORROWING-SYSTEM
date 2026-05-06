<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoansSeeder extends Seeder
{
    public function run()
    {
        // Contoh pinjaman manual
        DB::table('loans')->insert([
            [
                'user_id' => 1, // Admin Lab
                'equipment_id' => 1, // Router Cisco
                'tanggal_pinjam' => Carbon::now()->subDays(3)->toDateString(),
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // User Biasa
                'equipment_id' => 2, // Arduino Uno
                'tanggal_pinjam' => Carbon::now()->subDays(1)->toDateString(),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'equipment_id' => 3, // Adobe Photoshop
                'tanggal_pinjam' => Carbon::now()->toDateString(),
                'status' => 'returned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        
    }
}