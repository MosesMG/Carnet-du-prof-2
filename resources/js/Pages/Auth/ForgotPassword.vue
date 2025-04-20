<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Mot de passe oublié" />

        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600 text-center"
        >
            {{ status }}
        </div>

        <div class="flex items-center justify-between gap-5">
            <div>
                <img src="/images/signin-image.png" alt="" width="300">
            </div>
    
            <div class="w-3/5">
                <h4 class="my-6 text-center font-semibold text-2xl">Mot de passe oublié</h4>
                
                <div class="mb-6 text-sm text-gray-600">
                    Vous avez oublié votre mot de passe ? Entrez votre adresse email 
                    pour recevoir un lien de réinitialisation.
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Email" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <Link :href="route('login')" class="underline">
                            <i class="fas fa-arrow-left me-1"></i>
                            <span class="text-sm">Connexion</span>
                        </Link>

                        <PrimaryButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Lien de réinitialisation
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
