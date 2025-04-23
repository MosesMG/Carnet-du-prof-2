@extends('layout')

@section('title', 'Les utilisateurs')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbar')
@endsection

@section('content')

    <div class="container">
        <div class="bg-gradient-info shadow-primary border-radius-lg py-3 my-4 w-100">
            <h5 class="text-white ps-3 mb-0">Liste des utilisateurs</h5>
        </div>

        @if (session('message'))
            <p class="text-center text-success font-weight-bold">{{ session('message') }}</p>
        @endif
        
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary font-weight-bolder ps-2">Nom</th>
                            <th class="text-center text-uppercase text-secondary font-weight-bolder">
                                Email
                            </th>
                            <th class="text-center text-uppercase text-secondary font-weight-bolder">
                                Staut
                            </th>
                            <th class="text-center text-uppercase text-secondary font-weight-bolder">
                                Plus
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <p class="text-sm mb-0 text-dark font-weight-bold">
                                        @if ($user->sexe == 'M')
                                            M.
                                        @elseif ($user->sexe == 'F')
                                            Mme.
                                        @endif
                                        {{ $user->name }}
                                    </p>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-sm text-dark">{{ $user->email }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    @if ($user->is_active)
                                        <span class="badge badge-sm bg-gradient-success">Activé</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-danger">Désctivé</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('admin.user.show', $user) }}" 
                                        class="text-info text-sm text-decoration-underline">
                                        Voir plus
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
