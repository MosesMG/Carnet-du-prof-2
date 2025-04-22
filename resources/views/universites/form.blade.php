@extends('layout')

@section('title', (!$universite->id ? 'Ajouter' : 'Éditer') . ' une université')

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
                {{ !$universite->id ? 'Ajouter' : 'Éditer' }} une université
            </h5>
        </div>

        <div class="card px-5 py-4 mx-auto mt-5" style="max-width: 500px">

            @if (!$universite->id)
                <form action="{{ route('admin.universites.store') }}" method="post">
                    @csrf
            @else
                <form action="{{ route('admin.universites.update', $universite) }}" method="post">
                    @csrf
            @endif
    
                <div class="input-group input-group-static mb-5">
                    <label>Nom</label>
                    <input type="text" name="nom" class="form-control" 
                        value="{{ $universite->nom }}" required />
                </div>
    
                <div class="input-group input-group-static mb-5">
                    <label>Description</label>
                    <input type="text" name="description" class="form-control" value="{{ $universite->description }}">
                </div>
    
                <div class="input-group input-group-static mb-5">
                    <label>Téléphone</label>
                    <input type="tel" name="telephone" class="form-control" 
                        value="{{ $universite->telephone }}" required />
                </div>
    
                <div class="row justify-content-evenly">
                    <button type="submit" class="btn btn-info mb-0 col-5">
                        @if (!$universite->id)
                            Ajouter    
                        @else
                            Éditer
                        @endif
                    </button>

                    <a href="{{ route('admin.universites.index') }}" class="btn btn-danger mb-0 col-5">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection