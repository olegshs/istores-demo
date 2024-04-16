<script setup>
import {computed} from "vue";

const props = defineProps({
    value: {
        type: Number,
        required: true,
    },
});

const price = computed(() =>
    (props.value * 100).toString()
        .replace(/(\d\d)$/, '.$1'),
);
</script>

<template>
    <span style="white-space:nowrap;">
        &#8362;
        {{ price }}
    </span>
</template>
