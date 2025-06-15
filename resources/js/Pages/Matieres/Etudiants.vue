<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    filiere: Object,
    etudiants: Array,
})

const form = useForm({
    etudiants: null,
})

// Bouton pour charger le fichier Excel
const labelFile = ref('Charger le fichier Excel');
const inputFile = ref(null)
const fichier = ref(null)

const openInput = () => {
    if (inputFile.value) {
        inputFile.value.click()
    }
}

const updateFile = (event) => {
    const file = event.target.files[0];
    if(file) {
        fichier.value = file;

        const typesExcel = [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        if (!typesExcel.includes(file.type)) {
            labelFile.value = "Sélectionner un fichier Excel !";
            return
        }

        labelFile.value = 'Fichier chargé';
    }
    else {
        fichier.value = null;
    }
}

const uploadStudentFile = () => {
    form.etudiants = fichier.value;
    form.post(route('import.etudiants', props.filiere))
}
</script>

<template>
    <div class="d-flex justify-content-lg-around flex-wrap justify-content-sm-center">
        <h4 class="ms-5 mb-0">Les étudiants de la filière {{ filiere.libelle }} </h4>

        <div v-if="etudiants.length == 0">
            <form @submit.prevent="uploadStudentFile">
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
                        <button type="submit" ref="sendBtn" :disabled="(labelFile !== 'Fichier chargé') || form.processing"
                            class="btn btn-outline-primary px-3 py-2">
                            Importer
                            <i class="fas fa-file-import"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="my-4">
        <table class="table table-striped">
            <thead>
                <tr class="text-center">
                    <th class="text-decoration-underline">Nom</th>
                    <th class="text-decoration-underline">Prénom(s)</th>
                    <th class="text-decoration-underline">Sexe</th>
                    <th class="text-decoration-underline">Téléphone</th>
                    <th class="text-decoration-underline">Email</th>
                </tr>
            </thead>

            <tbody>
                <tr v-if="etudiants.length == 0">
                    <td colspan="6">
                        <div class="card mt-5">
                            <p class="fs-5 text-danger-emphasis text-center my-4">
                                L'en-tête du fichier Excel contenant la liste des étudiants doit respecter l'ordre
                                ci-dessus.
                                <br />Veuillez vérifier celà avant d'importer le fichier.
                            </p>
                        </div>
                    </td>
                </tr>

                <tr class="text-center" v-for="etudiant in etudiants" :key="etudiant.id" v-else>
                    <td class="text-uppercase">{{ etudiant.nom }}</td>
                    <td>{{ etudiant.prenom }}</td>
                    <td>{{ etudiant.sexe }}</td>
                    <td>{{ etudiant.telephone }}</td>
                    <td>{{ etudiant.email }}</td>
                </tr>
            </tbody>
        </table>
    </div>
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
