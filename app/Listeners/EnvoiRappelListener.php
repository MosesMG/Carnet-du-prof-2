<?php

namespace App\Listeners;

use App\Jobs\EnvoiRappelJob;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class EnvoiRappelListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = User::find($event->user->id);

        $matieres = $user->matieres()->with('filiere.site.universite')
                        ->where('jour', '=', now()->isoWeekday())
                        // ->where('heure_debut', '=', $oneHour->format('H:i'))
                        ->get();

        foreach ($matieres as $matiere) {
            try {
                $heureRappel = Carbon::parse($matiere->heure_debut)->copy()->subMinutes(30);

                if ($heureRappel->isFuture()) {
                    $delai = $heureRappel->diffInSeconds(now());
                    EnvoiRappelJob::dispatch($matiere, $user)->delay($delai);

                    Log::info("Rappel planifié pour {{ $matiere->intitule }}");
                }
                else {
                    Log::info("Rappel ignoré pour {{ $matiere->intitule }}");
                }
            }
            catch (\Exception $e) {
                Log::error("Erreur lors de la planification du rappel: " . $e->getMessage());
            }
        }
    }
}
