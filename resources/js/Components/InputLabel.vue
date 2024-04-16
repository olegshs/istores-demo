<script setup>
defineProps({
    value: {
        type: String,
    },
    required: {
        type: Boolean,
    },
});
</script>

<template>
    <label class="block font-medium text-sm text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot/></span>

        <span v-if="required" title="Required field" class="text-red-600">&nbsp;*</span>
    </label>
</template>
