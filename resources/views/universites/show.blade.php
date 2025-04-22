@extends('layout')

@section('title', "Détails sur l'université")

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbar')
@endsection

@section('content')
    <div class="container">

        {{ $universite }}

    </div>
@endsection