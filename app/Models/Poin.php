<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poin extends Model
{
    use HasFactory;

    protected $table = 'poin';
    protected $primaryKey = 'poin_id';

    protected $fillable = [
        'user_id',
        'total_poin',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function riwayatPoin()
    {
        return $this->hasMany(RiwayatPoin::class, 'poin_id', 'poin_id');
    }
}
