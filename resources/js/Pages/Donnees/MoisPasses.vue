<script setup>
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    passesMois: Object,
});

const lesMois = Object.keys(props.passesMois);
const leMois = ref('');

const seancesMois = computed(() => {
    if (!leMois.value) return [];
    return props.passesMois[leMois.value] || [];
});

function calculerGain(seance) {
    if (!seance.heure_debut || !seance.heure_fin || !seance.taux_hr) return 0;

    const [heure1, minute1] = seance.heure_debut.split(':').map(Number);
    const [heure2, minute2] = seance.heure_fin.split(':').map(Number);

    const debut = new Date(0, 0, 0, heure1, minute1);
    const fin = new Date(0, 0, 0, heure2, minute2);

    const ms = fin - debut;
    const heures = ms / (1000 * 60 * 60);

    return parseFloat((heures * seance.taux_hr).toFixed(2));
}

const totalGainMois = computed(() => {
    return seancesMois.value.reduce((total, seance) => {
        return total + calculerGain(seance, seance.taux_hr);
    }, 0);
});

function dateToFr(date) {
    const d = date instanceof Date ? date : new Date(date);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    return `${day}/${month}/${year}`;
}
</script>

<template>

    <div class="d-flex justify-content-evenly align-items-center mb-5">
        <div class="row">
            <h5 class="mb-0">Sélectionner le mois</h5>
            
            <select v-model="leMois" class="form-select py-2 capitalize w-25 col">
                <option disabled value="">-- Mois passés --</option>
                <option v-for="mois in lesMois" :key="mois" :value="mois">
                    {{ new Date(mois + '-01').toLocaleString('fr-FR', { month: 'long', year: 'numeric' }) }}
                </option>
            </select>
        </div>
        
        <h5>Total: <span class="text-success-emphasis">{{ totalGainMois.toLocaleString() }} F</span></h5>
    </div>

    <div v-if="!props.passesMois || props.passesMois.length === 0">
        <h5 class="text-center text-danger-emphasis my-5">
            Vous n'avez effectué aucune activité pour l'instant.
        </h5>
    </div>

    <div v-else>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Matière</th>
                    <th>Université</th>
                    <th>État</th>
                    <th>Gain</th>
                    <th>Plus</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="seance in seancesMois" :key="seance.id">
                    <td>{{ dateToFr(seance.date) }}</td>
                    <td>{{ seance.matiere.intitule }}</td>
                    <td>{{ seance.matiere.filiere.site.universite.nom }}</td>
                    <td>
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                        <!-- <i class="fas fa-xmark-circle fa-2x text-danger"></i> -->
                    </td>
                    <td class="font-medium">{{ calculerGain(seance) }} F</td>
                    <td>
                        <Link class="btn btn-label-secondary btn-sm py-2"
                            :href="route('seance.show', {
                                seance: seance,
                                matiere: seance.matiere,
                            })">
                            Voir plus
                            <i class="fa fa-arrow-right ms-1"></i>
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
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
