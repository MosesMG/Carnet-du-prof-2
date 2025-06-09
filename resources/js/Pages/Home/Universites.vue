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
            <div class="col-lg-6 col-md-8">
                <div class="input-group">
                    <label class="input-group-text">Rechercher par le nom</label>
                    <input type="text" class="form-control" v-model="search">
                </div>
            </div>
        </div>

        <div class="row justify-content-center table-responsive">
            <div class="col-sm-12 col-md-8">
                <table id="" class="display table table-striped dataTable" role="grid"
                    aria-describedby="basic-datatables_info">
                    <thead>
                        <tr role="row">
                            <th tabindex="0" class="fs-5">Nom</th>
                            <th tabindex="0" class="fs-5">Téléphone</th>
                            <th tabindex="0" class="fs-5">Sites</th>
                            <th tabindex="0" class="fs-5">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" v-for="universite in univFiltered" :key="universite.id">
                            <td class="fw-semibold">{{ universite.nom }}</td>
                            <td>{{ universite.telephone }}</td>
                            <td>
                                <span class="badge badge-secondary fw-bolder">{{ universite.sites_count }}</span>
                            </td>
                            <td>
                                <Link :href="route('sites.choix', universite)" class="btn btn-outline-success py-2">Choisir</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </DashboardLayout>
</template>
