<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    protected $fillable = ['judul_buku', 'penulis', 'isbn', 'category_id', 'stok'];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}