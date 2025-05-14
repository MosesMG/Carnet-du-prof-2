<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Modal from '@/Components/Modal.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    rappels: Array,
})

const items = [
    { name: 'Accueil', url: route('dashboard') },
    { name: 'Rappels' }
];

const deleteRappel = (rappel) => {
    console.log(rappel.id);
    router.delete(route('rappel.delete', rappel))
}

const showModal = ref(false);

const showingModal = () => {
    showModal.value = true;
}

const deleteAllRappels = () => {
    router.delete(route('all.rappel.delete'));
    showModal.value = false;
}
</script>

<template>
    <DashboardLayout>
        <Head title="Les rappels" />

        <Breadcrumb :items="items" />

        <div class="d-flex justify-content-evenly align-items-center mb-5">
            <h5>Rappels</h5>

            <button class="btn btn-outline-danger py-2" @click="showingModal"
                :disabled="!props.rappels || props.rappels.length === 0">
                <i class="fa fa-trash-alt me-1"></i>
                Tout supprimer
            </button>
        </div>

        <div v-if="props.rappels.length === 0"
                style="margin: 100px auto;">
            <h5 class="text-center text-gray-900">Vous n'avez pas encore de rappels.</h5>
        </div>

        <table v-else class="table table-striped table-hover w-75 mx-auto">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th class="text-center">Message</th>
                    <th class="text-center">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="rappel in props.rappels" :key="rappel.id">
                    <td>{{ rappel.titre }}</td>
                    <td class="text-justify">
                        {{ rappel.message }}
                    </td>
                    <td class="text-center" @click="deleteRappel(rappel)">
                        <button class="btn btn-label-warning px-3 py-1">
                            <i class="fa fa-xmark"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <Modal :show="showModal" @close="showModal = false">
            <div class="p-4">
                <h2 class="font-medium text-lg text-black mb-5">
                    Voulez-vous supprimer tous les rappels ?
                </h2>

                <div class="mt-6 flex justify-end">
                    <button @click="showModal = false" class="btn btn-label-info py-2">
                        <i class="fa fa-ban"></i>
                        NON
                    </button>
                    
                    <button class="btn btn-danger py-2 ms-4" @click="deleteAllRappels">
                        <i class="fa fa-check me-1"></i>
                        OUI
                    </button>
                </div>
            </div>
        </Modal>
    </DashboardLayout>
</template>
