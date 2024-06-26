<script setup>
import {ref} from "vue";
import {useForm, usePage} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {formatDateTime} from "@/formatDateTime.js";

const user = usePage().props.user;
const createdAt = ref(formatDateTime(user.created_at));
const updatedAt = ref(formatDateTime(user.updated_at));

const form = useForm({
    name: user.name,
    email: user.email,
});

const updateUser = () => {
    form.patch(route('admin.users.update', user.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ $t('ui.users.profile.title') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ $t('ui.users.profile.description') }}
            </p>
        </header>

        <form @submit.prevent="updateUser" class="mt-6 space-y-6">
            <div>
                <InputLabel for="id" :value="$t('ui.id')"/>

                <TextInput
                    id="id"
                    type="text"
                    class="mt-1 block w-full bg-gray-50"
                    v-model="user.id"
                    readonly="readonly"
                />
            </div>

            <div>
                <InputLabel for="name" :value="$t('ui.name')" required/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div>
                <InputLabel for="email" :value="$t('ui.email')" required/>

                <TextInput
                    id="email"
                    type="email"
                    dir="ltr"
                    class="mt-1 block w-full rtl:text-right"
                    v-model="form.email"
                    required
                />

                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div>
                <InputLabel for="created_at" :value="$t('ui.users.created_at')"/>

                <TextInput
                    id="created_at"
                    type="text"
                    class="mt-1 block w-full bg-gray-50"
                    v-model="createdAt"
                    readonly="readonly"
                />
            </div>

            <div>
                <InputLabel for="updated_at" :value="$t('ui.updated_at')"/>

                <TextInput
                    id="updated_at"
                    type="text"
                    class="mt-1 block w-full bg-gray-50"
                    v-model="updatedAt"
                    readonly="readonly"
                />
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
