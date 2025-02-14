<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'sku',
        'name',
        'stock',
        'avatar',
        'expired_at',
        'category_id',
        'flag_delete',
        'price',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expired_at' => 'date',
        'flag_delete' => 'boolean',
    ];

    // Quan hệ 1-1 với bảng categories
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    /**
     * Một product có thể xuất hiện trong nhiều chi tiết đơn hàng.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * (Tùy chọn) Lấy các đơn hàng chứa sản phẩm này thông qua order details.
     * Lưu ý: Mối quan hệ này phức tạp hơn vì 1 đơn hàng có thể chứa nhiều sản phẩm,
     * nhưng nếu cần, bạn có thể định nghĩa quan hệ này.
     */
    public function orders()
    {
        return $this->hasManyThrough(Order::class, OrderDetail::class, 'product_id', 'id', 'id', 'order_id');
    }
}
