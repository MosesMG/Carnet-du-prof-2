@extends('layout')

@section('title', 'Les filières')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbar')
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center my-4">
            <div class="bg-gradient-info shadow-primary border-radius-lg py-3 w-100">
                <h5 class="text-white ps-3 mb-0">Liste des filières</h5>
            </div>
    
            <div class="mx-5 w-25">
                <a href="{{ route('admin.filieres.create', $site) }}" class="btn btn-success mb-0">
                    <i class="fa fa-plus me-1"></i>
                    Ajouter
                </a>
            </div>
        </div>

        @if (session('message'))
            <p class="text-center text-success font-weight-bold">{{ session('message') }}</p>
        @endif

        <div class="card-body px-0 pb-2">
                            
            <livewire:filieres id="{{ $site->id }}" />

        </div>
    </div>
@endsection
