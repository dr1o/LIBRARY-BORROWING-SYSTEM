<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = ['user_id', 'equipment_id', 'tanggal_pinjam', 'status'];

    // Relasi ke User (Siapa yang pinjam)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Equipment (Alat apa yang dipinjam)
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}