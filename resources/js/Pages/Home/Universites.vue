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

        <div class="mt-4 mb-3 row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <label class="input-group-text border-2"><i class="fa fa-search"></i></label>
                    <input type="text" class="form-control" v-model="search">
                </div>
            </div>
        </div>

        <div class="row justify-content-center table-responsive">
            <div class="col-sm-12 col-md-8">
                <table class="table table-striped dataTable" role="grid" aria-describedby="basic-datatables_info">
                    <thead>
                        <tr role="row">
                            <th tabindex="0" class="fs-6 underline">Nom</th>
                            <th tabindex="0" class="fs-6 text-center underline">Téléphone</th>
                            <th tabindex="0" class="fs-6 text-center underline">Sites</th>
                            <th tabindex="0" class="fs-6 text-center underline">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" v-for="universite in univFiltered" :key="universite.id">
                            <td class="fw-semibold">{{ universite.nom }}</td>
                            <td class="text-center">{{ universite.telephone }}</td>
                            <td class="text-center">
                                <span class="badge badge-secondary fw-bolder">{{ universite.sites_count }}</span>
                            </td>
                            <td class="text-center">
                                <Link :href="route('sites.choix', universite)" class="btn btn-outline-success btn-sm">Choisir</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </DashboardLayout>
</template>
