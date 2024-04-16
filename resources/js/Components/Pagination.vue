<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    links: Array,
});
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links">
                <div v-if="link.url === null"
                     :key="key"
                     v-html="link.label"
                     class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded cursor-default"
                />
                <Link v-else
                      :key="`link-${key}`"
                      :href="link.url"
                      v-html="link.label"
                      class="mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-sm leading-4 hover:bg-white border focus:border-indigo-500 rounded"
                      :class="{ 'bg-white': link.active }"
                />
            </template>
        </div>
    </div>
</template>
