<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TukarPoin extends Model
{
    use HasFactory;

    protected $table = 'tukar_poin';
    protected $primaryKey = 'tukar_id';

    protected $fillable = [
        'user_id',
        'katalog_id',
        'jumlah_poin',
        'tanggal_tukar',
        'status',
    ];

    protected $casts = [
        'tanggal_tukar' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function katalogReward()
    {
        return $this->belongsTo(KatalogReward::class, 'katalog_id', 'katalog_id');
    }
}
