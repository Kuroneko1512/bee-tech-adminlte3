<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commune extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['code', 'name', 'type', 'district_id'];

    // Quan hệ n-1 với bảng districts : Một xã/phường thuộc một quận/huyện
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    // Quan hệ 1-n với bảng users : Một xã/phường có nhiều users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
