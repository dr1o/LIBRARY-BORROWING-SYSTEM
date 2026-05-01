<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Syarat No. 4
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment extends Model
{
    use SoftDeletes; // Aktifkan fitur Soft Delete

    protected $table = 'equipments'; // Memastikan nama tabelnya pas
    protected $fillable = ['nama_alat', 'category_id', 'stok'];

    // Relasi: Alat lab dimiliki oleh sebuah kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}