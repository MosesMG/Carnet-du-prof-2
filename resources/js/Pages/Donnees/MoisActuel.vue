<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    actuelMois: Array
});

function calculerGain(seance) {
    if (!seance.heure_debut || !seance.heure_fin || !seance.taux_hr) return 0;

    const [h1, m1] = seance.heure_debut.split(':').map(Number);
    const [h2, m2] = seance.heure_fin.split(':').map(Number);

    const debut = new Date(0, 0, 0, h1, m1);
    const fin = new Date(0, 0, 0, h2, m2);

    if (fin <= debut) {
        fin.setDate(fin.getDate() + 1);
    }

    const duree = (fin - debut) / (1000 * 60 * 60);
    return parseFloat((duree * seance.taux_hr).toFixed(2));
}

const totalGain = computed(() => {
    return props.actuelMois.reduce((acc, seance) => acc + calculerGain(seance), 0);
});

localStorage.setItem('cumulDuMois', totalGain.value);

function dateToFr(date) {
    const d = new Date(date);
    return d.toLocaleDateString('fr-FR');
}
</script>

<template>
    <div>
        <div v-if="props.actuelMois.length === 0" class="text-center text-muted">
            <h5 style="margin: 100px auto;">Aucune séance enregistrée ce mois.</h5>
        </div>

        <div v-else>
            <h5 class="text-center mb-4">
                Total: <span class="text-success-emphasis">{{ totalGain.toLocaleString() }} F</span>
            </h5>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Matière</th>
                        <th>Université</th>
                        <th>État</th>
                        <th>Gain</th>
                        <th>Voir</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="seance in props.actuelMois" :key="seance.id">
                        <td>{{ dateToFr(seance.date) }}</td>
                        <td>{{ seance.matiere.intitule }}</td>
                        <td>{{ seance.matiere.filiere.site.universite.nom }}</td>
                        <td>
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </td>
                        <td class="font-medium">{{ calculerGain(seance).toLocaleString() }} F</td>
                        <td>
                            <Link
                                class="btn btn-label-secondary btn-sm py-2"
                                :href="route('seance.show', {
                                    seance: seance,
                                    matiere: seance.matiere,
                                })"
                            >
                                Voir plus
                                <i class="fa fa-arrow-right ms-1"></i>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</template>

<style scoped>
.table-striped {
    max-width: 1100px;
    margin: auto;
}
.table-striped td {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}
</style>
