<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
        
            // Tetap seperti ini karena tabelnya memang 'users'
            $table->foreignId('user_id')->constrained(); 
            
            // TAMBAHKAN 'equipments' di dalam constrained agar tidak salah cari tabel
            $table->foreignId('equipment_id')->constrained('equipments'); 
            
            $table->date('tanggal_pinjam');
            
            // SARAN: Berikan default value agar tidak error saat input data baru
            $table->string('status')->default('pending'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
