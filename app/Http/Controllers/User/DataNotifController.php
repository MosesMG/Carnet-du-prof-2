<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rappel;
use App\Models\Seance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DataNotifController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $debutMois = $now->copy()->startOfMonth();
        $finMois = $now->copy()->endOfMonth();

        $user = auth()->guard('web')->user();
        $matieres = $user->matieres()->withPivot('taux_hr')->get()->keyBy('id');

        $seancesDuMois = Seance::with('matiere.filiere.site.universite', 'matiere.users')
            ->whereIn('matiere_id', $matieres->keys())
            ->whereBetween('date', [$debutMois, $finMois])
            ->orderByDesc('date')->get()
            ->map(function ($seance) use ($matieres) {
                $seance->taux_hr = $matieres[$seance->matiere_id]->pivot->taux_hr ?? null;
                return $seance;
        });
        
        
        $debutMoisPasses = $now->copy()->subMonths(11)->startOfMonth();

        $seancesPassees = Seance::with('matiere.filiere.site.universite')
            ->whereIn('matiere_id', $matieres->keys())
            ->whereBetween('date', [$debutMoisPasses, $debutMois->copy()->subDay()])
            ->orderByDesc('date')->get()
            ->map(function ($seance) use ($matieres) {
                $seance->taux_hr = $matieres[$seance->matiere_id]->pivot->taux_hr ?? null;
                return $seance;
            })
            ->groupBy(fn ($seance) =>
                Carbon::parse($seance->date)->format('Y-m'));

        return inertia('Donnees/Index', [
            'actuelMois' => $seancesDuMois,
            'passesMois' => $seancesPassees,
        ]);
    }

    public function lesRappels()
    {
        $user = auth()->guard('web')->user();
        $matieres = $user->matieres()->pluck('matieres.id');

        $rappels = Rappel::whereHas('seance.matiere', 
            function($query) use ($matieres) {
                $query->whereIn('id', $matieres);
        })->orderByDesc('id')->get();

        return inertia('Home/Rappels', [
            'rappels' => $rappels,
        ]);
    }

    public function deleteRappel(string $rappel)
    {
        $rappel = Rappel::find($rappel);

        $rappel->delete();

        return redirect()->route('les.rappels');
    }

    public function deleteAllRappels()
    {
        $user = auth()->guard('web')->user();
        $matieres = $user->matieres()->pluck('matieres.id');

        Rappel::whereHas('seance.matiere', 
            function($query) use ($matieres) {
                $query->whereIn('id', $matieres);
        })->delete();

        return redirect()->route('les.rappels');
    }
}
