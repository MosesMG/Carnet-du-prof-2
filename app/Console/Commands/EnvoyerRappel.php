<?php

namespace App\Console\Commands;

use App\Jobs\GetAllUsersJob;
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
    protected $description = 'Envoi automatique des rappels pour les séances du jour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new GetAllUsersJob());
        $this->info('Envoi des rappels déclenché.');
    }
}
