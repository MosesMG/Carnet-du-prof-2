<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    filieres: Array,
    universite: Object,
    site: Object
})

const items = [
    { name: 'Accueil', url: route('dashboard') },
    { name: 'Universités', url: route('universites') },
];
if (props.site) {
    items.push(
        { name: props.universite.nom, url: route('sites.choix', props.universite) },
        { name: props.site.nom },
    )
}
else {
    items.push(
        { name: props.universite.nom }
    )
}
</script>

<template>

    <DashboardLayout>

        <Head title="Les filières" />

        <Breadcrumb :items="items" />

        <h4 class="text-center mt-4">Choisir une filière </h4>

        <div class="container-fluid">
            <div class="row justify-content-center g-5 mt-1 mb-4 mx-5">
                <div
                    v-for="filiere in props.filieres" :key="filiere.id"
                    class="col-sm-6 col-md-4 col-lg-3 text-dark-emphasis"
                >
                    <Link :href="route('mes.matieres', filiere)">
                        <div class="p-2 bg-white rounded-3">
                            <div class="d-flex justify-content-center">
                                <div class="my-2">
                                    <i class="fa fa-book-reader fs-3 text-dark"></i>
                                </div>
                            </div>
                            <h5 class="fw-semibold text-center uppercase text-dark">{{ filiere.libelle }}</h5>
                            <div class="d-flex justify-content-center gap-x-4 align-items-center mb-2">
                                <span class="text-danger-emphasis fw-semibold text-center">{{ filiere.description }}</span>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>

    </DashboardLayout>
</template>
