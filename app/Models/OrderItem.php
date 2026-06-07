<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $guarded = ['id'];

    protected $fillable = [
        'order_id', 'layanan_id', 'produk_id', 'qty', 'harga',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->qty * $this->harga;
    }
}
