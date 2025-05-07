<?php

namespace App\Http\Controllers\User;

use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MatiereRequest;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MatiereController extends Controller
{
    public function mesMatieres(string $filiere)
    {
        $filiere = Filiere::with('matieres', 'niveau', 'site.universite.sites')->find($filiere);

        $user = auth()->guard('web')->user();

        $matieres = $user->matieres()->with('filiere')
                        ->where('filiere_id', '=', $filiere->id)->get()
                        ->map(function ($matiere) {
                            $matiere->jour_mat = Matiere::jourSemaine($matiere->jour);
                            return $matiere;
        });

        $etudiants = Etudiant::where('filiere_id', '=', $filiere->id)
                            ->orderBy('nom')->get();

        $tauxHr = $matieres->first()->pivot->taux_hr ?? 0;

        return inertia('Matieres/Index', [
            'filiere' => $filiere,
            'matieres' => $matieres,
            'etudiants' => $etudiants,
            'tauxhr' => $tauxHr,
        ]);
    }

    public function storeMatiere(string $filiere, MatiereRequest $request)
    {
        $filiere = Filiere::find($filiere);

        $credentials = $request->validated();

        $matiere = Matiere::create($credentials);
        $matiere->users()->attach(auth()->guard('web')->id());

        return redirect()->route('mes.matieres', $filiere);
    }

    public function updateMatiere(string $filiere, string $matiere, MatiereRequest $request)
    {
        $filiere = Filiere::find($filiere);
        $matiere = Matiere::find($matiere);

        $credentials = $request->validated();

        $matiere->update($credentials);

        return redirect()->route('mes.matieres', $filiere);
    }

    public function deleteMatiere(string $filiere, string $matiere)
    {
        $filiere = Filiere::find($filiere);
        $matiere = Matiere::find($matiere);

        $matiere->delete();

        return redirect()->route('mes.matieres', $filiere);
    }


    // Les étudiants
    public function importEtudiants(string $filiere, Request $request)
    {
        $filiere = Filiere::find($filiere);

        $request->validate([
            'etudiants' => 'required|file|mimes:xls,xlsx'
        ]);

        $fichier = $request->file('etudiants');

        $feuille = IOFactory::load($fichier);
        $datas = $feuille->getActiveSheet()->toArray();

        // Retirer l'en-tête du tableau
        $etudiants = array_slice($datas, 1);

        foreach ($etudiants as $data) {

            Etudiant::create([
                'nom' => $data[0],
                'prenom' => $data[1],
                'sexe' => $data[2],
                'telephone' => $data[3],
                'email' => $data[4],
                'filiere_id' => $filiere->id,
            ]);
        }
        return back();
    }
    
    // Le taux horaire
    public function tauxHoraire(Request $request, string $filiere)
    {
        $filiere = Filiere::find($filiere);
        
        $validated = $request->validate([
            'taux_hr' => 'required|integer|min:0',
        ]);
        $tauxhr = $validated['taux_hr'];

        $user = auth()->guard('web')->user();

        $matieresId = $user->matieres()->with('filiere')
                        ->where('filiere_id', '=', $filiere->id)
                        ->pluck('matieres.id')->toArray();
        
        $datas = [];
        foreach ($matieresId as $id) {
            $datas[$id] = ['taux_hr' => $tauxhr];
        }

        $user->matieres()->syncWithoutDetaching($datas);

        return back();
    }

    // // Les séances
    // public function lesSeances(string $matiere): View
    // {
    //     $matiere = Matiere::with('seances', 'filiere')->find($matiere);
    //     $noteUn = Etudiant::where('filiere_id', '=', $matiere->filiere->id)
    //                         ->orderBy('etudiants.nomEtu')->get();

    //     $noteDeux = Etudiant::where('matiere_id', '=', $matiere->id)
    //                         ->join('notes', 'etudiants.id', '=', 'notes.etudiant_id')
    //                         ->select()->orderBy('etudiants.nomEtu')->get();

    //     $notes = ($noteDeux->count() === 0) ? $noteUn : $noteDeux;

    //     $seances = Seance::where('matiere_id', '=', $matiere->id)
    //                     ->where('etatSeance', '=', 1)
    //                     ->orderBy('dateSeance', 'desc')->get();

    //     return view('user.seances.index', [
    //         'matiere' => $matiere,
    //         'notes' => $notes,
    //         'seances' => $seances,
    //     ]);
    // }

    // public function showSeance(string $matiere, string $seance): RedirectResponse|View
    // {
    //     $matiere = Matiere::with('seances', 'filiere')->find($matiere);
    //     $seance = Seance::find($seance);
    //     $etudiants = Etudiant::where('filiere_id', '=', $matiere->filiere->id)
    //                             ->orderBy('nomEtu')->get();

    //     if($etudiants->count() == 0) {
    //         return back()->with('success', "Importez d'abord la liste des étudiants.");
    //     }

    //     $debut = new DateTime($seance->heureDeb);
    //     $now = new DateTime('now');
        
    //     if ($seance->heureFin == '00:00:00' || $seance->heureFin == '') {
    //         $intervalle = $debut->diff($now);
    //     }
    //     else {
    //         $fin = new DateTime($seance->heureFin);
    //         $intervalle = $debut->diff($fin);

    //         $etudtsSeance = Seance::where('id', '=', $seance->id)->with('etudiants')->first();
    //     }

    //     $hr = $intervalle->days * 24 + $intervalle->h;
    //     $min = $intervalle->i;

    //     return view('user.seances.show', [
    //         'matiere' => $matiere,
    //         'seance' => $seance,
    //         'etudiants' => $etudiants,
    //         'temps' => [
    //             'hr' => $hr,
    //             'min' => $min,
    //         ],
    //         'presents' => $etudtsSeance ?? null,
    //     ]);
    // }

    // public function startSeance(string $matiere): RedirectResponse
    // {
    //     $matiere = Matiere::find($matiere);
    //     $etudiants = Etudiant::where('filiere_id', '=', $matiere->filiere->id)
    //                             ->orderBy('nomEtu')->get();

    //     if($etudiants->count() == 0) {
    //         return back()->with('success', "Importez d'abord la liste des étudiants.");
    //     }

    //     Seance::create([
    //         'dateSeance' => now()->format('Y-m-d'),
    //         'heureDeb' => now()->format('H:i'),
    //         'heureFin' => '',
    //         'etatSeance' => 0,
    //         'detailSeance' => '',
    //         'matiere_id' => $matiere->id,
    //     ]);

    //     $seance = Seance::where('matiere_id', '=', $matiere->id)
    //                         ->orderBy('id', 'desc')->first();

    //     Notification::create([
    //         'message' => 'Cours de '.$matiere->intitule .' de '. 
    //                     Carbon::parse($matiere->debMat)->format('H:i') .' à '. 
    //                     Carbon::parse($matiere->finMat)->format('H:i'),
    //         'seance_id' => $seance->id,
    //     ]);

    //     return redirect()->route('seance.show', [
    //         'matiere' => $matiere,
    //         'seance' => $seance
    //     ])->with( 'success', "La séance a démarré !");
    // }

    // public function stopSeance(Request $request, string $matiere, string $seance): RedirectResponse
    // {
    //     $matiere = Matiere::find($matiere);
    //     $seance = Seance::find($seance);

    //     $resume = $request->detailSeance;
    //     $presence = $request->presence;
    //     $notes = $request->notes;

    //     $seance->update([
    //         'heureFin' => now()->format('H:i'),
    //         'detailSeance' => $resume,
    //         'etatSeance' => 1,
    //     ]);

    //     $etudiants = Etudiant::where('filiere_id', '=', $matiere->filiere->id)
    //                         ->orderBy('nomEtu')->get();

    //     foreach ($etudiants as $etudt) {

    //         DB::table('etudiant_seance')->insert([
    //             'etudiant_id' => $etudt->id,
    //             'seance_id' => $seance->id,
    //             'presence' => in_array($etudt->id, $presence) ? 1 : 0,
    //             'plus' => $notes[$etudt->id],
    //         ]);
    //     }

    //     return redirect()->route('matiere.seance', $matiere)->with(
    //         'success', 'Séance terminée !',
    //     );
    // }

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
