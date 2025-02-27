<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles;
    // use HasFactory;

    /**
     * Các trường có thể mass assign
     */
    protected $fillable = [
        'email',
        'phone',
        'password',
        'full_name',
        'birthday',
        'address',
        'province_id',
        'district_id',
        'commune_id',
        'status'
    ];

    /**
     * Ẩn các trường nhạy cảm
     */
    protected $hidden = [
        'password',
        'reset_password'
    ];

    /**
     * Relationships với bảng địa chỉ
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    /**
     * Một customer có nhiều đơn hàng.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Một customer có nhiều chi tiết đơn hàng thông qua các đơn hàng.
     * Mối quan hệ hasManyThrough cho phép bạn truy xuất trực tiếp các chi tiết đơn hàng của customer.
     */
    public function orderDetails()
    {
        return $this->hasManyThrough(OrderDetail::class, Order::class, 'customer_id', 'order_id');
    }
}
