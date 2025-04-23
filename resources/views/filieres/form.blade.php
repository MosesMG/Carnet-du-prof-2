@extends('layout')

@section('title', (!$filiere->id ? 'Ajouter' : 'Éditer') . ' une filiere')

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
                {{ !$filiere->id ? 'Ajouter' : 'Éditer' }} une filiere
            </h5>
        </div>

        <div class="card px-5 py-4 mx-auto mt-5" style="max-width: 500px">

            @if (!$filiere->id)
                <form action="{{ route('admin.filieres.store', $site) }}" method="post">
                    @csrf
            @else
                <form action="{{ route('admin.filieres.update',
                    ['site' => $site, 'filiere' => $filiere]) }}" method="post">
                    @method('PUT')
                    @csrf
            @endif
    
                <div class="input-group input-group-static mb-5">
                    <label>Niveau</label>
                    <select name="niveau_id" class="form-control" required>
                        @foreach ($niveaux as $niveau)
                            <option value="{{ $niveau->id }}" @selected($niveau->id == $filiere->niveau_id)>
                                {{ $niveau->description }}
                            </option>
                        @endforeach
                    </select>
                    @error('niveau')
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror
                </div>
    
                <div class="input-group input-group-static mb-5">
                    <label>Libellé</label>
                    <input type="text" name="libelle" class="form-control" 
                        value="{{ $filiere->libelle }}" required />
                    @error('libelle')
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-5">
                    <label>Description</label>
                    <input type="text" name="description" class="form-control" value="{{ $filiere->description }}">
                    @error('description')
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <input type="hidden" name="site_id" value="{{ $site->id }}">

                <div class="row justify-content-evenly">
                    <button type="submit" class="btn btn-info mb-0 col-5">
                        @if (!$filiere->id)
                            Ajouter    
                        @else
                            Éditer
                        @endif
                    </button>

                    <a href="{{ route('admin.filieres.index', $site) }}" class="btn btn-danger mb-0 col-5">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
