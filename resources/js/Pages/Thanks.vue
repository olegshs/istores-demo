<script setup>
import {Head} from "@inertiajs/vue3";
import StoreLayout from "@/Layouts/StoreLayout.vue";

const props = defineProps({
    store: Object,
    order: Object,
});

const store = props.store;
const order = props.order;
</script>

<template>
    <Head title="Thank you!"/>

    <StoreLayout>
        <div class="p-6 text-gray-900 bg-white shadow sm:rounded-lg space-y-4">
            <p class="text-xl">Thank you!</p>

            <p>Order #{{ order.id }} has been successfully paid.</p>
        </div>
    </StoreLayout>
</template>
