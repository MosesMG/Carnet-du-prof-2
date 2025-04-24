<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    filieres: Array,
})
</script>

<template>
    
    <DashboardLayout>
        
        <Head title="Les filières" />

        <h4 class="text-center mt-4">Choisir une filière </h4>
      
        <div class="row g-4 mx-auto my-4" style="max-width:500px">
            
            <div class="col-12 bg-white fs-5 py-2" v-for="filiere in filieres" :key="filiere.id">
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
