<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'order_number', 
        'shipping_address',
        'total_price',   
        'total_amount',  
        'status',
        'shipping_fee',
        'distance',
        'latitude',
        'longitude'
    ];

    // Relasi ke User (Biarkan jika sudah ada)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hubungan relasi: Satu Order memiliki banyak Item Pesanan
     */
    public function items()
    {
        // Hubungkan ke model OrderItem atau OrderDetail Anda (sesuaikan nama Model detail produk Anda)
        // Contoh standar biasanya menggunakan OrderItem::class
        return $this->hasMany(OrderItem::class, 'order_id'); 
    }
}