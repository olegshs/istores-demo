<script setup>
import {Head} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductEditForm from "./Partials/ProductEditForm.vue";
import ProductCategoriesForm from "./Partials/ProductCategoriesForm.vue";

const props = defineProps({
    product: Object,
})
</script>

<template>
    <Head :title="`Edit Product #${product.id}`"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Product #{{ product.id }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <ProductEditForm class="max-w-xl"/>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <ProductCategoriesForm class="max-w-xl"/>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
