<?php

namespace App\Console\Commands;

use App\Jobs\EnvoiRappelJob;
use App\Jobs\EnvoyerRappelJob;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EnvoyerRappel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'envoyer:rappels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $today = now()->isoWeekday();
        // $oneHour = now()->addMinutes(2);
        // $user = auth()->guard('web')->user();
        // $aujMatieres = $user->matieres()->with('filiere.site.universite')
        //                     ->where('jour', '=', $today)
        //                     ->where('heure_debut', '=', $oneHour)->get();

        // dispatch(new EnvoiRappelJob($aujMatieres, $user));
                            
        // foreach ($aujMatieres as $matiere) {
        //     // $heureDebut = now()->copy()->setTimeFromTimeString($matiere->heure_debut);
        //     // $diff = now()->diffInMinutes($heureDebut, false);
        //     $heureDebut = Carbon::parse($matiere->heure_debut);
        //     $envoi = $heureDebut->subHour();

        //     // if ((int)$diff === -1) {
        //         EnvoyerRappelJob::dispatch($matiere)->delay(10);
        //     // }
        // }
    }
}
