<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    matiere: Object,
    seance: Object
});

function formatHeure(heure) {
    const [h, m] = heure.split(':');
    return `${h}:${m}`;
}

function differenceTemps(heure) {
    const now = new Date();

    const [hour, minute, second] = heure.split(':').map(Number);
    const target = new Date(now.getFullYear(), now.getMonth(), now.getDate(), hour, minute, second || 0);

    let diffMs = now - target;

    // Si la date est dans le futur (ex : target = 23h, now = 01h), on suppose qu'on compare à hier
    if (diffMs < 0) {
        diffMs += 24 * 60 * 60 * 1000;
    }

    const diffTotalMinutes = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffTotalMinutes / 60);
    const diffMinutes = diffTotalMinutes % 60;

    return `${diffHours}h ${diffMinutes}min`;
}
// Mise à jour automatique du temps
const tempsEcoule = ref('');
let intervalle;
onMounted(() => {
    const update = () => {
        if (props.seance.heure_debut) {
            tempsEcoule.value = differenceTemps(props.seance.heure_debut)
        }
    };
    update();
    intervalle = setInterval(update, 60000)
});
onUnmounted(() => {
    clearInterval(intervalle);
});

const form = useForm({
    description: ''
});
const closeSeance = () => {
    form.put(route('seance.stop', {
        matiere: props.matiere,
        seance: props.seance
    }));
}

function diffHeure(h1, h2) {
    h1 = String(h1).slice(0, 8);
    h2 = String(h2).slice(0, 8);

    const [h1Hour, h1Min, h1Sec] = h1.split(':').map(Number);
    const [h2Hour, h2Min, h2Sec] = h2.split(':').map(Number);

    if ([h1Hour, h1Min, h2Hour, h2Min].some(isNaN)) {
        console.error("Heures invalides :", h1, h2);
        return "Heures invalides";
    }

    const date1 = new Date(0, 0, 0, h1Hour, h1Min, h1Sec || 0);
    const date2 = new Date(0, 0, 0, h2Hour, h2Min, h2Sec || 0);

    let diffMs = Math.abs(date2 - date1);
    const diffMinutes = Math.floor(diffMs / 60000);
    const hours = Math.floor(diffMinutes / 60);
    const minutes = diffMinutes % 60;

    return `${hours}h ${minutes}min`;
}
</script>

<template>
    <div>
        <template v-if="props.seance && !props.seance.heure_fin">
            <p class="text-center text-warning-emphasis fs-5">Séance en cours...</p>
        </template>

        <template v-if="props.seance && props.seance.heure_fin">
            <p class="text-center text-danger-emphasis fs-4">Séance clôturée.</p>
        </template>

        <div class="d-flex justify-content-center mb-3">
            <table class="table table-striped w-50">
                <thead>
                    <tr class="text-center">
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Durée</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td class="fs-5">{{ formatHeure(props.seance.heure_debut) }}</td>
                        <td class="fs-5">
                            {{ props.seance.heure_fin ? formatHeure(props.seance.heure_fin) : '--:--' }}
                        </td>
                        <td class="fs-5">
                            <template v-if="tempsEcoule && !props.seance.heure_fin">
                                {{ tempsEcoule }}
                            </template>
                            <template v-else>
                                {{ diffHeure(props.seance.heure_fin, props.seance.heure_debut) }}
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <template v-if="props.seance && !props.seance.heure_fin">
            <form @submit.prevent="closeSeance" class="text-center">
                <textarea rows="5" class="form-control mx-auto" v-model="form.description"></textarea>
    
                <button type="submit" class="btn btn-danger text-uppercase my-4">Clôtuer la séance</button>
            </form>
        </template>
    </div>
</template>

<style scoped>
textarea {
    resize: none;
    max-width: 600px;
}
</style>