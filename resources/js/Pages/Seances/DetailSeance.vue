<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head } from '@inertiajs/vue3';
import TimeSeance from './Includes/TimeSeance.vue';
import PresenceNote from './Includes/PresenceNote.vue';
import InfoSeance from './Includes/InfoSeance.vue';


const props = defineProps({
    seance: Object,
    matiere: Object,
    etudiants: Array,
    presences: Array,
});

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
    { 
        name: props.matiere.intitule,
        url: route('matiere.seance', props.matiere)
    },
    { name: 'Sénces' }
);

function dateToFr(date) {
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}
</script>

<template>
    <DashboardLayout>
        <Head title="Détails sur une séance" />

        <Breadcrumb :items="items" />

        <h4 class="text-center my-4">Séance du {{ dateToFr(new Date(props.seance.date)) }}</h4>

        <ul class="nav nav-tabs mx-auto mb-4 gap-3" id="myTab" role="tablist" style="width: max-content">
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest active fw-bold" id="one-tab" data-bs-toggle="tab"
                    data-bs-target="#one-tab-pane" type="button" role="tab" aria-controls="one-tab-pane"
                    aria-selected="true">
                    La séance
                </button>
            </li>

            <template v-if="props.seance && !props.seance.heure_fin">
                <li class="nav-item" role="presentation">
                    <button class="btn btn-pinterest fw-bold" id="two-tab" data-bs-toggle="tab" data-bs-target="#two-tab-pane"
                        type="button" role="tab" aria-controls="two-tab-pane" aria-selected="false">
                        Présence & Note
                    </button>
                </li>
            </template>
           
            <template v-if="props.seance && props.seance.heure_fin">
                <li class="nav-item" role="presentation">
                    <button class="btn btn-pinterest fw-bold" id="three-tab" data-bs-toggle="tab" data-bs-target="#three-tab-pane"
                        type="button" role="tab" aria-controls="three-tab-pane" aria-selected="true">
                        Autres informations
                    </button>
                </li>
            </template>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="one-tab-pane" role="tabpanel" 
                aria-labelledby="home-tab" tabindex="0">

                <TimeSeance :matiere="props.matiere" :seance="props.seance" />
            </div>

            <template v-if="props.seance && !props.seance.heure_fin">
                <div class="tab-pane fade" id="two-tab-pane" role="tabpanel" 
                        aria-labelledby="profile-tab" tabindex="0">
    
                    <PresenceNote :etudiants="props.etudiants" :matiere="props.matiere" :seance="props.seance" />
                </div>
            </template>

            <template v-if="props.seance && props.seance.heure_fin">
                <div class="tab-pane fade" id="three-tab-pane" role="tabpanel" 
                        aria-labelledby="other-tab" tabindex="0">
    
                    <InfoSeance :presences="props.presences" />
                </div>
            </template>
        </div>

    </DashboardLayout>
</template>
