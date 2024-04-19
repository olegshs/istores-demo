<script setup>
import TextInput from "@/Components/TextInput.vue";
import {watch} from "vue";

const model = defineModel({
    type: String,
    required: true,
});

const clean = (value) =>
    value.toLowerCase()
        .replace(/[^a-z0-9]/g, '-')
        .replace(/-{2,}/g, '-')
        .replace(/^-+/, '');


const removeTrailingHyphen = (value) =>
    value.replace(/-+$/, '');

watch(model, (value) => {
    model.value = clean(value);
});
</script>

<template>
    <TextInput
        dir="ltr"
        class="rtl:text-right"
        v-model="model"
        @change="model = removeTrailingHyphen(model)"
    />
</template>
