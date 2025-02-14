<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'quantity',
        'total',
    ];

    // Quan hệ  1-n với Order Detail
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    //Quan hệ 1-1 với bảng customers
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
