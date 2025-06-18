<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function accueil()
    {
        $today = now()->isoWeekday();
        $user = auth()->guard('web')->user();
        $aujMatieres = $user->matieres()->with('filiere.site.universite')
                            ->where('jour', '=', $today)
                            ->orderBy('heure_debut')->get();

        return inertia('Accueil', [
            'matieres' => $aujMatieres,
        ]);
    }

    public function calendrier()
    {
        $user = auth()->guard('web')->user();
        $matieres = $user->matieres()->with('filiere.site.universite')->orderBy('jour')->get();

        return inertia('Calendrier/Semaine', [
            'semaine' => [
                1 => $matieres->where('jour', '=', 1),
                2 => $matieres->where('jour', '=', 2),
                3 => $matieres->where('jour', '=', 3),
                4 => $matieres->where('jour', '=', 4),
                5 => $matieres->where('jour', '=', 5),
                6 => $matieres->where('jour', '=', 6),
                7 => $matieres->where('jour', '=', 7),
            ],
        ]);
    }
}
