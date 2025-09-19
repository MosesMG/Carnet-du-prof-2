<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    universites: Array
});

const search = ref('');

const univFiltered = computed(() => {
    if (!search.value) return props.universites;

    return props.universites.filter(univ => 
        univ.nom.toLowerCase().includes(search.value.toLocaleLowerCase())
    );
});

const items = [
    { name: 'Accueil', url: route('dashboard') },
    { name: 'Universités' }
]
</script>

<template>
    <DashboardLayout>
        <Head title="Liste des universités" />

        <Breadcrumb :items="items" />

        <h3 class="my-2 text-center">Liste des universités</h3>

        <div class="my-4 row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <label class="input-group-text border-2"><i class="fa fa-search"></i></label>
                    <input type="text" class="form-control" v-model="search" placeholder="Chercher une université">
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center g-5 mt-1 mb-4 mx-5">
                <Link
                    :href="route('sites.choix', universite)"
                    v-for="universite in univFiltered" :key="universite.id"
                    class="col-sm-6 col-md-4 col-lg-3"
                >
                    <div class="p-2 bg-white rounded-3">
                        <div class="d-flex justify-content-center">
                            <div class="mb-2">
                                <i class="fa fa-graduation-cap fs-3 text-dark"></i>
                            </div>
                        </div>
                        <h5 class="fw-semibold text-center uppercase text-dark">{{ universite.nom }}</h5>
                        <div class="d-flex justify-content-center gap-x-4 align-items-center mb-2">
                            <span class="small text-black text-decoration-underline">Téléphone:</span>
                            <span class="text-danger-emphasis fw-semibold">{{ universite.telephone }}</span>
                        </div>
                        <div class="d-flex justify-content-center gap-x-2 align-items-center mb-1">
                            <span class="small text-black text-decoration-underline">Nombre de sites:</span>
                            <span class="text-secondary fw-bolder">{{ universite.sites_count }}</span>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </DashboardLayout>
</template>
