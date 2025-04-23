@extends('layout')

@section('title', "Infos d'un utilisateur")

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbar')
@endsection

@section('content')

    <style>
        hr {
            margin: 10px 0;
        }
        .card {
            width: 450px;
            max-width: 700px;
        }
        .informations div span:nth-child(2) {
            font-size: 19px;
            font-weight: 600;
        }
    </style>

    <div class="container">

        <div class="bg-gradient-info shadow-primary border-radius-lg py-3 w-100 my-5">
            <h5 class="text-white ps-3 mb-0">Utilisateur {{ $user->name }}</h5>
        </div>

        @if (session('message'))
            <p class="text-center text-success font-weight-bold">{{ session('message') }}</p>
        @endif

        <div class="d-flex justify-content-evenly align-items-center">

            <div>
                <p class="text-decoration-underline text-center text-uppercase fs-4">Informations</p>

                <div class="card">
                    <div class="card-body text-dark my-2 informations">
                        <div>
                            <span>Nom :</span>
                            <span>{{ strtoupper($user->name) }}</span>
                        </div>
                        <hr>
                        <div>
                            <span>Sexe :</span>
                            <span>{{ $user->sexe }}</span>
                        </div>
                        <hr>
                        <div>
                            <span>Téléphone :</span>
                            <span>{{ $user->telephone }}</span>
                        </div>
                        <hr>
                        <div>
                            <span>Email :</span>
                            <span>{{ $user->email }}</span>
                        </div>
                        <hr>
                        <div>
                            <span>Date de naissance :</span>
                            <span>{{ date_format(date_create($user->datenais), 'd/m/Y') }}</span>
                        </div>
                        <hr>
                        <div>
                            <span>Date d'inscription :</span>
                            <span>{{ date_format(date_create($user->created_at), 'd/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="align-self-baseline">
                <p class="text-decoration-underline text-center text-uppercase fs-4">Actions</p>

                <div class="d-flex flex-column gap-4 mt-5">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#message">
                        <i class="fas fa-paper-plane"></i>
                        Notifier l'utilisateur
                    </button>

                    @if ($user->is_active)

                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#block">
                            <i class="fas fa-ban"></i>
                            Bloquer l'utilisateur
                        </button>

                    @else

                        <form action="{{ route('admin.free.user', $user) }}" method="post">
                            @csrf

                            <p class="text-danger text-center mb-0" style="margin-top: -15px">Utilisateur bloqué</p>
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-ban"></i>
                                Débloquer l'utilisateur
                            </button>
                        </form>
                        
                    @endif
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete">
                        <i class="fas fa-trash-alt"></i>
                        Supprimer l'utilisateur
                    </button>
                </div>

            </div>


            {{-- Modal Bloquer --}}
            <div class="modal fade" id="block" tabindex="-1" aria-labelledby="blockLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-dark">
                        <div class="modal-header fw-bold">
                            Bloquer l'utilisateur {{ $user->name }} ?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('admin.block.user', $user) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success">Oui</button>
                            </form>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Non</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Mail --}}
            <div class="modal fade" id="message" tabindex="-1" aria-labelledby="messageLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-dark">
                        <div class="modal-header fw-bold">
                            Envoyer un message à l'utilisateur {{ $user->name }}
                        </div>
                        <form action="{{ route('admin.user.email', $user) }}" method="post">
                            @csrf

                        <div class="modal-body">
                            <textarea rows="5" name="message" class="form-control border p-2"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">
                                Envoyer
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal Supprimer --}}
            <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-dark">
                        <div class="modal-header fw-bold">
                            Supprimer l'utilisateur {{ $user->name }} ?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('admin.delete.user', $user) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-success">Oui</button>
                            </form>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Non</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
@endsection
