<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    universites: Array
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

        <div class="row justify-content-center">
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
                        <tr role="row" v-for="universite in universites" :key="universite.id">
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
