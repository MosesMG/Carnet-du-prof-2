<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import ListeMatieres from './ListeMatieres.vue';


const props = defineProps({
    filiere : Object,
    matieres: Array,
    etudiants: Array,
});

const formul = useForm({
    etudiants: '',
})

// Bouton pour charger le fichier Excel
const labelFile = ref('Charger le fichier Excel');
const inputFile = ref(null)
const fichier = ref(null)

function openInput() {
    if (inputFile.value) {
        inputFile.value.click()
    }
}

function updateFile(event) {
    const file = event.target.files[0];
    if(file) {
        fichier.value = file;
        labelFile.value = 'Fichier chargé';
    }
    else {
        fichier.value = null;
    }
}

function envoyerFichier() {
    // const file = etudiants.value?.files[0];
    if (!fichier.value) return
    // {
        // alert('Sélectionner un fichier Excel !');
    // }
    // console.log('Fichier : ', file); 
}
const uploadStudentFile = () => {
    // formul.post(route())
}

</script>


<template>

    <DashboardLayout>

        <Head title="Les matières" />

        <ul class="nav nav-tabs mx-auto mb-4 gap-3" id="myTab" role="tablist" style="width: max-content;">
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest active fw-bold" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                    Les matières
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest fw-bold" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                    Les étudiants
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest fw-bold" id="others-tab" data-bs-toggle="tab" data-bs-target="#others-tab-pane"
                    type="button" role="tab" aria-controls="others-tab-pane" aria-selected="false">
                    Autres informations
                </button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            
            <!-- Les matières -->
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                <ListeMatieres :filiere="props.filiere" :matieres="props.matieres" />
                
            </div>


            <!-- Les étudiants -->
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <div class="d-flex justify-content-lg-around flex-wrap justify-content-sm-center">
                    <h4 class="ms-5 mb-0">Les étudiants de la filière {{ filiere.libelle }} </h4>
        
                    <!-- @if ($etudiants->count() == 0) -->
                        
                        <div>
                            <form @submit.prevent="uploadStudentFile">
                                <!-- @csrf -->

                                <div class="d-flex align-items-center gap-4">
                                    <div>
                                        <input type="file" name="etudiants" ref="inputFile" class="d-none" @change="updateFile" />
                                        <label for="etudiants" class="bouton" @click="openInput">
                                            <i class="fas fa-download"></i>
                                            {{ labelFile }}
                                        </label>
        
                                        <p v-if="fichier" class="fichier text-secondary op-7 my-0">{{ fichier.name }}</p>
                                    </div>

                                    <div>
                                        <button type="submit" ref="sendBtn" @click="envoyerFichier" :disabled="!fichier"
                                            class="btn btn-outline-primary px-3 py-2">
                                            Importer
                                            <i class="fas fa-file-import"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    <!-- @endif -->
                </div>
        
                <!-- @if (session('success'))
                    <p class="fw-bold text-center text-success my-2">
                        {{ session('success') }}
                    </p>
                @endif -->

                <!-- @if (session('error'))
                    <p class="fw-bold text-center text-danger my-2">
                        {{ session('error') }}
                    </p>
                @endif -->

                <div class="my-4">

                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th class="text-decoration-underline">Nom</th>
                                <th class="text-decoration-underline">Prénom(s)</th>
                                <th class="text-decoration-underline">Sexe</th>
                                <!-- <th class="text-decoration-underline">Date de naissance</th> -->
                                <th class="text-decoration-underline">Téléphone</th>
                                <th class="text-decoration-underline">Email</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- @forelse ($etudiants as $etudiant) -->
                                <tr class="text-center" v-for="etudiant in etudiants" :key="etudiant.id">
                                    <td class="text-uppercase">{{ etudiant.nom }}</td>
                                    <td>{{ etudiant.prenom }}</td>
                                    <td>{{ etudiant.sexe }}</td>
                                    <td>{{ etudiant.telephone }}</td>
                                    <td>{{ etudiant.email }}</td>
                                </tr>
                            <!-- @empty -->
                                <tr>
                                    <td colspan="6">
                                        <div class="card mt-5">
                                            <p class="fs-4 text-danger-emphasis text-center my-4">
                                                Veuillez respecter l'ordre ci-dessus avant d'importer le fichier Excel contenant la liste des étudiants.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            <!-- @endforelse -->
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Autres informations -->
            <div class="tab-pane fade" id="others-tab-pane" role="tabpanel" aria-labelledby="others-tab" tabindex="0">
                <h3 class="text-center my-5">Autres informations</h3>

                <div class="card mx-auto" style="max-width: 400px">
                    <div class="card-body fs-5">
                        <div class="d-flex justify-content-between">
                            Effectif de la salle : 
                            <span class="text-success-emphasis">{{ etudiants.length }} étudiant(e)s</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            Taux horaire :
                            <button type="button" class="btn btn-link fs-5" title="Fixer le taux horaire"
                                    data-bs-toggle="modal" data-bs-target="#tauxhr">
                                   <!-- @if (isset($tauxhr))
                                       {{ $tauxhr['tauxHr'] }} FCFA
                                   @else
                                       Fixer
                                   @endif -->
                                   Fixer
                            </button>

                        </div>
                    </div>
                </div>


                <div class="modal fade" id="tauxhr" tabindex="-1" aria-labelledby="tauxhrLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-dark fs-5">
                            <div class="modal-header fw-bold">
                                Fixer le taux horaire pour la filiere {{ filiere.libelle }}
                            </div>
                            <!-- @if (isset($tauxhr))

                            <form action="{{ route('filiere.modiftauxhr', $filiere) }}" method="post">
                                @method('PATCH')
                                @csrf
                            @else

                            <form action="{{ route('filiere.tauxhr', $filiere) }}" method="post">
                                @csrf
                            
                            @endif -->
                                <div class="modal-content p-4">
                                    <div class="input-group">
                                        <label for="tauxHr" class="input-group-text">Saisir le montant</label>
                                        <input type="number" name="tauxHr" min="0" class="form-control">
                                        <!-- value="{{ $tauxhr['tauxHr'] ?? 0 }}" -->
                                    </div>
                                </div>
                                <div class="modal-footer p-1">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </DashboardLayout>

</template>

<style scoped>
/* Style du le bouton personnalisé */
.bouton {
    display: inline-block;
    cursor: pointer;
}

/* Zone de texte pour afficher le nom du fichier */
.fichier {
    margin-top: 10px;
    font-size: 14px;
    text-align: center;
}
</style>
