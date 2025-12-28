<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'nama',
        'no_telp',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // JWT Methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return ['role' => $this->role];
    }

    // Relationships
    public function barangHilang()
    {
        return $this->hasMany(BarangHilang::class, 'user_id', 'user_id');
    }

    public function barangDitemukan()
    {
        return $this->hasMany(BarangDitemukan::class, 'user_id', 'user_id');
    }

    public function klaim()
    {
        return $this->hasMany(Klaim::class, 'user_id', 'user_id');
    }

    public function poin()
    {
        return $this->hasOne(Poin::class, 'user_id', 'user_id');
    }

    public function tukarPoin()
    {
        return $this->hasMany(TukarPoin::class, 'user_id', 'user_id');
    }
}
