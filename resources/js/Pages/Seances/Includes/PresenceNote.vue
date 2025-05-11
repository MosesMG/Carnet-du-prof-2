<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    etudiants: Array,
    matiere: Object,
    seance: Object,
});

const form = useForm({
    participations: props.etudiants.map(e => ({
        etudiant_id: e.id,
        presence: false,
        plus: 0,
    }))
});

const enregistrer = () => {
    form.put(route('seance.infos', {
        matiere: props.matiere,
        seance: props.seance,
    }), {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="d-flex justify-content-center" style="margin: 100px auto;">
        <button type="button" class="btn btn-primary fs-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Afficher la liste des étudiants
        </button>
    </div>

    <form @submit.prevent="enregistrer">
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Liste des étudiants</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Étudiants</th>
                                    <th class="text-center">Présence</th>
                                    <th class="text-center">Plus / Moins</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(p, i) in form.participations" :key="p.etudiant_id">
                                    <td style="font-size: 15px;">
                                        {{ props.etudiants[i].nom.toUpperCase() + ' ' + props.etudiants[i].prenom }}
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="presence" class="form-check mx-auto"
                                            v-model="form.participations[i].presence">
                                    </td>
                                    <td>
                                        <input type="number" name="plus" class="form-control mx-auto py-2"
                                            style="width: 90px;" v-model="form.participations[i].plus"
                                            min="-20" max="20">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">
                            Enregistrer
                            <i class="fa fa-save ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</template>

<style scoped>
.table-hover tr td {
    padding-top: 7px !important;
    padding-bottom: 7px !important;
}
</style>
