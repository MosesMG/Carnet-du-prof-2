<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    matieres: Array,
});

const items = [
    { name: 'Accueil' }
];

function formatHeure(heure) {
    const [h, m] = heure.split(':');
    return `${h}:${m}`;
}
</script>

<template>
    <DashboardLayout>

        <Head title="Accueil" />

        <Breadcrumb :items="items" />

        <div class="d-flex flex-column justify-content-between align-items-center mt-1 mb-1">
            <h4>Bienvenue, M. {{ $page.props.auth.user.name }}</h4>

            <h5 class="fw-light">Voici votre emploi du temps du jour</h5>
        </div>

        <table v-if="props.matieres.length > 0" class="table table-striped w-75 mx-auto my-4">
            <thead>
                <tr>
                    <th>Heure</th>
                    <th>Matière</th>
                    <th>Filière</th>
                    <th>Université</th>
                    <th>Séance</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="cours in props.matieres" :key="cours.id">
                    <td>
                        {{ formatHeure(cours.heure_debut) }} - {{ formatHeure(cours.heure_fin) }}
                    </td>
                    <td>{{ cours.intitule }}</td>
                    <td>
                        <Link :href="route('mes.matieres', cours.filiere)"
                                class="text-primary-emphasis fw-bold text-decoration-underline">
                            {{ cours.filiere.libelle }}
                        </Link>
                    </td>
                    <td>{{ cours.filiere.site.universite.nom }}</td>
                    <td>
                        <Link :href="route('matiere.seance', cours)"
                                class="text-info-emphasis text-decoration-underline">
                            Aller
                            <i class="fas fa-arrow-circle-right ms-1"></i>
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-else class="d-flex flex-column justify-content-center align-items-center gap-3" style="height: 45vh">
            <h3 class="text-danger-emphasis text-center">
                Vous n'avez pas de cours aujourd'hui !
            </h3>
            <p class="text-success-emphasis text-center">
                Si vous voulez configurer votre emploi du temps, veuillez vous rendre à 
                la section "Les universités" du menu
            </p>
        </div>

    </DashboardLayout>
</template>
