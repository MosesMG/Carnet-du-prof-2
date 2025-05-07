<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    universite: Object,
    sites: Array,
})

const items = [
    { name: 'Accueil', url: route('dashboard') },
    { name: 'Universités', url: route('universites') },
    { name: props.universite.nom },
];
</script>

<template>
    
    <DashboardLayout>

        <Head title="Les sites" />

        <Breadcrumb :items="items" />

        <h4 class="text-center my-4">Choisir un site de l'université "{{ universite.nom }}"</h4>

        <div class="row justify-content-evenly g-4 mx-auto my-5">
        
            <div class="col-lg-3 col-md-5 col-sm-5 card text-center px-3 pt-4" v-for="site in sites" :key="site.id">
                <Link :href="route('mes.filieres', site)" class="text-dark">
                    <div class="card-top">
                        <i class="fas fa-location-dot fa-4x"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-0">
                            {{ site.nom }}
                        </h5>
                    </div>
                </Link>
            </div>

        </div>

    </DashboardLayout>

</template>
