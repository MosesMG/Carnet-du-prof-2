<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Seance extends Model
{
    protected $fillable = [
        'date', 'heure_debut',
        'heure_fin', 'description',
        'matiere_id',
    ];

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function etudiants(): BelongsToMany
    {
        return $this->belongsToMany(Etudiant::class)
                    ->withPivot(['presence', 'plus']);
    }
}
