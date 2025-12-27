<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPoin extends Model
{
    use HasFactory;

    protected $table = 'riwayat_poin';
    protected $primaryKey = 'riwayat_id';
    public $timestamps = false;

    protected $fillable = [
        'poin_id',
        'jumlah_poin',
        'keterangan',
        'tanggal_transaksi',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    // Relationships
    public function poin()
    {
        return $this->belongsTo(Poin::class, 'poin_id', 'poin_id');
    }
}
