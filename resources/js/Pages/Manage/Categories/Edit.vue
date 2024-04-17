<script setup>
import {Head} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CategoryEditForm from "./Partials/CategoryEditForm.vue";

const props = defineProps({
    category: Object,
})
</script>

<template>
    <Head :title="$t('ui.categories.edit', {id: category.id})"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('ui.categories.edit', {id: category.id}) }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <CategoryEditForm class="max-w-xl"/>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
