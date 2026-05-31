<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Borrowing extends Model
{
    protected $fillable = ['user_id', 'book_id', 'jumlah', 'tanggal_pinjam', 'tenggat_waktu', 'denda', 'status', 'approved_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function getRemainingDaysAttribute()
    {
        if (!$this->tenggat_waktu || !in_array($this->status, ['Dipinjam', 'Menunggu Persetujuan Kembali'])) {
            return null;
        }

        $dueDate = Carbon::parse($this->tenggat_waktu);
        $now = Carbon::now();

        if ($dueDate->isPast()) {
            return 0; // Already overdue
        }

        return $now->diffInDays($dueDate);
    }

    public function getEstimatedFineAttribute()
    {
        if (!$this->tenggat_waktu || !in_array($this->status, ['Dipinjam', 'Menunggu Persetujuan Kembali'])) {
            return 0;
        }

        $dueDate = Carbon::parse($this->tenggat_waktu);
        $now = Carbon::now();

        if ($now->gt($dueDate)) {
            $daysLate = $now->diffInDays($dueDate);
            return $daysLate * 5000; // Rp 5.000 per day
        }

        return 0;
    }

    public function getDaysLateAttribute()
    {
        if (!$this->tenggat_waktu || !in_array($this->status, ['Dipinjam', 'Menunggu Persetujuan Kembali'])) {
            return 0;
        }

        $dueDate = Carbon::parse($this->tenggat_waktu);
        $now = Carbon::now();

        if ($now->gt($dueDate)) {
            return $now->diffInDays($dueDate);
        }

        return 0;
    }

    public function getIsOverdueAttribute()
    {
        if (!$this->tenggat_waktu || !in_array($this->status, ['Dipinjam', 'Menunggu Persetujuan Kembali'])) {
            return false;
        }

        return Carbon::parse($this->tenggat_waktu)->isPast();
    }
}