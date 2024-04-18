<script setup>
import TextInput from "@/Components/TextInput.vue";
import {watch} from "vue";

const props = defineProps({
    id: String,
    required: Boolean,
});

const model = defineModel({
    type: String,
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
        :id="id"
        :required="required"
        dir="ltr"
        class="rtl:text-right"
        v-model="model"
        @change="model = removeTrailingHyphen(model)"
    />
</template>
