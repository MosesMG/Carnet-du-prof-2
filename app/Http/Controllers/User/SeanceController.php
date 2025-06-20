<?php

namespace App\Http\Controllers\User;

use App\Models\Seance;
use App\Models\Matiere;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Note;

class SeanceController extends Controller
{
    public function lesSeances(string $matiere)
    {
        $matiere = Matiere::with('seances', 'filiere.site.universite.sites')->find($matiere);

        $matiereId = $matiere->id;
        $etudiants = Etudiant::where('filiere_id', '=', $matiere->filiere->id)
                            ->orderBy('nom')->get();

        $notes = $etudiants->map(function ($etudiant) use ($matiereId) {
            $note = $etudiant->notes()->where('matiere_id', $matiereId)->first();
            return [
                'etudiant_id' => $etudiant->id,
                'matiere_id' => $matiereId,
                'nom' => $etudiant->nom,
                'prenom' => $etudiant->prenom,
                'devoir' => $note->devoir ?? null,
                'partiel' => $note->partiel ?? null,
                'autre' => $note->autre ?? null,
            ];
        });

        // $seances = Seance::where('matiere_id', '=', $matiere->id)
        //                 ->orderByDesc('date')->get();

        $user = auth()->guard('web')->user();

        $seances = Seance::with('matiere')
            ->whereDate('date', now()->toDateString())
            ->whereHas('matiere', function ($query) use ($user) {
            $query->whereHas('users', fn ($q) => $q->where('users.id', $user->id));
        })
        ->get()
        ->map(fn ($seance) => [
            'id' => $seance->id,
            'matiere' => $seance->matiere->intitule,
            'date' => $seance->date,
            'heure_debut' => $seance->heure_debut,
            'heure_fin' => $seance->heure_fin,
            'etat' => $seance->etat,
        ]);
        // dd($seances);

        return inertia('Seances/Index', [
            'matiere' => $matiere,
            'notes' => $notes,
            'seances' => $seances,
        ]);
    }
    
    public function showSeance(string $matiere, string $seance)
    {
        $matiere = Matiere::with('seances', 'filiere.site.universite.sites')->find($matiere);
    
        $seance = Seance::find($seance);

        $etudiants = Etudiant::where('filiere_id', '=', $matiere->filiere->id)
                                ->orderBy('nom')->get();

        $etudiantSeance = Seance::with(['etudiants' => function ($q) {
            $q->select('etudiants.id', 'nom', 'prenom')
              ->withPivot('presence', 'plus');
        }])->find($seance);

        return inertia('Seances/DetailSeance', [
            'matiere' => $matiere,
            'seance' => $seance,
            'etudiants' => $etudiants, 
            'presences' => $etudiantSeance,
        ]);
    }

    public function startSeance(string $matiere)
    {
        $matiere = Matiere::find($matiere);

        $seance = Seance::create([
            'date' => now()->format('Y-m-d'),
            'heure_debut' => now()->format('H:i'),
            'matiere_id' => $matiere->id,
        ]);

        return redirect()->route('seance.show', [
            'matiere' => $matiere,
            'seance' => $seance
        ]);
    }

    public function infoSaveSeance(Request $request, string $matiere, string $seance)
    {
        $matiere = Matiere::find($matiere);
        $seance = Seance::find($seance);

        $validated = $request->validate([
            'participations' => 'required|array',
            'participations.*.etudiant_id' => 'required|exists:etudiants,id',
            'participations.*.presence' => 'required|boolean',
            'participations.*.plus' => 'nullable|numeric',
        ]);

        $data = [];

        foreach ($validated['participations'] as $item) {
            $data[$item['etudiant_id']] = [
                'presence' => $item['presence'],
                'plus' => $item['plus'],
            ];
        }

        $seance->etudiants()->syncWithoutDetaching($data);

        return back();
    }

    public function stopSeance(Request $request, string $matiere, string $seance)
    {
        $matiere = Matiere::find($matiere);
        $seance = Seance::find($seance);

        $seance->update([
            'heure_fin' => now()->format('H:i'),
            'description' => $request->description,
        ]);

        return redirect()->route('matiere.seance', $matiere);
    }

    // LES NOTES
    public function notEtudiants(string $matiere, Request $request)
    {
        $matiere = Matiere::with('filiere')->find($matiere);

        $validated = $request->validate([
            'notes' => 'required|array',
            'notes.*.devoir' => 'nullable|numeric|min:0|max:20',
            'notes.*.partiel' => 'nullable|numeric|min:0|max:20',
            'notes.*.autre' => 'nullable|numeric|min:0|max:20',
            'notes.*.etudiant_id' => 'required|exists:etudiants,id',
            'notes.*.matiere_id' => 'required|exists:matieres,id',
        ]);

        foreach ($validated['notes'] as $note) {
            Note::updateOrCreate(
                [
                    'etudiant_id' => $note['etudiant_id'],
                    'matiere_id' => $note['matiere_id'],
                ],
                [
                    'devoir' => $note['devoir'],
                    'partiel' => $note['partiel'],
                    'autre' => $note['autre'],
                ]
            );
        }

        return redirect()->route('matiere.seance', $matiere);
    }
}
