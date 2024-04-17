<script setup>
import {nextTick, ref} from 'vue';
import {useForm, usePage} from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const user = usePage().props.user;

const confirmingUserDeletion = ref(false);

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const form = useForm({});

const deleteUser = () => {
    form.delete(route('admin.users.destroy', user.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ $t('ui.users.delete') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ $t('ui.users.delete_confirm.description') }}
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">Delete Account</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ $t('ui.users.delete_confirm.text') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ $t('ui.users.delete_confirm.description') }}
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        {{ $t('ui.cancel') }}
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        {{ $t('ui.users.delete') }}
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
