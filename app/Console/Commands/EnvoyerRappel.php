<?php

namespace App\Console\Commands;

use App\Jobs\EnvoyerRappelJob;
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
                            ->where('jour', '=', $today)
                            ->orderBy('heure_debut')->get();

        foreach ($aujMatieres as $matiere) {
            $heureDebut = now()->copy()->setTimeFromTimeString($matiere->heure_debut);
            $diff = now()->diffInMinutes($heureDebut, false);

            if ($diff === -10) {
                EnvoyerRappelJob::dispatch($matiere);
            }
        }
    }
}
