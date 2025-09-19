<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({});

function envoyerMail() {
    form.post(route('mail.send'));
}
</script>

<template>
    <DashboardLayout>
        <Head title="Test mail" />

        <div>
            <form
                @submit.prevent="envoyerMail"
                class="d-flex flex-column justify-content-center align-items-center gap-y-4"
            >
                <p class="text-dark uppercase h4">C'est une page pour tester l'envoi des mail avec l'outil Brevo</p>

                <button type="submit" class="btn btn-secondary">ENVOYER MAIL !</button>
            </form>
        </div>
    </DashboardLayout>
</template>
