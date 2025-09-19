<?php

namespace App\Services;

use App\Jobs\EnvoiRappelJob;
use App\Models\Seance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SeanceService
{
    public function creerSeances()
    {
        $user = Auth::guard("web")->user();

        $matieres = $user->matieres()->with('filiere.site.universite')
            ->where('jour', '=', now()->isoWeekday())
            ->get();

        foreach ($matieres as $matiere) {
            try {
                $existe = Seance::where('matiere_id', '=', $matiere->id)
                    ->whereDate('date', '=',  now()->toDateString())
                    ->exists();

                if ($existe) continue;

                Seance::create([
                    'date' => now()->toDateString(),
                    'heure_debut' => null,
                    'heure_fin' => null,
                    'matiere_id' => $matiere->id,
                ]);

                $data = [
                    'name' => $user->name,
                    'additionalInfo' => [
                        'Heure' => Carbon::parse($matiere->heure_debut)->format('H:i'),
                        'Matière' => $matiere->intitule,
                        'Université' => $matiere->filiere->site->universite->nom,
                        'Filière' => $matiere->filiere->libelle
                    ],
                    'contact' => 'contact@newbrainfactory.com',
                    'website' => 'https://newbrainfactory.com',
                ];

                $heureEnvoi = Carbon::parse($matiere->heure_debut)->subHour();

                if ($heureEnvoi > Carbon::now()) {
                    EnvoiRappelJob::dispatch($user, $data)->delay($heureEnvoi);
                }
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
}
