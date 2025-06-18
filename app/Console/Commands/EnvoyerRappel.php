<?php

namespace App\Console\Commands;

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
        $today = now()->isoWeekday();
        $user = auth()->guard('web')->user();
        $aujMatieres = $user->matieres()->with('filiere.site.universite')
                            ->where('jour', '=', $today)->get();

        foreach ($aujMatieres as $matiere) {
            // $heureDebut = now()->copy()->setTimeFromTimeString($matiere->heure_debut);
            // $diff = now()->diffInMinutes($heureDebut, false);
            $heureDebut = Carbon::parse($matiere->heure_debut);
            $envoi = $heureDebut->subSeconds(10);

            // if ((int)$diff === -1) {
                EnvoyerRappelJob::dispatch($matiere)->delay($envoi);
            // }
        }
    }
}
