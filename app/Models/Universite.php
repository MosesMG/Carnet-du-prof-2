<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Universite extends Model
{
    protected $fillable = [
        'nom', 'description', 'telephone',
    ];

    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }
}
