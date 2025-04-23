@extends('layout')

@section('title', 'Profil')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbar')
@endsection

@section('content')
    <div class="container">
        <div class="bg-gradient-info shadow-primary border-radius-lg py-3 w-100 my-4">
            <h5 class="text-white ps-3 mb-0">Paramètres du profil</h5>
        </div>

        <div class="row justify-content-evenly">

            <div class="col-4">

                <h4 class="text-center my-3">Mettre à jour mon profil</h4>
        
                <form method="post" action="{{ route('admin.profile.update') }}" class="mt-4">
                    @csrf
                    @method('patch')
            
                    <div class="input-group input-group-static mb-4">
                        <label for="name" class="fw-bold">Nom & Prénom(s) :</label>
                        <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $admin->name) }}" required />
                        @error('name')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>
        
                    <div class="input-group input-group-static mb-4">
                        <label for="email" class="fw-bold">Email :</label>
                        <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $admin->email) }}" required />
                        @error('email')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <div class="d-flex align-items-center gap-4">
                        <button type="submit" class="btn btn-secondary mb-0">Enregistrer</button>
            
                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2500)"
                                class="text-success mb-0 fw-bold"
                            >{{ __('Enregistré avec succès !') }}</p>
                        @endif
                    </div>
                </form>

                <div class="my-5">
                    <h4 class="text-center my-2">Supprimer mon compte</h4>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete">
                            <i class="fas fa-trash-alt"></i>
                            SUPPRIMER
                        </button>
                    </div>
    
                    {{-- Modal suppession --}}
                    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content text-dark">
                                <div class="modal-header fw-bold fs-4">
                                    Cette action est irréversible
                                </div>
                                <form action="{{ route('admin.profile.destroy') }}" method="post">
                                    @method('DELETE')
                                    @csrf

                                    <div class="modal-content p-4">
                                        <div class="input-group input-group-static">
                                            <label for="password" class="fs-6 mb-3">Entrez votre mot de passe pour supprimer le compte</label>
                                            <input type="password" name="password" id="password" class="form-control" required>
                                        </div>
                                        @error('password')
                                            <span class="small text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Annuler</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 d-flex flex-column justify-content-between">

                <div>
                    <h4 class="text-center my-3">Mettre à jour le mot de passe</h4>
    
                    <form method="post" action="{{ route('admin.password.update') }}" class="mt-4">
                        @csrf
                        @method('put')
                
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="small text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="input-group input-group-static mb-4">
                            <label for="update_password_current_password" class="fw-bold">Mot de passe actuel :</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="form-control" required />
                            @error('current_password')
                                <span class="small text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                
                        <div class="input-group input-group-static mb-4">
                            <label for="update_password_password" class="fw-bold">Nouveau mot de passe :</label>
                            <input id="update_password_password" name="password" type="password" class="form-control" required />
                            @error('password')
                                <span class="small text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                
                        <div class="input-group input-group-static mb-4">
                            <label for="update_password_password_confirmation" class="fw-bold">Confirmer le nouveau mot de passe :</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" required />
                            @error('password_confirmation')
                                <span class="small text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                
                        <div class="d-flex align-items-center gap-4">
                            <button type="submit" class="btn btn-primary mb-0">Sauvegarder</button>
                
                            @if (session('status') === 'password-updated')
                                <p 
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2500)"
                                    class="text-success mb-0 fw-bold">
                                    Enregistré avec succès !</p>
                            @endif
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection
