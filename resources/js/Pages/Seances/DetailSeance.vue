<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref } from 'vue';
import TimeSeance from './Includes/TimeSeance.vue';
import Presence from './Includes/Presence.vue';


const props = defineProps({
    seance: Object,
    matiere: Object,
})

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

        <h4 class="text-center my-3">Séance du {{ dateToFr(new Date(props.seance.date)) }}</h4>

        <ul class="nav nav-tabs mx-auto mb-4 gap-3" id="myTab" role="tablist" style="width: max-content">
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest active fw-bold" id="one-tab" data-bs-toggle="tab"
                    data-bs-target="#one-tab-pane" type="button" role="tab" aria-controls="one-tab-pane"
                    aria-selected="true">
                    La séance
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest fw-bold" id="two-tab" data-bs-toggle="tab" data-bs-target="#two-tab-pane"
                    type="button" role="tab" aria-controls="two-tab-pane" aria-selected="false">
                    Contrôle de présence
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest fw-bold" id="three-tab" data-bs-toggle="tab"
                    data-bs-target="#three-tab-pane" type="button" role="tab" aria-controls="one-tab-pane"
                    aria-selected="true">
                    Plus / Moins
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest fw-bold" id="four-tab" data-bs-toggle="tab" data-bs-target="#four-tab-pane"
                    type="button" role="tab" aria-controls="four-tab-pane" aria-selected="true">
                    Autres infos
                </button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="one-tab-pane" role="tabpanel" 
                aria-labelledby="home-tab" tabindex="0">

                <TimeSeance :matiere="props.matiere" :seance="props.seance" />
            </div>

            <div class="tab-pane fade" id="two-tab-pane" role="tabpanel" 
                    aria-labelledby="profile-tab" tabindex="0">

                <Presence />
            </div>

        </div>
        
        <!-- {{ props.matiere }} -->
        <!-- {{ props.seance }} -->
    </DashboardLayout>
</template>

