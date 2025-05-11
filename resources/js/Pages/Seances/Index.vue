<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    matiere: Object,
    seances: Array,
    notes: Array,
});
// console.log(props.notes)

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

function getTodayAsNumber() {
    const today = new Date();
    const jsDay = today.getDay();
    return jsDay === 0 ? 7 : jsDay;
}
const today = getTodayAsNumber();
// console.log(today, props.matiere.jour);

function formatHeure(heure) {
    const [h, m] = heure.split(':');
    return `${h}:${m}`;
}

const form = useForm ({});
function startSeance() {
    form.post(route('seance.start', props.matiere));
}

function dateToFr(date) {
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

function diffHeure(h1, h2) {
    h1 = String(h1).slice(0, 8);
    h2 = String(h2).slice(0, 8);

    const [h1Hour, h1Min, h1Sec] = h1.split(':').map(Number);
    const [h2Hour, h2Min, h2Sec] = h2.split(':').map(Number);

    if ([h1Hour, h1Min, h2Hour, h2Min].some(isNaN)) {
        console.error("Heures invalides :", h1, h2);
        return "Heures invalides";
    }

    const date1 = new Date(0, 0, 0, h1Hour, h1Min, h1Sec || 0);
    const date2 = new Date(0, 0, 0, h2Hour, h2Min, h2Sec || 0);

    let diffMs = Math.abs(date2 - date1);
    const diffMinutes = Math.floor(diffMs / 60000);
    const hours = Math.floor(diffMinutes / 60);
    const minutes = diffMinutes % 60;

    return `${hours}h ${minutes}min`;
}
</script>

<template>
    <DashboardLayout>
        <Head :title="'Cours de ' + props.matiere.intitule" />

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

            <!-- Séance -->
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="my-5 d-flex flex-column justify-content-center align-items-center gap-3">
                    <h4>Séance de {{ getJour(props.matiere.jour) }}</h4>
                    <p>Prévue de 
                        {{ formatHeure(props.matiere.heure_debut) + ' à ' + formatHeure(props.matiere.heure_fin) }}
                    </p>

                    <p v-if="props.notes.length === 0" class="text-danger-emphasis">
                        Veuillez d'abord importer la liste des étudiants.
                    </p>

                    <form @submit.prevent="startSeance">
                        <button type="submit" class="btn btn-secondary text-uppercase fs-5" 
                            :disabled="props.notes.length === 0 || today !== props.matiere.jour">
                            Débuter la séance
                        </button>
                    </form>
                </div>
            </div>

            <!-- Notes -->
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

                <form>

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
                                <tr v-for="etudt in props.notes" :key="etudt.id">
                                    <td style="font-size: 15px;">{{ etudt.nom + ' ' + etudt.prenom }}</td>
                                    <td>
                                        <input type="number" class="form-control mx-auto" min="0" max="20"
                                            style="width: 100px;">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control mx-auto" min="0" max="20"
                                            style="width: 100px;">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control mx-auto" min="0" max="20"
                                            style="width: 100px;">
                                    </td>
                                </tr>
                            </template>
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

            <!-- Détails -->
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
                            <td>{{ dateToFr(new Date (seance.date)) }}</td>
                            <td>{{ formatHeure(seance.heure_debut) + ' - ' + formatHeure(seance.heure_fin) }}</td>
                            <td>{{ diffHeure(seance.heure_fin, seance.heure_debut) }}</td>
                            <td>
                                <Link :href="route('seance.show', {
                                    matiere: props.matiere, seance: seance
                                })">
                                Voir plus
                                <i class="fa fa-arrow-right"></i>
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </DashboardLayout>
</template>