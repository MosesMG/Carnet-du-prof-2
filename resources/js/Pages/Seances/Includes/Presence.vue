<script setup>
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({});

</script>

<template>
    <div class="d-flex justify-content-center" style="margin: 100px auto;">
        <button type="button" class="btn btn-primary fs-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Afficher la liste des étudiants
        </button>
    </div>
</template>