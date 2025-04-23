<div class="table-responsive p-0">

    <div class="d-flex justify-content-center align-items-center gap-3 my-3">
        <p class="mb-0 text-dark fw-bold">Choisir un niveau</p>
        <select name="niveau" wire:model.live="niveau" class="border rounded-3 px-3 py-2">
            <option value="">Tous les niveaux</option>
            <option value="L">Licence</option>
            <option value="M">Master</option>
            <option value="D">Doctorat</option>
        </select>
    </div>

    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-dark text-sm font-weight-bolder">Libellé</th>
                <th class="text-uppercase text-dark text-sm font-weight-bolder ps-2">Description</th>
                <th class="text-center text-uppercase text-dark text-sm font-weight-bolder">
                    Niveau
                </th>
                <th class="text-center text-uppercase text-dark text-sm font-weight-bolder">
                    Options
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($filieres as $filiere)
                <tr>
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-1 small">{{ $filiere->libelle }}</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="small font-weight-bold mb-0">
                            {{ $filiere->description}}
                        </p>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <p class="small font-weight-bold mb-0">
                            {{ $filiere->niveau->description }}
                        </p>
                    </td>
                    <td class="align-middle text-center">
                        <a href="{{ route('admin.filieres.edit',
                            ['site' => $site, 'filiere' => $filiere]) }}" 
                            class="text-xxs btn btn-info mb-0 px-3 py-2" title="Modifier">
                            <i class="fa fa-pen"></i>
                        </a>

                        <button type="button" class="text-xxs btn btn-danger mb-0 px-3 py-2 ms-3" title="Supprimer"
                            data-bs-toggle="modal" data-bs-target="#modal{{ $filiere->id }}" onclick="">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>

                        
                <div class="modal fade" id="modal{{ $filiere->id }}" tabindex="-1" role="dialog" aria-labelledby="modal{{ $filiere->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title font-weight-normal" id="modal-title{{ $filiere->id }}">Confirmer la suppression</h6>
                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{ route('admin.filieres.destroy', 
                                ['site' => $site, 'filiere' => $filiere]) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="filiere" id="filiere" value="{{ $filiere->id }}">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <h4 class="text-gradient text-danger">Voulez-vous continuer ?</h4>
                                        <p>
                                            Toutes les informations concernant cette filière vont être supprimées.
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