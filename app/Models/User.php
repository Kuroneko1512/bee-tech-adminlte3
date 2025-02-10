<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'user_name',
        'birthday',
        'first_name',
        'last_name',
        'avatar',
        'password',
        'reset_password',
        'status',
        'flag_delete',
        'address',
        'province_id',
        'district_id',
        'commune_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'reset_password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthday' => 'date',
        'flag_delete' => 'boolean',
    ];

    //Quan hệ n-1 với bảng provinces : Một user thuộc một tỉnh/thành phố
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    //Quan hệ n-1 với bảng districts : Một user thuộc một quận/huyện
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    //Quan hệ n-1 với bảng communes : Một user thuộc một xã/phường
    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }
}
