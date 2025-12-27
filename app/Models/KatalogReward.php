<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatalogReward extends Model
{
    use HasFactory;

    protected $table = 'katalog_reward';
    protected $primaryKey = 'katalog_id';

    protected $fillable = [
        'nama_reward',
        'deskripsi',
        'poin_required',
        'stok',
        'gambar',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function tukarPoin()
    {
        return $this->hasMany(TukarPoin::class, 'katalog_id', 'katalog_id');
    }
}
