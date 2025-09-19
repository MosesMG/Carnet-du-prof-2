<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    semaine: Object,
});

const items = [
    { name: 'Accueil', url: route('dashboard') },
    { name: 'Calendrier' }
];

function formatHeure(heure) {
    const [h, m] = heure.split(':');
    return `${h}:${m}`;
}
</script>


<template>
    <DashboardLayout>

        <Head title="Calendrier" />

        <Breadcrumb :items="items" />

        <h3 class="text-center">Emploi du temps</h3>

        <div class="my-5 d-flex justify-content-center">

            <section class="d-flex text-center w-100 bg-white">
                <div style="width: 14.286%" class="border">
                    <h5 class="mb-0 py-2 text-uppercase text-dark border-bottom border-2 bg-dark-subtle">
                        Lundi
                    </h5>
                    <div class="d-flex flex-column">
                        <div class="mt-1" v-for="lundi in props.semaine[1]" :key="lundi.id">
                            <p class="mb-1 fw-bold">{{ lundi.intitule }}</p>
                            <p class="mb-1 text-danger-emphasis">
                                {{ formatHeure(lundi.heure_debut) }} - {{ formatHeure(lundi.heure_fin) }}
                            </p>
                            <p class="mb-1 fw-bold small">
                                {{ lundi.filiere.site.universite.nom }} - {{ lundi.filiere.site.quartier }}
                            </p>
                            <hr class="my-0">
                        </div>
                    </div>
                </div>

                <div style="width: 14.286%" class="border">
                    <h5 class="mb-0 py-2 text-uppercase text-dark border-bottom border-2 bg-dark-subtle">
                        Mardi
                    </h5>
                    <div class="d-flex flex-column">
                        <div class="mt-1" v-for="mardi in props.semaine[2]" :key="mardi.id">
                            <p class="mb-1 fw-bold">{{ mardi.intitule }}</p>
                            <p class="mb-1 text-danger-emphasis">
                                {{ formatHeure(mardi.heure_debut) }} - {{ formatHeure(mardi.heure_fin) }}
                            </p>
                            <p class="mb-1 fw-bold small">
                                {{ mardi.filiere.site.universite.nom }} - {{ mardi.filiere.site.quartier }}
                            </p>
                            <hr class="my-0">
                        </div>
                    </div>
                </div>

                <div style="width: 14.286%" class="border">
                    <h5 class="mb-0 py-2 text-uppercase text-dark border-bottom border-2 bg-dark-subtle">
                        Mercredi
                    </h5>
                    <div class="d-flex flex-column">
                        <div class="mt-1" v-for="mercredi in props.semaine[3]" :key="mercredi.id">
                            <p class="mb-1 fw-bold">{{ mercredi.intitule }}</p>
                            <p class="mb-1 text-danger-emphasis">
                                {{ formatHeure(mercredi.heure_debut) }} - {{ formatHeure(mercredi.heure_fin) }}
                            </p>
                            <p class="mb-1 fw-bold small">
                                {{ mercredi.filiere.site.universite.nom }} - {{ mercredi.filiere.site.quartier }}
                            </p>
                            <hr class="my-0">
                        </div>
                    </div>
                </div>

                <div style="width: 14.286%" class="border">
                    <h5 class="mb-0 py-2 text-uppercase text-dark border-bottom border-2 bg-dark-subtle">
                        Jeudi
                    </h5>
                    <div class="d-flex flex-column">
                        <div class="mt-1" v-for="jeudi in props.semaine[4]" :key="jeudi.id">
                            <p class="mb-1 fw-bold">{{ jeudi.intitule }}</p>
                            <p class="mb-1 text-danger-emphasis">
                                {{ formatHeure(jeudi.heure_debut) }} - {{ formatHeure(jeudi.heure_fin) }}
                            </p>
                            <p class="mb-1 fw-bold small">
                                {{ jeudi.filiere.site.universite.nom }} - {{ jeudi.filiere.site.quartier }}
                            </p>
                            <hr class="my-0">
                        </div>
                    </div>
                </div>

                <div style="width: 14.286%" class="border">
                    <h5 class="mb-0 py-2 text-uppercase text-dark border-bottom border-2 bg-dark-subtle">
                        Vendredi
                    </h5>
                    <div class="d-flex flex-column">
                        <div class="mt-1" v-for="vendredi in props.semaine[5]" :key="vendredi.id">
                            <p class="mb-1 fw-bold">{{ vendredi.intitule }}</p>
                            <p class="mb-1 text-danger-emphasis">
                                {{ formatHeure(vendredi.heure_debut) }} - {{ formatHeure(vendredi.heure_fin) }}
                            </p>
                            <p class="mb-1 fw-bold small">
                                {{ vendredi.filiere.site.universite.nom }} - {{ vendredi.filiere.site.quartier }}
                            </p>
                            <hr class="my-0">
                        </div>
                    </div>
                </div>

                <div style="width: 14.286%" class="border">
                    <h5 class="mb-0 py-2 text-uppercase text-dark border-bottom border-2 bg-dark-subtle">
                        Samedi
                    </h5>
                    <div class="d-flex flex-column">
                        <div class="mt-1" v-for="samedi in props.semaine[6]" :key="samedi.id">
                            <p class="mb-1 fw-bold">{{ samedi.intitule }}</p>
                            <p class="mb-1 text-danger-emphasis">
                                {{ formatHeure(samedi.heure_debut) }} - {{ formatHeure(samedi.heure_fin) }}
                            </p>
                            <p class="mb-1 fw-bold small">
                                {{ samedi.filiere.site.universite.nom }} - {{ samedi.filiere.site.quartier }}
                            </p>
                            <hr class="my-0">
                        </div>
                    </div>
                </div>

                <div style="width: 14.286%" class="border">
                    <h5 class="mb-0 py-2 text-uppercase text-dark border-bottom border-2 bg-dark-subtle">
                        Dimanche
                    </h5>
                    <div class="d-flex flex-column">
                        <div class="mt-1" v-for="dimanche in props.semaine[7]" :key="dimanche.id">
                            <p class="mb-1 fw-bold">{{ dimanche.intitule }}</p>
                            <p class="mb-1 text-danger-emphasis">
                                {{ formatHeure(dimanche.heure_debut) }} - {{ formatHeure(dimanche.heure_fin) }}
                            </p>
                            <p class="mb-1 fw-bold small">
                                {{ dimanche.filiere.site.universite.nom }} - {{ dimanche.filiere.site.quartier }}
                            </p>
                            <hr class="my-0">
                        </div>
                    </div>
                </div>
            </section>
            
        </div>

    </DashboardLayout>
</template>
