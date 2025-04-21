<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etudiant extends Model
{
    protected $fillable = [
        'nom', 'prenom',
        'sexe', 'telephone',
        'email', 'filiere_id',
    ];

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function seances(): BelongsToMany
    {
        return $this->belongsToMany(Seance::class)
                    ->withPivot(['presence', 'plus'])
                    ->withTimestamps();
    }
}
