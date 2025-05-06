<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head } from '@inertiajs/vue3';
import ListeMatieres from './ListeMatieres.vue';
import Etudiants from './Etudiants.vue';
import AutresInfos from './AutresInfos.vue';

const props = defineProps({
    filiere : Object,
    matieres: Array,
    tauxhr: Number,
    etudiants: Array,
});
</script>


<template>

    <DashboardLayout>

        <Head title="Les matières" />

        <ul class="nav nav-tabs mx-auto mb-4 gap-3" id="myTab" role="tablist" style="width: max-content;">
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest active fw-bold" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                    Les matières
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest fw-bold" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                    Les étudiants
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-pinterest fw-bold" id="others-tab" data-bs-toggle="tab" data-bs-target="#others-tab-pane"
                    type="button" role="tab" aria-controls="others-tab-pane" aria-selected="false">
                    Autres informations
                </button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            
            <!-- Les matières -->
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                <ListeMatieres :filiere="props.filiere" :matieres="props.matieres" />
                
            </div>


            <!-- Les étudiants -->
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                
                <Etudiants :filiere="props.filiere" :etudiants="props.etudiants" />

            </div>


            <!-- Autres informations -->
            <div class="tab-pane fade" id="others-tab-pane" role="tabpanel" aria-labelledby="others-tab" tabindex="0">
                
                <AutresInfos :filiere="props.filiere" :etudiants="props.etudiants" :tauxHr="props.tauxhr" />

            </div>
        </div>

    </DashboardLayout>

</template>
