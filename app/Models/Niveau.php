<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Niveau extends Model
{
    protected $fillable = [
        'libelle', 'description', 'diplome_id',
    ];

    public function filieres(): HasMany
    {
        return $this->hasMany(Filiere::class);
    }
}
