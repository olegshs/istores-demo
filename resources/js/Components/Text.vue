<script setup>
const props = defineProps({
    content: {
        required: true,
    }
});

const containsHebrew = (text) =>
    (text !== null)
        ? text.toString().match(/[\u0590-\u05FF\uFB1D-\uFB4F]/)
        : false;

const direction = containsHebrew(props.content)
    ? 'rtl'
    : 'ltr';

</script>

<template>
    <span :dir="direction" class="rtl:text-right">{{ content }}</span>
</template>
