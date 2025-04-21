<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periode extends Model
{
    protected $fillable = [
        'libelle', 'debut', 'fin'
    ];

    public function enseignements(): HasMany
    {
        return $this->hasMany(Enseignement::class);
    }
}
