<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site;
use Illuminate\View\View;
use App\Models\Universite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id): View
    {
        $universite = Universite::find($id);
        $sites = Site::where('universite_id', '=', $id)->get();

        return view('sites.index', [
            'universite' => $universite,
            'sites' => $sites,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id): View
    {
        $universite = Universite::find($id);

        return view('sites.form', [
            'universite' => $universite,
            'site' => new Site(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id, Request $request): RedirectResponse
    {
        $universite = Universite::find($id);

        $credentials = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'numeric', 'digits:8'],
            'ville' => ['required', 'string', 'max:255'],
            'quartier' => ['required', 'string', 'max:255'],
            'universite_id' => ['required', 'numeric', 'exists:universites,id'],
        ]);

        Site::create($credentials);

        return redirect()->route('admin.sites.index', $universite)->with(
            'message', 'Site créé avec succès.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $universite, string $site): View
    {
        $universite = Universite::find($universite);
        $site = Site::find($site);

        return view('sites.show', [
            'universite' => $universite,
            'site' => $site
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $universite, string $site): View
    {
        $universite = Universite::find($universite);
        $site = Site::find($site);

        return view('sites.form', [
            'universite' => $universite,
            'site' => $site,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $universite, string $site): RedirectResponse
    {
        $universite = Universite::find($universite);
        $site = Site::find($site);

        $credentials = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'numeric', 'digits:8'],
            'ville' => ['required', 'string', 'max:255'],
            'quartier' => ['required', 'string', 'max:255'],
            'universite_id' => ['required', 'numeric', 'exists:universites,id'],
        ]);

        $site->update($credentials);

        return redirect()->route('admin.sites.index', $universite)->with(
            'message', 'Modifications effectuées avec succès.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $universite, string $site): RedirectResponse
    {
        $universite = Universite::find($universite);
        $site = Site::find($site);

        $site->delete();

        return redirect()->route('admin.sites.index', $universite)->with(
            'message', 'Suppression effectuée avec succès.'
        );
    }
}
