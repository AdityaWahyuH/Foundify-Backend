<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangDitemukan extends Model
{
    use HasFactory;

    protected $table = 'barang_ditemukan';
    protected $primaryKey = 'barang_ditemukan_id';

    protected $fillable = [
        'admin_id',
        'nama_barang',
        'deskripsi',
        'tanggal_ditemukan',
        'lokasi',
        'lokasi_barang_ditemukan',
        'jadwal_penjemputan',
        'lokasi_penjemputan',
        'status',
        'foto',
    ];

    protected $casts = [
        'tanggal_ditemukan' => 'date',
        'jadwal_penjemputan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    public function klaim()
    {
        return $this->hasMany(Klaim::class, 'barang_ditemukan_id', 'barang_ditemukan_id');
    }
}
