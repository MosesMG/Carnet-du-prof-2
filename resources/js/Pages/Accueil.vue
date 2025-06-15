<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps({
    matieres: Array,
});

const items = [
    { name: 'Accueil' }
];

const cumulMois = ref(0);

onMounted(() => {
    cumulMois.value = localStorage.getItem('cumulDuMois');
});

function formatHeure(heure) {
    const [h, m] = heure.split(':');
    return `${h}:${m}`;
}
</script>

<template>
    <DashboardLayout>

        <Head title="Accueil" />

        <Breadcrumb :items="items" />

        <h4 class="text-center">Bienvenue, M. {{ $page.props.auth.user.name }}</h4>

        <ul class="nav nav-tabs mx-auto my-4 gap-3" id="myTab" role="tablist" style="width: max-content">
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest active fw-bold" id="home-tab" data-bs-toggle="tab"
                    data-bs-target="#one-tab-pane" type="button" role="tab" aria-controls="one-tab-pane"
                    aria-selected="true">
                    Au programme
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest fw-bold" id="profile-tab" data-bs-toggle="tab"
                    data-bs-target="#two-tab-pane" type="button" role="tab" aria-controls="two-tab-pane"
                    aria-selected="false">
                    Autres informations
                </button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active pt-0 pb-3" id="one-tab-pane" role="tabpanel" 
                aria-labelledby="home-tab" tabindex="0">

                <h5 class="fw-light text-center">Voici votre emploi du temps du jour</h5>

                <div v-if="props.matieres.length > 0" class="table-responsive my-4">
                    <table class="table table-striped w-75 mx-auto">
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
                </div>

                <div v-else class="d-flex flex-column justify-content-center align-items-center gap-3" style="height: 45vh">
                    <h3 class="text-danger-emphasis text-center">
                        Vous n'avez pas de cours aujourd'hui !
                    </h3>
                    <p class="text-success-emphasis text-center">
                        Si vous voulez configurer votre emploi du temps, veuillez vous rendre à 
                        la section "Les universités" du menu
                    </p>
                </div>
            </div>

            <div class="tab-pane fade py-3" id="two-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <div class="row gy-2 w-75 mx-auto">
                    <div class="col-sm-12 col-md-6">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center icon-secondary py-4">
                                            <i class="icon-graduation"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <Link :href="route('universites')">
                                                <p class="card-category">Mes universités</p>
                                                <h4 class="card-title">{{ usePage().props.mesUniversites.length }}</h4>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center icon-info py-4">
                                            <i class="icon-bell"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <Link :href="route('les.rappels')">
                                                <p class="card-category">Rappels</p>
                                                <h4 class="card-title">Explorer</h4>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center icon-success py-4">
                                            <i class="icon-wallet"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <Link :href="route('les.donnees')">
                                                <p class="card-category">Revenu total ce mois</p>
                                                <h4 class="card-title">{{ cumulMois ?? 0 }} F</h4>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center icon-danger py-4">
                                            <i class="icon-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <Link :href="route('profile.edit')">
                                                <p class="card-category">Aller aux paramètres</p>
                                                <h4 class="card-title">Profil</h4>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
    </DashboardLayout>
</template>
