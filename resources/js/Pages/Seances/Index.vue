<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    matiere: Object,
    seances: Array,
    notes: Array,
});
console.log(props.notes)

const items = [
    { name: 'Accueil', url: route('dashboard') },
    { name: 'Universités', url: route('universites') },
];
if (props.matiere.filiere.site.universite.sites.length > 1) {
    items.push(
        { 
            name: props.matiere.filiere.site.universite.nom,
            url: route('sites.choix', props.matiere.filiere.site.universite) 
        },
        { 
            name: props.matiere.filiere.site.nom,
            url: route('mes.filieres', props.matiere.filiere.site)
        },
    )
}
else {
    items.push(
        {
            name: props.matiere.filiere.site.universite.nom,
            url: route('sites.choix', props.matiere.filiere.site.universite)
        }
    )
}
items.push(
    { 
        name: props.matiere.filiere.libelle,
        url: route('mes.matieres', props.matiere.filiere)
    },
    { name: props.matiere.intitule }
);

function getJour(int) {
    const jours = [
        'Lundi', 'Mardi', 'Mercredi', 'Jeudi',
        'Vendredi', 'Samedi', 'Dimanche'
    ];
    return jours[int -1];
}
</script>

<template>
    <DashboardLayout>
        <Head title="Séances de " />

        <Breadcrumb :items="items" />

        <ul class="nav nav-tabs mx-auto my-4 gap-3" id="myTab" role="tablist" style="width: max-content">
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest active fw-bold" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                        type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                    La séance
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest fw-bold" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                    Les notes des étudiants
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest fw-bold" id="profile-tab" data-bs-toggle="tab" data-bs-target="#seance-tab-pane">
                    Détails des séances
                </button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="my-5 d-flex flex-column justify-content-center align-items-center gap-4">
                    <h4>Séance de {{ getJour(props.matiere.jour) }}</h4>
                </div>
            </div>

            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

                <form>

                    <table class="table table-striped mx-auto" style="width: 900px">
                        <thead>
                            <tr class="text-decoration-underline">
                                <th>Étudiants</th>
                                <th>Devoir</th>
                                <th>Partiel</th>
                                <th>Autre note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="props.notes.length === 0">
                                <td colspan="4">
                                    <h5 class="text-center text-danger-emphasis">
                                        Veuillez d'abord importer la liste des étudiants.
                                    </h5>
                                </td>
                            </tr>
                            <tr v-else v-for="etudt in props.notes" :key="etudt.id">
                                <td>{{ etudt.nom + ' ' + etudt.prenom }}</td>
                                <td>
                                    <input type="number" class="form-control" min="0" max="20" style="width: 110px;"
                                        v-model="something">
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <div v-if="props.notes.length > 0" class="my-4 d-flex justify-content-center">
                        <button type="submit" class="btn btn-secondary w-25">
                            <i class="fas fa-save"></i>
                            Enregistrer
                        </button>
                    </div>
                </form>

            </div>

            <div class="tab-pane fade" id="seance-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <table class="table table-striped w-50 mx-auto my-4">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Intervalle</th>
                            <th>Temps</th>
                            <th>Voir plus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="props.seances.length === 0">
                            <td colspan="4">
                                <h5 class="text-center">Vous n'avez pas encore eu de séances pour ce cours.</h5>
                            </td>
                        </tr>
                        <tr v-else v-for="seance in props.seances" :key="seance.id">
                            <td>{{ seance.date }}</td>
                            <td>{{ seance.heure_fin + ' - ' + seance.heure_fin }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </DashboardLayout>
</template>