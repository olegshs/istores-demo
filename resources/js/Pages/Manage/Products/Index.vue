<script setup>
import {Head} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LinkButton from "@/Components/LinkButton.vue";
import ProductList from "./Partials/ProductList.vue";

defineProps({
    products: Object,
})
</script>

<template>
    <Head :title="$t('ui.products.title')"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('ui.products.title') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <LinkButton :href="route('manage.products.create')">
                    {{ $t('ui.products.create') }}
                </LinkButton>

                <ProductList v-if="products.data.length > 0"/>
                <div v-else>
                    {{ $t('ui.products.empty') }}
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
