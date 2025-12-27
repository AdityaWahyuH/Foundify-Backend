<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klaim extends Model
{
    use HasFactory;

    protected $table = 'klaim';
    protected $primaryKey = 'klaim_id';

    protected $fillable = [
        'user_id',
        'barang_ditemukan_id',
        'bukti_kepemilikan',
        'status',
        'tanggal_klaim',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_klaim' => 'datetime',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function barangDitemukan()
    {
        return $this->belongsTo(BarangDitemukan::class, 'barang_ditemukan_id', 'barang_ditemukan_id');
    }
}
