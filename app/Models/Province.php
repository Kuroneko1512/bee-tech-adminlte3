<?php

namespace App\Models;

use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'name', 'type'];

    // Quan hệ 1-n với bảng districts : Một tỉnh/thành phố có nhiều quận/huyện
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    //Quan hệ 1-n với bảng users : Một tỉnh/thành phố có nhiều users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Quan hệ với communes thông qua districts
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function communes()
    {
        return $this->hasManyThrough(
            Commune::class,      // Model đích cần lấy dữ liệu
            District::class,     // Model trung gian để join
            'province_id',       // Khoá ngoại trên bảng trung gian (districts) 
            'district_id',       // Khoá ngoại trên bảng đích (communes)
            'id',               // Khoá chính của bảng gốc (provinces)
            'id'                // Khoá chính của bảng trung gian (districts);
        );
    }
}
