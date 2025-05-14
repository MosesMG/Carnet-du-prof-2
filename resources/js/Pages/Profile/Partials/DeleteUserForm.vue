<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6 mx-auto text-center">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Supprimer le compte
            </h2>

            <p class="mt-1 text-sm text-gray-600">
               Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées.
            </p>
        </header>

        <button @click="confirmUserDeletion" class="btn btn-danger py-2 text-uppercase">
            <i class="fa fa-trash-alt me-1"></i>
            Supprimer le compte
        </button>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Êtes-vous sûr de vouloir supprimer votre compte ?
                </h2>

                <p class="mt-1 text-gray-500">
                    Veuillez saisir votre mot de passe pour confirmer la suppression définitive de votre compte.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="Password"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        placeholder="•••••••"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <button @click="closeModal" class="btn btn-label-info py-2">
                        <i class="fa fa-ban"></i>
                        Annuler
                    </button>
                    
                    <button :disabled="form.processing" @click="deleteUser"
                            class="btn btn-danger py-2 ms-4" :class="{ 'opacity-25': form.processing }">
                        <i class="fa fa-xmark me-1"></i>
                        Supprimer
                    </button>
                </div>
            </div>
        </Modal>
    </section>
</template>
