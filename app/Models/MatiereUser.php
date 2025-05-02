<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatiereUser extends Model
{
    protected $table = 'matiere_user';

    protected $fillable = ['matiere_id', 'user_id', 'taux_hr'];

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
