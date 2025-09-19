<?php

namespace App\Console\Commands;

use App\Jobs\EnvoiRappelJob;
use App\Jobs\GetAllUsersJob;
use App\Models\Rappel;
use App\Models\Seance;
use App\Services\SeanceService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

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
    protected $description = 'Envoi automatique des rappels pour les séances du jour';

    public function __construct(protected SeanceService $seanceService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->seanceService->creerSeances();
        $this->info('Séances créées et rappels planifiés avec succès');
    }
}
