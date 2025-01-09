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
        'expired_date',
        'category_id',
        'flag_delete',
    ];
    

    public function category(){
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
