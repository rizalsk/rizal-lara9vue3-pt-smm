<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Permintaan extends Model
{
    use HasFactory;

    protected $fillable = ['staff_nik', 'tanggal_permintaan', 'status'];
    
    public function details(): HasMany
    {
        return $this->hasMany(DetailPermintaan::class, 'permintaan_id', 'id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_nik', 'nik');
    }
}
