<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangHilang extends Model
{
    use HasFactory;

    protected $table = 'barang_hilang';
    protected $primaryKey = 'barang_hilang_id';

    protected $fillable = [
        'user_id',
        'nama_barang',
        'deskripsi',
        'tanggal_hilang',
        'lokasi',
        'status',
        'foto',
    ];

    protected $casts = [
        'tanggal_hilang' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }


}
