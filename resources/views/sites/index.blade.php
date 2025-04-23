@extends('layout')

@section('title', 'Sites universitaires')

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
                <h5 class="text-white ps-3 mb-0">Liste des sites de l'université {{ $universite->nom }}</h5>
            </div>
    
            <div class="mx-5 w-25">
                <a href="{{ route('admin.sites.create', $universite) }}" class="btn btn-success mb-0">
                    <i class="fa fa-plus me-1"></i>
                    Ajouter
                </a>
            </div>
        </div>

        @if (session('message'))
            <p class="text-center text-success font-weight-bold">{{ session('message') }}</p>
        @endif

        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-dark text-sm font-weight-bolder">Nom</th>
                            <th class="text-uppercase text-dark text-sm font-weight-bolder ps-2">Téléphone</th>
                            <th class="text-center text-uppercase text-dark text-sm font-weight-bolder">
                                Ville
                            </th>
                            <th class="text-center text-uppercase text-dark text-sm font-weight-bolder">
                                Quartier
                            </th>
                            <th class="text-center text-uppercase text-dark text-sm font-weight-bolder">
                                Options
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sites as $site)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-1 small">{{ $site->nom }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="small font-weight-bold mb-0">
                                        {{ $site->telephone }}
                                    </p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="small font-weight-bold mb-0">
                                        {{ $site->ville }}
                                    </p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="small font-weight-bold mb-0">
                                        {{ $site->quartier }}
                                    </p>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('admin.sites.edit',
                                        ['universite' => $universite, 'site' => $site]) }}" 
                                        class="text-xxs btn btn-info mb-0 px-3 py-2" title="Modifier">
                                        <i class="fa fa-pen"></i>
                                    </a>

                                    <button type="button" class="text-xxs btn btn-danger mb-0 px-3 py-2 ms-2" title="Supprimer"
                                        data-bs-toggle="modal" data-bs-target="#modal{{ $site->id }}" onclick="">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>

                                    <a href="{{ route('admin.sites.show',
                                    ['universite' => $universite, 'site' => $site]) }}" 
                                        class="text-xxs btn btn-warning mb-0 px-3 py-2 ms-2">
                                        Plus
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>

                                    
                            <div class="modal fade" id="modal{{ $site->id }}" tabindex="-1" role="dialog" aria-labelledby="modal{{ $site->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title font-weight-normal" id="modal-title{{ $site->id }}">Confirmer la suppression</h6>
                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.sites.destroy', 
                                            ['universite' => $universite, 'site' => $site]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="site" id="site" value="{{ $site->id }}">
                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4 class="text-gradient text-danger">Voulez-vous continuer ?</h4>
                                                    <p>
                                                        Toutes les informations concernant ce site vont être supprimées.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn bg-gradient-danger mb-0">Confirmer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
