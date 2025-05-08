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
}
