<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rappel extends Model
{
    protected $fillable = [
        'titre',
        'message',
        'seance_id'
    ];

    public function seance(): BelongsTo
    {
        return $this->belongsTo(Seance::class);
    }
}
