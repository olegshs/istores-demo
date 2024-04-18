<script setup>
import {computed} from "vue";

const props = defineProps({
    value: {
        type: [Number, String],
        required: true,
    },
});

const price = computed(() =>
    (Number(props.value) * 100).toString()
        .replace(/(\d\d)$/, '.$1'),
);
</script>

<template>
    <span dir="ltr" class="whitespace-nowrap">
        &#8362;&hairsp;{{ price }}
    </span>
</template>
