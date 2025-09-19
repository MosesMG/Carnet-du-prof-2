<?php

namespace App\Jobs;

use App\Mail\TestEnvoiMail;
use App\Models\Rappel;
use App\Models\Seance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;

class EnvoiRappelJob implements ShouldQueue
{
    use Queueable;

    public $user;
    public $seance;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, Seance $seance)
    {
        $this->user = $user;
        $this->seance = $seance;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->seance->heure_debut == null || $this->seance->heure_fin == null) {
            return;
        }

        Mail::to($this->user->email)->send(new TestEnvoiMail($this->seance->toArray()));

        Rappel::create([
            'titre' => "Rappel",
            'message' => 'Cours de ' . $this->seance->matiere->intitule . ' de ' .
                Carbon::parse($this->seance->matiere->heure_debut)->format('H:i') . ' à ' .
                Carbon::parse($this->seance->matiere->heure_fin)->format('H:i'),
            'seance_id' => $this->seance->id,
        ]);
    }
}
