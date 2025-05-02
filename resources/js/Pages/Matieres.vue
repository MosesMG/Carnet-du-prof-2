<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();

defineProps({
    filiere : Object,
    matieres: Array,
    etudiants: Array,
});

const showForm = ref(false);
const showDelete = ref(false);
const selected = ref(null);

const formOne = useForm({
    intitule: '',
    description: '',
    jour: 1,
    heure_debut: '',
    heure_fin: '',
    filiere_id: '',
});

const matiere = ref({
    intitule: '',
    description: '',
    jour: 1,
    heure_debut: '',
    heure_fin: '',
    filiere_id: '',
})

const jours = {
    1: 'Lundi',
    2: 'Mardi',
    3: 'Mercredi',
    4: 'Jeudi',
    5: 'Vendredi',
    6: 'Samedi',
    7: 'Dimanche'
}


function openForm(mat = null) {
    if (mat) {
        matiere.value = { ...mat }
    } else {
        matiere.value = { intitule: '', description: '', jour: 1, heure_debut: '', heure_fin: '' }
    }
    showForm.value = true
}

function submitForm() {
    if (matiere.value.id) {
        router.put('matieres.update', [filiere, matiere], {
            onSuccess: () => (showForm.value = false),
        });
    } else {
        router.post('matieres.store', filiere, {
            onSuccess: () => (showForm.value = false),
        });
    }
}

// Ouverture du modal de suppression
function openDelete(matiere) {
    selected.value = matiere;
    showDelete.value = true;
}

// Confirmation suppression
function confirmDelete() {
    if (matiere) {
        router.delete('matieres.delete', {
            onSuccess: () => (showDelete.value = false),
        });
    }
}

function formatHeure(heure) {
    const [h, m] = heure.split(':');
    return `${h}:${m}`;
}

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

        <ul class="nav nav-tabs mx-auto my-4 gap-3" id="myTab" role="tablist" style="width: max-content;">
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
                <div class="d-flex justify-content-lg-around flex-wrap justify-content-sm-center">
                    <h4 class="ms-5 mb-0">Les matières de la filière {{ filiere.libelle }}</h4>
        
                    <div>
                        <button type="button" class="nav nav-link" @click="openForm()">
                            <i class="fas fa-plus-square"></i>
                            Ajouter une matière
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <table class="table table-striped my-4 w-75">
                        <thead>
                            <tr class="text-center">
                                <th class="text-decoration-underline">Intitulé</th>
                                <th class="text-decoration-underline">Jour</th>
                                <th class="text-decoration-underline">Heures</th>
                                <th class="text-decoration-underline">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="matiere in matieres" :key="matiere.id" class="text-center">
                                <td>{{ matiere.intitule }}</td>
                                <td>{{ matiere.jour_mat }}</td>
                                <td>{{ formatHeure(matiere.heure_debut) + ' - ' + formatHeure(matiere.heure_fin) }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-5">
                                        <button type="button" title="Éditer" class="text-primary-emphasis" @click="openForm(matiere)">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                        <button type="button" title="Supprimer" class="text-danger-emphasis" @click="openDelete(matiere)">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Formulaire -->
                <Modal :show="showForm" @close="showForm = false">
                    <template  #default>
                        <div class="px-8 py-3">
                            <h3 class="mb-4 text-center">
                                {{ !matiere.id ? 'Ajouter une' : 'Éditer la' }} matière
                            </h3>

                            <form @submit.prevent="submitForm">
                                
                                <div class="mb-4">
                                    <InputLabel for="intitule" value="Intitulé" class="text-left fs-5 form-label" />

                                    <TextInput
                                        id="intitule"
                                        type="text"
                                        class="form-control"
                                        v-model="matiere.intitule"
                                        required
                                    />

                                    <InputError class="mt-2" :message="formOne.errors.intitule" />
                                </div>
                

                                <div class="mb-4">
                                    <InputLabel for="description" value="Description" class="text-left fs-5 form-label" />

                                    <TextInput
                                        id="description"
                                        type="text"
                                        class="form-control"
                                        v-model="matiere.description"
                                    />

                                    <InputError class="mt-2" :message="formOne.errors.description" />
                                </div>

                                <div class="mb-4">

                                    <InputLabel for="jour" value="Jour" class="text-left fs-5 form-label" />

                                    <select v-model="matiere.jour" class="form-control">
                                        <option v-for="(jour, index) in jours" :value="index" :key="index">
                                            {{ jour }}
                                        </option>
                                    </select>

                                    <InputError class="mt-2" :message="formOne.errors.jour" />
                                </div>

                                <div class="row justify-content-between mb-5">
                                    <div class="col-6">
                                        <InputLabel for="heure_debut" value="Heure de début" class="text-left fs-5 form-label" />

                                        <TextInput
                                            id="heure_debut"
                                            type="time"
                                            class="form-control"
                                            v-model="matiere.heure_debut"
                                        />
                                    </div>

                                    <div class="col-6">
                                        <InputLabel for="heure_fin" value="Heure de fin" class="text-left fs-5 form-label" />

                                        <TextInput
                                            id="heure_fin"
                                            type="time"
                                            class="form-control"
                                            v-model="matiere.heure_fin"
                                        />
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="button" class="btn btn-secondary me-3" @click="showForm = false">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </template>
                </Modal>

                 <!-- Modal Confirmation Suppression -->
                <Modal :show="showDelete" @close="showDelete = false">
                    <template #default>
                        <div class="modal-content p-4">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmer la suppression</h5>
                                <button type="button" class="btn-close" @click="showDelete = false"></button>
                            </div>
                            <div class="modal-body my-4">
                                <p>Voulez-vous vraiment supprimer la matière {{ matiere.intitule }} ?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary me-3" @click="showDelete = false">Annuler</button>
                                <button class="btn btn-danger" @click="confirmDelete">Supprimer</button>
                            </div>
                        </div>
                    </template>
                </Modal>
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
                            <!-- <span class="text-success-emphasis">{{ $etudiants->count() }} étudiant(e)s</span> -->
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
