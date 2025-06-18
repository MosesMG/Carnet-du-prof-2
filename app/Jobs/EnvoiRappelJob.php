<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Rappel;
use App\Models\Seance;
use App\Mail\RappelSeance;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnvoiRappelJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $oneHour = now()->addMinutes(0);

        // $users = User::whereHas('matieres', function ($query) use ($oneHour) {
        //     $query->where('jour', '=', $oneHour->isoWeekday())
        //         ->where('heure_debut', '=', $oneHour->format('H:i'));
        // })->with(['matieres' => function ($query) use ($oneHour) {
        //     $query->where('jour', '=', $oneHour->isoWeekday())
        //         ->where('heure_debut', '=', $oneHour->format('H:i'))
        //         ->with('filiere.site.universite');
        // }])->get();

        $matieres = $user->matieres()->with('filiere.site.universite')
                        ->where('jour', '=', now()->isoWeekday())
                        ->where('heure_debut', '=', $oneHour->format('H:i'))
                        ->get();

        // foreach ($users as $user) {
            foreach ($matieres as $matiere) {
                $existe = Seance::where('matiere_id', '=', $matiere->id)
                                ->whereDate('date', '=', $oneHour->toDateString())
                                ->exists();
    
                if ($existe) continue;
    
                $seance = Seance::create([
                    'date' => $oneHour->toDateString(),
                    'heure_debut' => null,
                    'heure_fin' => null,
                    'matiere_id' => $matiere->id,
                ]);
    
                $user = $matiere->users->first();
                if ($user && $user->email) {
                    Mail::to($user->email)->send(new RappelSeance($matiere, $user));
    
                    Rappel::create([
                        'titre' => "Rappel",
                        'message' => 'Cours de ' . $matiere->intitule . ' de ' .
                                Carbon::parse($matiere->heure_debut)->format('H:i') . ' à ' .
                                Carbon::parse($matiere->heure_fin)->format('H:i'),
                        'seance_id' => $seance->id,
                    ]);
                }
            }
        // }
    }
}
