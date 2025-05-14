<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    sexe: user.sexe,
    datenais: user.datenais,
    telephone: user.telephone,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Informations du profil
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Mettez à jour les informations de profil et votre adresse e-mail.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="name" value="Nom et Prénom(s)" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

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

            <div>
                <InputLabel for="telephone" value="Téléphone" />

                <TextInput
                    id="telephone" type="tel"
                    class="mt-1 block w-full"
                    v-model="form.telephone"
                />

                <InputError :message="form.errors.telephone" />
            </div>

            <div class="flex w-full gap-x-6">
                <div class="w-2/5">
                    <InputLabel for="sexe" value="Sexe" />
    
                    <select name="sexe" v-model="form.sexe"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
    
                    <InputError class="mt-2" :message="form.errors.sexe" />
                </div>
    
                <div class="w-3/5">
                    <InputLabel for="datenais" value="Date de naissance" />
                    
                    <TextInput
                        id="datenais" type="date"
                        class="mt-1 block w-full"
                        v-model="form.datenais"
                    />
    
                    <InputError :message="form.errors.datenais" />
                </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Votre compte n'est pas vérifié.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Renvoyer le lien de confirmation.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    Un nouveau lien de vérification vient d'être envoyé à votre adresse email.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn btn-secondary py-2" :disabled="form.processing">
                    <i class="fa fa-save me-1"></i>
                    ENREGISTRER
                </button>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 mb-0">
                        Enregisté.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
