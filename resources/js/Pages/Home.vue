<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head } from '@inertiajs/vue3';

const items = [
    {name: 'Accueil'}
]
</script>

<template>
    <DashboardLayout>

        <Head title="Accueil" />

        <Breadcrumb :items="items" />

        <h1>Accueil</h1>


    </DashboardLayout>
</template>