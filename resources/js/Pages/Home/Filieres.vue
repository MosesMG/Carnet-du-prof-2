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

        <div class="row g-4 mx-auto my-4" style="max-width:500px">

            <div class="col-12 bg-white fs-5 py-2" v-for="filiere in props.filieres" :key="filiere.id">
                <Link :href="route('mes.matieres', filiere)" class="text-dark-emphasis">
                <span class="fw-bold">
                    {{ filiere.libelle }} :
                </span>
                <span>
                    {{ filiere.description }}
                </span>
                </Link>
            </div>

        </div>

    </DashboardLayout>

</template>
