<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE = ['member', 'admin'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'image',
    ];
    protected $hidden = [
        'password',
    ];
    protected $casts = [
        'password' => 'hashed',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
    public function checkVouchers()
    {
        return $this->hasMany(CheckVoucher::class);
    }
}
