<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head } from '@inertiajs/vue3';
import MoisActuel from './MoisActuel.vue';
import MoisPasses from './MoisPasses.vue';

const props = defineProps({
    actuelMois: Array,
    passesMois: Object,
})

const items = [
    { name: 'Accueil', url: route('dashboard') },
    { name: 'Données' }
];

const ceMois = new Date().toLocaleString('fr-FR', { month: 'long', year: 'numeric' })
</script>


<template>
    <DashboardLayout>
        <Head title="Les données" />

        <Breadcrumb :items="items" />

        <h4 class="text-center my-3">Historique des séances de cours</h4>

        <ul class="nav nav-tabs mx-auto my-3 gap-3" id="myTab" role="tablist" style="width: max-content">
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest active fw-bold" id="home-tab" data-bs-toggle="tab"
                    data-bs-target="#one-tab-pane" type="button" role="tab" aria-controls="one-tab-pane"
                    aria-selected="true">
                    Ce mois : <span class="capitalize">{{ ceMois }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest fw-bold" id="profile-tab" data-bs-toggle="tab"
                    data-bs-target="#two-tab-pane" type="button" role="tab" aria-controls="two-tab-pane"
                    aria-selected="false">
                    Les mois passés
                </button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active py-3" id="one-tab-pane" role="tabpanel" 
                aria-labelledby="home-tab" tabindex="0">

                <MoisActuel :actuelMois="props.actuelMois" />

            </div>

            <div class="tab-pane fade py-3" id="two-tab-pane" role="tabpanel" 
                aria-labelledby="profile-tab" tabindex="0">

                <MoisPasses :passesMois="props.passesMois" />

            </div>
        </div>

    </DashboardLayout>
</template>
