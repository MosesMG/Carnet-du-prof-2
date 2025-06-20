<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function rappels(): HasMany
    {
        return $this->hasMany(Rappel::class);
    }

    public function getEtatAttribute(): string
    {
        if ($this->heure_debut && $this->heure_fin) {
            return 'terminée';
        }

        if ($this->heure_debut && !$this->heure_fin) {
            return 'en cours';
        }

        $heurePrevue = $this->matiere->heure_debut ?? null;
        if (!$heurePrevue || !$this->dateFormat) {
            return 'inconnue';
        } 

        $dateSeance = Carbon::createFromFormat('Y-m-d H:i', "{$this->date} {$heurePrevue}");

        return now()->greaterThan($dateSeance) ? 'non tenue' : 'à venir';
    }
}
