<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom untuk diisi (Mass Assignment)
    protected $guarded = [];

    /**
     * Relasi ke tabel Products
     * Setiap 1 item di keranjang itu milik 1 Produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke tabel Users
     * Setiap 1 item di keranjang itu milik 1 User/Pelanggan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}