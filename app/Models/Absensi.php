<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Absensi extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'absensi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nik',
        'absensi_date',
        'time_in',
        'time_out',
        'photo_in',
        'photo_out',
        'location'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
