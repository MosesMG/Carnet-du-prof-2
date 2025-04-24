<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import { ref } from 'vue';

defineProps({
    filiere : Object,
    matieres: Array,
})

const showForm = ref(false);
const showDelete = ref(false);
const selected = ref(null);

const form = useForm({
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
                        <div class="p-3">
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

                                    <InputError class="mt-2" :message="form.errors.intitule" />
                                </div>
                

                                <div class="mb-4">
                                    <InputLabel for="description" value="Description" class="text-left fs-5 form-label" />

                                    <TextInput
                                        id="description"
                                        type="text"
                                        class="form-control"
                                        v-model="matiere.description"
                                    />

                                    <InputError class="mt-2" :message="form.errors.description" />
                                </div>

                                <div class="mb-4">

                                    <InputLabel for="jour" value="Jour" class="text-left fs-5 form-label" />

                                    <select v-model="matiere.jour" class="form-control">
                                        <option v-for="(jour, index) in jours" :value="index" :key="index">
                                            {{ jour }}
                                        </option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.jour" />
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

            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">2</div>

            <div class="tab-pane fade" id="others-tab-pane" role="tabpanel" aria-labelledby="others-tab" tabindex="0">3</div>
        </div>

    </DashboardLayout>

</template>