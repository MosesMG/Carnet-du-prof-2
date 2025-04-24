<?php

namespace App\Http\Controllers\User;

use App\Models\Site;
// use Inertia\Inertia;
use App\Models\Filiere;
use App\Models\Universite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UniversiteController extends Controller
{
    public function index()
    {
        $universites = Universite::withCount('sites')->orderBy('nom')->get();

        return inertia('Universites', [
            'universites' => $universites
        ]);
    }

    public function choixFiliere(string $site)
    {
        $sites = Site::where('universite_id', '=', $site)->orderBy('nom')->get();

        // S'il n'y a qu'un seul site par université, on va directement au choix des filières
        if ($sites->count() == 1) {
            $site = $sites->first();
            $filieres = Filiere::where('site_id', '=', $site->id)->orderBy('libelle')->get();

            return inertia('Filieres', [
                'filieres' => $filieres,
                'universite' => Universite::where('id', '=', $site->universite_id)->first(),
            ]);
        }

        return inertia('Sites', [
            'sites' => $sites,
            'universite' => Universite::where('id', '=', $site)->first(),
        ]);
    }

    public function mesFilieres(string $site)
    {
        $filieres = Filiere::where('site_id', '=', $site)->orderBy('libelle')->get();

        return inertia('Filieres', [
            'filieres' => $filieres,
            'site' => Site::find($site),
        ]);
    }
}
