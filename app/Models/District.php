<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['code', 'name', 'type', 'province_id'];

    // Quan hệ n-1 với bảng provinces : Một quận/huyện thuộc một tỉnh/thành phố
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    // Quan hệ 1-n với bảng communes : Một quận/huyện có nhiều xã/phường
    public function communes()
    {
        return $this->hasMany(Commune::class);
    }

    // Quan hệ 1-n với bảng users : Một quận/huyện có nhiều users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
