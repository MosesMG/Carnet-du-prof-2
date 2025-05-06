<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    filiere: Object,
    etudiants: Array,
    tauxHr: Number,
})

const form = useForm({
    taux_hr: props.tauxHr
})

const submit = () => {
    form.put(route('filiere.tauxhr', props.filiere))
}
</script>

<template>

    <h3 class="text-center my-5">Autres informations</h3>

    <div class="card mx-auto" style="max-width: 400px">
        <div class="card-body fs-5">
            <div class="d-flex justify-content-between">
                Effectif de la salle :
                <span class="text-success-emphasis">{{ props.etudiants.length }} étudiant(e)s</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                Taux horaire :
                <button type="button" class="btn btn-link fs-5" title="Fixer le taux horaire" data-bs-toggle="modal"
                    data-bs-target="#tauxhr">
                    <span v-if="!props.tauxHr">Fixer</span>
                    <span v-else>{{ props.tauxHr }} FCFA</span>
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tauxhr" tabindex="-1" aria-labelledby="tauxhrLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-dark fs-5">
                <div class="modal-header fw-bold">
                    Fixer le taux horaire pour la filière {{ props.filiere.libelle }}
                </div>
                
                <form @submit.prevent="submit">
                    <div class="modal-content p-4">
                        <div class="input-group">
                            <label for="taux_hr" class="input-group-text">Saisir le montant</label>
                            <input type="number" name="taux_hr" min="0" class="form-control"
                                v-model="form.taux_hr">
                            <span v-if="form.errors.taux_hr" class="small">{{ form.errors.taux_hr }}</span>
                        </div>
                    </div>
                    <div class="modal-footer p-1">
                        <button type="submit" data-bs-dismiss="modal" class="btn btn-primary" :disabled="form.processing">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>
