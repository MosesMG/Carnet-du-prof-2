@extends('layout')

@section('title', (!$site->id ? 'Ajouter' : 'Éditer') . ' un site')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbar')
@endsection

@section('content')
    <div class="container">
        <div class="bg-gradient-info shadow-primary border-radius-lg py-3 my-4">
            <h5 class="text-white ps-3 mb-0">
                {{ !$site->id ? 'Ajouter' : 'Éditer' }} un site
            </h5>
        </div>

        <div class="card px-5 py-4 mx-auto mt-5" style="max-width: 500px">

            @if (!$site->id)
                <form action="{{ route('admin.sites.store', $universite) }}" method="post">
                    @csrf
            @else
                <form action="{{ route('admin.sites.update',
                    ['universite' => $universite, 'site' => $site]) }}" method="post">
                    @method('PUT')
                    @csrf
            @endif
    
                <div class="input-group input-group-static mb-5">
                    <label>Nom</label>
                    <input type="text" name="nom" class="form-control" 
                        value="{{ $site->nom }}" required />
                    @error('nom')
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror
                </div>
    
                <div class="input-group input-group-static mb-5">
                    <label>Téléphone</label>
                    <input type="tel" name="telephone" class="form-control" 
                        value="{{ $site->telephone }}" required />
                    @error('telephone')
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-5">
                    <label>Ville</label>
                    <input type="text" name="ville" class="form-control" value="{{ $site->ville }}" required>
                    @error('ville')
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-5">
                    <label>Quartier</label>
                    <input type="text" name="quartier" class="form-control" value="{{ $site->quartier }}" required>
                    @error('quartier')
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <input type="hidden" name="universite_id" value="{{ $universite->id }}">

                <div class="row justify-content-evenly">
                    <button type="submit" class="btn btn-info mb-0 col-5">
                        @if (!$site->id)
                            Ajouter    
                        @else
                            Éditer
                        @endif
                    </button>

                    <a href="{{ route('admin.sites.index', $universite) }}" class="btn btn-danger mb-0 col-5">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
