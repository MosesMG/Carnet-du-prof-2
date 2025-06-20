<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Rappel;
use App\Models\Seance;
use App\Models\Matiere;
use App\Mail\RappelSeance;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;

class EnvoiRappelJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Matiere $matiere, public User $user)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $oneHour = now()->addMinutes(4);

        // $matieres = $this->user->matieres()->with('filiere.site.universite')
        //                 ->where('jour', '=', now()->isoWeekday())
        //                 ->where('heure_debut', '=', $oneHour->format('H:i'))
        //                 ->get();

        // foreach ($this->matieres as $matiere) {
        try {
            $existe = $this->matiere->seances()
                            ->whereDate('date', '=',  now()->toDateString())
                            ->exists();

            if (!$existe) {

                $seance = Seance::create([
                    'date' => now()->toDateString(),
                    'heure_debut' => null,
                    'heure_fin' => null,
                    'matiere_id' => $this->matiere->id,
                ]);

                Mail::to($this->user->email)->send(new RappelSeance($this->matiere, $this->user));

                Rappel::create([
                    'titre' => "Rappel",
                    'message' => 'Cours de ' . $this->matiere->intitule . ' de ' .
                            Carbon::parse($this->matiere->heure_debut)->format('H:i') . ' à ' .
                            Carbon::parse($this->matiere->heure_fin)->format('H:i'),
                    'seance_id' => $seance->id,
                ]);
            }
        // }
        }
        catch (\Exception $e) {
            Log::error("Erreur d'envoi de rappel" . $e->getMessage());
            throw $e;
        }
    }
}
