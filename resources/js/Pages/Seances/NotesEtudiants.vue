<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    notes: Array,
    matiere: Object,
})

const form = useForm({
    notes: props.notes.map(e => ({
        etudiant_id: e.etudiant_id,
        matiere_id: props.matiere.id,
        devoir: e.devoir ?? 0,
        partiel: e.partiel ?? 0,
        autre: e.autre ?? 0
    }))
})

const activeInput = ref(null);

const isEditable = (index, field) => {
    return activeInput.value === `${index}_${field}`;
}

const enableInput = (index, field) => {
    activeInput.value = `${index}_${field}`;
}

const disableInput = () => {
    activeInput.value = null;
}

const vFocus = {
    mounted(el) {
        el.focus();
    },
    updated(el) {
        el.focus();
    },
};

const saveNotes = () => {
    form.put(route('etudiant.notes', props.matiere));
}
</script>


<template>
    <form @submit.prevent="saveNotes">
        <table class="table table-striped mx-auto" style="width: 900px">
            <thead>
                <tr class="text-decoration-underline">
                    <th>Étudiants</th>
                    <th class="text-center">Devoir</th>
                    <th class="text-center">Partiel</th>
                    <th class="text-center">Autre note</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="props.notes.length === 0">
                    <tr>
                        <td colspan="4">
                            <h5 class="text-center text-danger-emphasis">
                                Veuillez d'abord importer la liste des étudiants.
                            </h5>
                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr v-for="(note, i) in form.notes" :key="note.etudiant_id">
                        <td style="font-size: 15px;">{{ props.notes[i].nom + ' ' + props.notes[i].prenom }}</td>
                        <td>
                            <div @click="enableInput(i, 'devoir')" 
                                class="position-relative mx-auto" style="width: max-content;">
                                <input type="number" class="form-control no-spinner" min="0" max="20" 
                                    style="width: 100px;" v-model="form.notes[i].devoir"
                                    :disabled="!isEditable(i, 'devoir')" @blur="disableInput"
                                    v-if="isEditable(i, 'devoir')" v-focus />
                     
                                <input type="number" :value="form.notes[i].devoir" disabled v-else
                                    class="form-control no-spinner" style="width: 100px;" />
                                
                                <i class="fa fa-pen text-cyan-700"></i>
                            </div>
                        </td>
                        <td>
                            <div @click="enableInput(i, 'partiel')" 
                                class="position-relative mx-auto" style="width: max-content;">
                                <input type="number" class="form-control no-spinner" min="0" max="20"
                                    style="width: 100px;" v-model="form.notes[i].partiel"
                                    :disabled="!isEditable(i, 'partiel')" @blur="disableInput"
                                    v-if="isEditable(i, 'partiel')" v-focus />

                                <input type="number" :value="form.notes[i].partiel" disabled v-else
                                    class="form-control no-spinner" style="width: 100px;" />
                                    
                                <i class="fa fa-pen text-cyan-700"></i>
                            </div>
                        </td>
                        <td>
                            <div @click="enableInput(i, 'autre')" 
                                class="position-relative mx-auto" style="width: max-content;">
                                <input type="number" class="form-control no-spinner" min="0" max="20"
                                    style="width: 100px;" v-model="form.notes[i].autre"
                                    :disabled="!isEditable(i, 'autre')" @blur="disableInput"
                                    v-if="isEditable(i, 'autre')" v-focus />

                                <input type="number" :value="form.notes[i].autre" disabled v-else
                                    class="form-control no-spinner" style="width: 100px;" />
                                
                                <i class="fa fa-pen text-cyan-700"></i>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>

        <div v-if="props.notes.length > 0" class="my-4 d-flex justify-content-center">
            <button type="submit" class="btn btn-secondary w-25" :disabled="form.processing">
                <i class="fas fa-save me-1"></i>
                Enregistrer
            </button>
        </div>
    </form>
</template>

<style scoped>
.fa-pen {
    position: absolute;
    right: 15px;
    bottom: 16px;
    font-size: 10px;
    cursor: pointer;
}

.no-spinner::-webkit-outer-spin-button,
.no-spinner::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.no-spinner {
    -moz-appearance: textfield;
}
</style>
