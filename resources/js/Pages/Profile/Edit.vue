<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import Breadcrumb from '@/Components/Breadcrumb.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const items = [
    { name: 'Accueil', url: route('dashboard') },
    { name: 'Paramètres du profil' }
];
</script>

<template>
    <DashboardLayout>

        <Head title="Votre profil" />

        <Breadcrumb :items="items" />

        <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">

                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">

                    <UpdatePasswordForm class="max-w-xl" />
                    
                </div>
            </div>

            <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">

                <DeleteUserForm class="max-w-xl" />

            </div>
        </div>
    </DashboardLayout>
</template>
