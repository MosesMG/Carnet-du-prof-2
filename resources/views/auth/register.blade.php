@extends('layout')

@section('title', 'Inscription')

@section('content')

    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="card d-flex flex-column gap-5 w-100 py-4" style="max-width: 400px">
            
            <h3 class="fs-3 fw-bold mx-auto" style="width: max-content">Inscription</h3>
            
            <div class="px-4">
                @if (session('message'))
                    <p class="small text-danger text-center mb-2">{{ session('message') }}</p>
                @endif

                <form action="" method="post" class="d-flex flex-column mx-auto">
                    @csrf

                    <div class="mb-4">
                        <div class="input-group input-group-outline">
                            <label class="form-label" for="name">Nom</label>
                            <input type="name" name="name" id="name" class="form-control" required>
                        </div>
                        @error('name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="input-group input-group-outline">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <div class="input-group input-group-outline">
                            <label class="form-label" for="password">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="input-group input-group-outline">
                            <label class="form-label" for="password">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password" class="form-control" required>
                        </div>
                        @error('password_confirmation')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mx-3">
                        <a href="{{ route('admin.login') }}" class="small underline">Se connecter</a>
                        <button type="submit" class="btn btn-info mb-0">Inscription</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection