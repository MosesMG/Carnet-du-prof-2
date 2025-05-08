<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'


const props = defineProps({
    filiere: {
        type: Object,
        required: true
    },
    matieres: {
        type: Array,
        default: () => []
    }
})

function formatHeure(heure) {
    const [h, m] = heure.split(':');
    return `${h}:${m}`;
}


const showFormModal = ref(false)
const showDeleteModal = ref(false)

const isEditMode = ref(false)
const editingMatiere = ref(null)
const selectedMatiere = ref(null)

const form = useForm({
    intitule: '',
    description: '',
    jour: 1,
    heure_debut: '',
    heure_fin: '',
    filiere_id: props.filiere.id,
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

const openCreateModal = () => {
    isEditMode.value = false
    editingMatiere.value = null
    form.reset()
    showFormModal.value = true
}

const openEditModal = (matiere) => {
    isEditMode.value = true
    editingMatiere.value = matiere
    form.intitule = matiere.intitule
    form.description = matiere.description
    form.jour = matiere.jour
    form.heure_debut = matiere.heure_debut
    form.heure_fin = matiere.heure_fin
    form.filiere_id = matiere.filiere_id
    showFormModal.value = true
}

const openDeleteModal = (matiere) => {
    selectedMatiere.value = matiere
    showDeleteModal.value = true
}

const submitForm = () => {
    if (isEditMode.value && editingMatiere.value) {
        form.patch(route('matieres.update', {
            'filiere': props.filiere,
            'matiere': editingMatiere.value.id
        }), {
            onSuccess: () => {
                showFormModal.value = false
                form.reset()
            }
        })
    } else {
        form.post(route('matieres.store', props.filiere), {
            onSuccess: () => {
                showFormModal.value = false
                form.reset()
            }
        })
    }
}

const confirmDelete = () => {
    form.delete(route('matieres.delete', {
            'filiere': props.filiere,
            'matiere': selectedMatiere.value.id,
        }), {
        onSuccess: () => {
            showDeleteModal.value = false
        }
    })
}
</script>


<template>
 
    <div>
        <div class="d-flex justify-content-lg-around flex-wrap justify-content-sm-center">
            <h4 class="ms-5 mb-0">Les matières de la filière {{ filiere.libelle }}</h4>

            <div>
                <button type="button" class="nav nav-link" @click="openCreateModal">
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
                    <tr v-for="matiere in props.matieres" :key="matiere.id" class="text-center">
                        <td>
                            <Link :href="route('matiere.seance', matiere)" class="text-dark fw-medium text-decoration-underline">
                                {{ matiere.intitule }}        
                            </Link>
                        </td>
                        <td>{{ matiere.jour_mat }}</td>
                        <td>{{ formatHeure(matiere.heure_debut) + ' - ' + formatHeure(matiere.heure_fin) }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-5">
                                <button type="button" title="Éditer" class="text-success"
                                    @click="openEditModal(matiere)">
                                    <i class="fa fa-pen"></i>
                                </button>
                                <button type="button" title="Supprimer" class="text-danger"
                                    @click="openDeleteModal(matiere)">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modale Ajout/Modification -->
        <Modal :show="showFormModal" @close="showFormModal = false">
            <div class="p-4">
                <h4 class="mb-4 text-center">
                    {{ isEditMode ? 'Modifier la' : 'Ajouter une' }} matière
                </h4>

                <form @submit.prevent="submitForm">

                    <div class="mb-4">
                        <InputLabel for="intitule" value="Intitulé" class="text-left fs-5 form-label" />

                        <TextInput id="intitule" type="text" class="form-control" v-model="form.intitule"
                            required />

                        <InputError class="mt-2" :message="form.errors.intitule" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="description" value="Description" class="text-left fs-5 form-label" />

                        <TextInput id="description" type="text" class="form-control"
                            v-model="form.description" />

                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="jour" value="Jour" class="text-left fs-5 form-label" />

                        <select v-model="form.jour" class="form-control" required>
                            <option v-for="(jour, index) in jours" :value="index" :key="index">
                                {{ jour }}
                            </option>
                        </select>

                        <InputError class="mt-2" :message="form.errors.jour" />
                    </div>

                    <div class="row justify-content-between mb-5">
                        <div class="col-6">
                            <InputLabel for="heure_debut" value="Heure de début"
                                class="text-left fs-5 form-label" />

                            <TextInput id="heure_debut" type="time" class="form-control"
                                v-model="form.heure_debut" required />
                        </div>

                        <div class="col-6">
                            <InputLabel for="heure_fin" value="Heure de fin" class="text-left fs-5 form-label" />

                            <TextInput id="heure_fin" type="time" class="form-control" v-model="form.heure_fin"
                                required />
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-3"
                            @click="showFormModal = false">Annuler</button>
                            
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Modale Confirmation Suppression -->
        <Modal :show="showDeleteModal" @close="showDeleteModal = false">
            <div class="modal-content p-4">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" @click="showDeleteModal = false"></button>
                </div>
                <div class="modal-body my-4">
                    <p>Voulez-vous vraiment supprimer la matière <strong>{{ selectedMatiere.intitule }}</strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary me-3" @click="showDeleteModal = false">Annuler</button>
                    <button class="btn btn-danger" @click="confirmDelete">Supprimer</button>    
                </div>
            </div>
        </Modal>
    </div>

</template>
