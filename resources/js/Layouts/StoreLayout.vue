<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavLink from "@/Components/NavLink.vue";

const store = usePage().props.store;
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex flex-1 items-center space-x-6">
                        <!-- Logo -->
                        <div class="shrink-0">
                            <Link :href="route('stores.index')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800"/>
                            </Link>
                        </div>

                        <div class="flex-1">
                            <h1 class="text-xl font-semibold text-gray-800 ms-4">
                                <Link :href="route('stores.show', store.id)">
                                    {{ store.info.name }}
                                </Link>
                            </h1>
                        </div>

                        <div v-if="$page.props.auth.user" class="space-x-6 pe-6 text-sm">
                            <Link :href="route('dashboard')" class="font-semibold text-gray-500 hover:text-gray-700">
                                Dashboard
                            </Link>
                        </div>
                        <div v-else class="space-x-6 pe-6 text-sm">
                            <Link :href="route('register')" class="font-semibold text-gray-500 hover:text-gray-700">
                                Register
                            </Link>

                            <Link :href="route('login')" class="font-semibold text-gray-500 hover:text-gray-700">
                                Log In
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex flex-1 -my-px space-x-6">
                            <NavLink v-for="category in store.categories"
                                     :href="route('stores.show.category', [store.id, category.slug])"
                                     :active="route().current('stores.show.category', [store.id, category.slug])">
                                {{ category.name }}

                                <span class="text-gray-400 ms-1">
                                    ({{ category.products_count }})
                                </span>
                            </NavLink>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8 space-y-6">
            <div class="space-y-6">
                <slot/>
            </div>
        </main>
    </div>
</template>
