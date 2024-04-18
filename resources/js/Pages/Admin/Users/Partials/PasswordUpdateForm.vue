<script setup>
import {ref} from 'vue';
import {useForm, usePage} from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const user = usePage().props.user;

const passwordInput = ref(null);
const passwordConfirmInput = ref(null);

const form = useForm({
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.patch(route('admin.users.update', user.id), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                passwordInput.value.focus();
            } else if (form.errors.password_confirmation) {
                passwordConfirmInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ $t('ui.users.password.title') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ $t('ui.users.password.description') }}
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <InputLabel for="password" :value="$t('ui.users.password.new')"/>

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" class="mt-2"/>
            </div>

            <div>
                <InputLabel for="password_confirmation" :value="$t('ui.users.password.confirm')"/>

                <TextInput
                    id="password_confirmation"
                    ref="passwordConfirmInput"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password_confirmation" class="mt-2"/>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">
                    {{ $t('ui.save') }}
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                        {{ $t('ui.saved') }}
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
