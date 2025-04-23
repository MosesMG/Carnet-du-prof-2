<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site;
use App\Models\Niveau;
use App\Models\Filiere;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id): View
    {
        $site = Site::find($id);

        return view('filieres.index', [
            'site' => $site,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id): View
    {
        $site = Site::find($id);
        $niveaux = Niveau::all();

        return view('filieres.form', [
            'site' => $site,
            'filiere' => new Filiere(),
            'niveaux' => $niveaux,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id, Request $request): RedirectResponse
    {
        $site = Site::find($id);

        $credentials = $request->validate([
            'libelle' => 'required|string|max:200',
            'description' => 'string|nullable',
            'niveau_id' => 'required|integer|exists:niveaux,id',
            'site_id' => 'required|integer|exists:sites,id',
        ]);
        
        Filiere::create($credentials);

        return redirect()->route('admin.filieres.index', $site)->with(
            'message', 'Filière ajoutée avec succès.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $site, string $filiere): View
    {
        $site = Site::find($site);
        $filiere = Filiere::find($filiere);
        $niveaux = Niveau::all();

        return view('filieres.form', [
            'site' => $site,
            'filiere' => $filiere,
            'niveaux' => $niveaux,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $site, string $filiere): RedirectResponse
    {
        $site = Site::find($site);
        $filiere = Filiere::find($filiere);

        $credentials = $request->validate([
            'libelle' => 'required|string|max:200',
            'description' => 'string|nullable',
            'niveau_id' => 'required|integer|exists:niveaux,id',
            'site_id' => 'required|integer|exists:sites,id',
        ]);
        
        $filiere->update($credentials);

        return redirect()->route('admin.filieres.index', $site)->with(
            'message', 'Modifications enregistrées avec succès.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $site, string $filiere): RedirectResponse
    {
        $site = Site::find($site);
        $filiere = Filiere::find($filiere);

        $filiere->delete();

        return redirect()->route('admin.filieres.index', $site)->with(
            'message', 'Suppression effectuée avec succès.'
        );
    }
}
