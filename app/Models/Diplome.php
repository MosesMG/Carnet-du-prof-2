<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diplome extends Model
{
    protected $fillable = [
        'diplome', 'taux_hr'
    ];

    public function niveaux(): HasMany
    {
        return $this->hasMany(Niveau::class);
    }
}
