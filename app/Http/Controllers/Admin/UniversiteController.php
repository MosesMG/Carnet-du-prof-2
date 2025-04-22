<?php

namespace App\Http\Controllers\Admin;

use App\Models\Universite;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UniversiteResource;

class UniversiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $universites = UniversiteResource::collection(Universite::all());
        return view('universites.index', [
            'universites' => collect($universites)->sortBy('nom')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('universites.form', [
            'universite' => new Universite(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:universites,nom,except,id',
            'description' => 'nullable|string',
            'telephone' => 'required|numeric|digits:8'
        ]);

        Universite::create($validated);

        return redirect()->route('admin.universites.index')
                        ->with('message', 'Ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $universite = Universite::find($id);

        return view('universites.show', [
            'universite' => $universite,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $universite = Universite::find($id);

        return view('universites.form', [
            'universite' => $universite,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $universite = Universite::find($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:universites,nom,except,id',
            'description' => 'nullable|string',
            'telephone' => 'required|numeric|digits:8'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $universite = Universite::find($id);
        $universite->delete();

        return to_route('admin.universites.index')->with(
            'message', 'Suppression effectuée avec succès.'
        );
    }
}
