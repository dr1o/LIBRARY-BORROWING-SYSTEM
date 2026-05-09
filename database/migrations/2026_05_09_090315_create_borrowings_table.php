<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); 
            $table->foreignId('book_id')->constrained('books'); 
            $table->integer('jumlah')->default(1);
            $table->date('tanggal_pinjam');
            $table->date('tenggat_waktu')->nullable(); // Due date for fines
            $table->integer('denda')->default(0); // Fine amount
            $table->string('status')->default('pending'); 
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};