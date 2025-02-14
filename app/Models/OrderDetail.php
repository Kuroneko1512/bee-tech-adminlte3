<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Quan hệ 1-1 với bảng orders
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ 1-n với bảng products
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
