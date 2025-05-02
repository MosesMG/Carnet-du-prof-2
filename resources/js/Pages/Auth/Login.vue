<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Connexion" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <div class="flex items-center justify-between gap-5">
            <div>
                <img src="/images/signin-image.png" alt="" width="300">
            </div>
    
            <div class="w-3/5">
                <h4 class="my-6 text-center font-semibold text-2xl">Connexion</h4>

                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Email" />
        
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />
        
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
        
                    <div class="mt-6">
                        <InputLabel for="password" value="Mot de passe" />
        
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />
        
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
        
                    <div class="mt-6 flex justify-between items-center">
                        <div>
                            <label class="flex items-center">
                                <Checkbox name="remember" v-model:checked="form.remember" />
                                <span class="ms-2 text-sm text-gray-600"
                                    >Rester connecté</span
                                >
                            </label>
                        </div>
                        
                        <div>
                            <Link
                            :href="route('password.request')"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Mot de passe oublié ?
                            </Link>
        
                        </div>
                    </div>
        
                    <div class="mt-6 flex items-center justify-around">
                        <div>
                            <Link class="flex items-center gap-2 py-2 px-6 border border-white rounded-lg bg-red-100 hover:bg-white hover:border hover:border-red-600 transition-all"
                                :href="route('google.login')">
                                <span class="text-sm font-medium">ou utiliser</span>
                                <i class="fab fa-google text-red-600"></i>
                            </Link>
                        </div>
                        
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Connexion
                        </PrimaryButton>
                    </div>
                </form>

                <div class="text-sm mt-4 flex justify-center items-center gap-3">
                    <span>Pas encore inscrit ?</span>
                    <Link :href="route('register')"
                        class="text-gray-600 underline hover:text-gray-900 focus:outline-none">
                        Créer un compte
                    </Link>
                </div>
            </div>
        </div>

    </GuestLayout>
</template>
