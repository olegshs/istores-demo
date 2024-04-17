<script setup>
import {Head} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UserEditForm from './Partials/UserEditForm.vue';
import UserRolesForm from "./Partials/UserRolesForm.vue";
import PasswordUpdateForm from "./Partials/PasswordUpdateForm.vue";
import UserDeleteForm from './Partials/UserDeleteForm.vue';

const props = defineProps({
    user: Object,
    all_roles: Array,
    errors: Object,
})

const user = props.user;
</script>

<template>
    <Head :title="$t('ui.users.edit', {id: user.id})"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('ui.users.edit', {id: user.id}) }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UserEditForm class="max-w-xl"/>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UserRolesForm class="max-w-xl"/>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <PasswordUpdateForm class="max-w-xl"/>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UserDeleteForm class="max-w-xl"/>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
