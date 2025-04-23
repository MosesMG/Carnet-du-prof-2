@extends('layout')

@section('title', 'Accueil')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbar')
@endsection

@section('content')
    <div class="container">
        <div class="bg-gradient-info shadow-primary border-radius-lg py-3 my-4 w-100">
            <h5 class="text-white ps-3 mb-0">Quelques informations</h5>
        </div>

        <div class="d-flex justify-content-center align-items-center min-vh-50">

            <div class="row justify-content-evenly w-100 gap-5">
    
                <div class="card col-8 col-lg-4">
                    <div class="card-header mx-4 p-3 text-center">
                        <button class="btn btn-info mb-0 py-3">
                            <i class="fa fa-users"></i>
                        </button>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h5 class="text-center mb-0">Nombre d'utilisateurs</h5>
                        <span class="text-3xl">{{ $users }}</span>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            Voir plus
                        </a>
                    </div>
                </div>
    
                <div class="card col-8 col-lg-4">
                    <div class="card-header mx-4 p-3 text-center">
                        <button class="btn btn-info mb-0 py-3">
                            <i class="fa fa-school"></i>
                        </button>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h5 class="text-center mb-0">Nombre total d'universités</h5>
                        <span class="text-3xl">{{ $universites }}</span>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('admin.universites.index') }}" class="btn btn-secondary">
                            Voir plus
                        </a>
                    </div>
                </div>
    
            </div>

        </div>

    </div>
@endsection
