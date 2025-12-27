<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'admin';
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'nama',
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
        return ['role' => 'admin'];
    }

    // Relationships
    public function barangDitemukan()
    {
        return $this->hasMany(BarangDitemukan::class, 'admin_id', 'admin_id');
    }
}
