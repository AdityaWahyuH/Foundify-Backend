<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $table = 'reward';
    protected $primaryKey = 'reward_id';

    protected $fillable = [
        'barang_hilang_id',
        'judul',
        'deskripsi',
        'nominal',
        'gambar',
        'status',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function barangHilang()
    {
        return $this->belongsTo(BarangHilang::class, 'barang_hilang_id', 'barang_hilang_id');
    }
}
