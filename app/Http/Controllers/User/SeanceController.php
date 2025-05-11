<?php

namespace App\Http\Controllers\User;

use DateTime;
use App\Models\Seance;
use App\Models\Matiere;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeanceController extends Controller
{
    public function lesSeances(string $matiere)
    {
        $matiere = Matiere::with('seances', 'filiere.site.universite.sites')->find($matiere);

        $noteUn = Etudiant::where('filiere_id', '=', $matiere->filiere->id)
                            ->orderBy('etudiants.nom')->get();

        $noteDeux = Etudiant::where('matiere_id', '=', $matiere->id)
                            ->join('notes', 'etudiants.id', '=', 'notes.etudiant_id')
                            ->select()->orderBy('etudiants.nom')->get();

        $notes = ($noteDeux->count() === 0) ? $noteUn : $noteDeux;

        $seances = Seance::where('matiere_id', '=', $matiere->id)
                        ->orderByDesc('date')->get();

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

        $description = $request->description;

        $seance->update([
            'heure_fin' => now()->format('H:i'),
            'description' => $description,
        ]);

        return redirect()->route('matiere.seance', $matiere);
    }

    // // LES NOTES
    // public function notEtudiants(string $matiere, Request $request): RedirectResponse
    // {
    //     $matiere = Matiere::with('filiere')->find($matiere);
    //     $etudiants = Etudiant::where('filiere_id', '=', $matiere->filiere->id)
    //                             ->orderBy('nomEtu')->with('notes')->get();
        
    //     if($etudiants->count() == 0) {
    //         return back()->with('success', "Importez d'abord la liste des étudiants.");
    //     }       

    //     $lesDevoirs = $request['devNote'];
    //     $lesPartiels = $request['partielNote'];
    //     $lesAutres = $request['autreNote'];

    //     $lesNotes = array_merge($lesDevoirs, $lesPartiels, $lesAutres);

    //     $stockNote = 0;
    //     foreach ($lesNotes as $key => $note) {
    //         if((int)$note !== 0) {
    //             $stockNote++;
    //         }
    //     }

    //     if ($stockNote === 0) {
            
    //         foreach ($etudiants as $etudiant) {
    //             Note::create([
    //                 'devNote' => $lesDevoirs[$etudiant->id],
    //                 'partielNote' => $lesPartiels[$etudiant->id],
    //                 'autreNote' => $lesAutres[$etudiant->id],
    //                 'etudiant_id' => $etudiant->id,
    //                 'matiere_id' => $matiere->id,
    //             ]);
    //         }
    //     }
    //     else {

    //         $notes = Note::where('matiere_id', '=', $matiere->id)->with('etudiant')->get();

    //         if ($notes->count() === 0) {

    //             foreach ($etudiants as $etudiant) {
    //                 Note::create([
    //                     'devNote' => $lesDevoirs[$etudiant->id],
    //                     'partielNote' => $lesPartiels[$etudiant->id],
    //                     'autreNote' => $lesAutres[$etudiant->id],
    //                     'etudiant_id' => $etudiant->id,
    //                     'matiere_id' => $matiere->id,
    //                 ]);
    //             }
    //         }
    //         else {

    //             $j = 1;
    //             foreach ($notes as $note) {
    //                 Note::where('matiere_id', '=', $matiere->id)
    //                     ->where('etudiant_id', '=', $note->etudiant->id)
    //                     ->update([
    //                         'devNote' => $lesDevoirs[$j],
    //                         'partielNote' => $lesPartiels[$j],
    //                         'autreNote' => $lesAutres[$j],
    //                 ]);
    //                 $j++;
    //             }
    //         }
    //     }

    //     return redirect()->route('matiere.seance', $matiere)->with(
    //         'success', "Notes enregistrées avec succès !"
    //     );
    // }
}
