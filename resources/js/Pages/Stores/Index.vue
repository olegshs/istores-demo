<script setup>
import {Head, Link} from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const props = defineProps({
    stores: Array,
});
</script>

<template>
    <Head :title="$t('ui.welcome')"/>

    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex flex-1 gap-6 items-center">
                        <!-- Logo -->
                        <div class="shrink-0">
                            <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800"/>
                        </div>

                        <div class="flex-1">
                            <h1 class="text-xl font-semibold text-gray-800 ms-4">
                                {{ $t('ui.stores.title') }}
                            </h1>
                        </div>

                        <div v-if="$page.props.auth.user" class="flex gap-6 pe-6 text-sm">
                            <Link :href="route('dashboard')" class="font-semibold text-gray-500 hover:text-gray-700">
                                {{ $t('ui.dashboard.title') }}
                            </Link>
                        </div>
                        <div v-else class="flex gap-6 pe-6 text-sm">
                            <Link :href="route('register')" class="font-semibold text-gray-500 hover:text-gray-700">
                                {{ $t('ui.register') }}
                            </Link>

                            <Link :href="route('login')" class="font-semibold text-gray-500 hover:text-gray-700">
                                {{ $t('ui.login') }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto p-4 sm:px-6 lg:px-8 p-4 py-12">
            <div class="space-y-6">
                <div v-for="store in stores" class="p-4 space-y-1 bg-white shadow rounded-lg">
                    <h2 class="text-lg font-semibold">
                        <Link :href="route('stores.show', store.id)" class="underline text-indigo-600">
                            {{ store.info.name }}
                        </Link>
                    </h2>

                    <div class="flex gap-3">
                        <h3>{{ $t('ui.stores.categories') }}:</h3>
                        <span v-for="category in store.categories" class="flex gap-1">
                            <Link :href="route('stores.show.category', [store.id, category.slug])"
                                  class="underline text-indigo-600">
                                {{ category.name }}
                            </Link>
                            ({{ category.products_count }})
                        </span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
