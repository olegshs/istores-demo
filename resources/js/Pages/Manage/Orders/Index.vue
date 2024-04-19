<script setup>
import {Head} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import {formatDateTime} from "@/formatDateTime";

const props = defineProps({
    orders: Object
});

const orders = props.orders.data;
const total = props.orders.total;
</script>

<template>
    <Head :title="$t('ui.orders.title')"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('ui.orders.title') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div v-for="order in orders" class="p-4 space-y-4 bg-white rounded-md shadow">
                    <div class="space-y-1">
                        <h3 class="text-lg font-semibold">
                            {{ $t('ui.orders.order', {id: order.id}) }}
                        </h3>

                        <table>
                            <tbody>
                            <tr>
                                <th class="pe-4 text-start font-semibold">
                                    {{ $t('ui.created_at') }}:
                                </th>
                                <td>
                                    <span dir="ltr">{{ formatDateTime(order.details.created_at) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="pe-4 text-start font-semibold">
                                    {{ $t('ui.orders.status') }}:
                                </th>
                                <td>
                                    {{ order.status }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="space-y-1">
                        <h4 class="text-md font-semibold">
                            {{ $t('ui.orders.details') }}
                        </h4>

                        <table>
                            <tbody>
                            <tr>
                                <th class="pe-4 text-start font-semibold">
                                    {{ $t('ui.checkout.details.name') }}:
                                </th>
                                <td>
                                    {{ order.details.name }}
                                </td>
                            </tr>
                            <tr>
                                <th class="pe-4 text-start font-semibold">
                                    {{ $t('ui.checkout.details.email') }}:
                                </th>
                                <td>
                                    {{ order.details.email }}
                                </td>
                            </tr>
                            <tr>
                                <th class="pe-4 text-start font-semibold">
                                    {{ $t('ui.checkout.details.phone') }}:
                                </th>
                                <td>
                                    {{ order.details.phone }}
                                </td>
                            </tr>
                            <tr>
                                <th class="pe-4 text-start font-semibold">
                                    {{ $t('ui.checkout.details.address') }}:
                                </th>
                                <td>
                                    {{ order.details.address }}
                                </td>
                            </tr>
                            <tr>
                                <th class="pe-4 text-start font-semibold">
                                    {{ $t('ui.checkout.details.comment') }}:
                                </th>
                                <td>
                                    {{ order.details.comment }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex">
                    <div class="flex-1">
                        <Pagination :links="props.orders.links"/>
                    </div>
                    <div class="px-4 py-2 justify-end">{{ $t('ui.total') }}: {{ total }}</div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
