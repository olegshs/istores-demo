<script setup>
import {Head} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LinkButton from "@/Components/LinkButton.vue";
import CategoryList from "./Partials/CategoryList.vue";

const props = defineProps({
    categories: Object,
});
</script>

<template>
    <Head :title="$t('ui.categories.title')"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('ui.categories.title') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <LinkButton :href="route('manage.categories.create')">
                    {{ $t('ui.categories.create') }}
                </LinkButton>

                <CategoryList v-if="categories.data.length > 0"/>
                <div v-else>
                    {{ $t('ui.categories.empty') }}
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
