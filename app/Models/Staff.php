<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staff';
    protected $primaryKey = 'nik';

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class, 'departemen_id', 'id');
    }
}
