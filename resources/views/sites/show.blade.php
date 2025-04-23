@extends('layout')

@section('title', "Détails sur le site $site->nom")

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbar')
@endsection

@section('content')
    <div class="container">
        <div class="bg-gradient-info shadow-primary border-radius-lg py-3 w-100 my-5">
            <h5 class="text-white ps-3 mb-0">Site {{ $site->nom }}</h5>
        </div>
        
        <div class="row justify-content-center gap-7">

            <div class="card col-4">
                <div class="card-header mx-4 p-3 text-center">
                    <button class="btn btn-info mb-0 py-3">
                        <i class="fa fa-school"></i>
                    </button>
                </div>
                <div class="card-body pt-0 p-3 text-center">
                    <h5 class="text-center mb-0">Nombre de filières</h5>
                    <span class="text-3xl">{{ $site->filieres->count() }}</span>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-center my-5">
            <a href="{{ route('admin.filieres.index', $site) }}" class="btn btn-info">
                Voir les filières
            </a>
        </div>

    </div>
@endsection
