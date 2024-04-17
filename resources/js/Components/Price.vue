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
    <span dir="ltr">
        &#8362;&hairsp;{{ price }}
    </span>
</template>
