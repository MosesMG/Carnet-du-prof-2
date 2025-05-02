@extends('layout')

@section('title', 'ERREUR !')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center vh-100">
        <p class="fs-3 text-dark text-uppercase mb-0">Page non trouvée !</p>
        <div>
            <img src="{{ asset('images/error-404.png') }}" alt="error" width="350">
        </div>
        <div>
            <a href="{{ route('admin.accueil') }}" class="btn btn-info">
                <i class="fa fa-arrow-left me-2"></i>
                Revenir à l'accueil
            </a>
        </div>
    </div>
@endsection
