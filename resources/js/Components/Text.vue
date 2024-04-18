<script setup>
const props = defineProps({
    content: {
        type: String,
        required: true,
    }
});

const containsHebrew = (text) =>
    text.match(/[\u0590-\u05FF\uFB1D-\uFB4F]/);

const direction = containsHebrew(props.content)
    ? 'rtl'
    : 'ltr';

</script>

<template>
    <span :dir="direction" class="rtl:text-right">{{ content }}</span>
</template>
