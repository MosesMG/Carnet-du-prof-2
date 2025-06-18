<?php

namespace App\Jobs;

use App\Mail\RappelSeance;
use App\Models\Matiere;
use App\Models\Rappel;
use App\Models\Seance;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EnvoyerRappelJob implements ShouldQueue
{
    use Queueable;

    public $matiere;

    /**
     * Create a new job instance.
     */
    public function __construct(Matiere $matiere)
    {
        $this->matiere = $matiere;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $seance = Seance::firstOrCreate([
            'matiere_id' => $this->matiere->id,
            'date' => today()->toDateString(),
        ], [
            'heure_debut' => null,
            'heure_fin' => null,
        ]);

        $existe = Rappel::where('seance_id', '=', $seance->id)->exists();

        if (!$existe) {
            Rappel::create([
                'titre' => "Rappel",
                'message' => 'Cours de ' . $this->matiere->intitule . ' de ' .
                        Carbon::parse($this->matiere->heure_debut)->format('H:i') . ' à ' .
                        Carbon::parse($this->matiere->heure_fin)->format('H:i'),
                'seance_id' => $seance->id,
            ]);

            $user = Auth::guard('web')->user();
            Mail::to($user->email)->send(new RappelSeance($this->matiere, $user));
        }
    }
}
