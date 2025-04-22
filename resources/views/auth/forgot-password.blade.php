@extends('layout')

@section('title', 'Mot de passe oublié')

@section('content')

    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="card d-flex flex-column gap-5 w-100 py-4" style="max-width: 400px">
            
            <div>
                <h3 class="fs-3 fw-bold mx-auto" style="width: max-content">Mot de passe oublié</h3>
                <p class="my-2 text-center small">
                    Saisissez votre adresse e-mail pour recevoir un lien de réinitialisation de votre mot de passe
                </p>
            </div>
            
            <div class="px-4">
                @if (session('status'))
                    <p class="small text-success text-center mb-2">{{ session('status') }}</p>
                @endif

                <form action="{{ route('admin.password.email') }}" method="post" class="d-flex flex-column mx-auto">
                    @csrf

                    <div class="mb-4">
                        <div class="input-group input-group-outline">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mx-3">
                        <a href="{{ route('admin.login') }}" class="small underline">Connexion</a>
                        <button type="submit" class="btn btn-info mb-0">Recevoir le lien</button>
                    </div>
                </form>
                
            </div>

        </div>
    </div>

@endsection