<script setup>
import {useForm} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import SlugInput from "@/Components/SlugInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const category = {
    slug: null,
    name: null,
    description: null,
};

const form = useForm({
    slug: category.slug,
    name: category.name,
    description: category.description,
});

const createCategory = () => {
    form.post(route('manage.categories.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <form @submit.prevent="createCategory" class="mt-6 space-y-6">
        <div>
            <InputLabel for="category-slug-input" :value="$t('ui.slug')" required/>

            <SlugInput
                id="category-slug-input"
                class="mt-1 block w-full"
                v-model="form.slug"
                required
            />

            <InputError class="mt-2" :message="form.errors.slug"/>
        </div>

        <div>
            <InputLabel for="category-name-input" :value="$t('ui.name')" required/>

            <TextInput
                id="category-name-input"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
            />

            <InputError class="mt-2" :message="form.errors.name"/>
        </div>

        <div>
            <InputLabel for="category-description-input" :value="$t('ui.description')"/>

            <TextArea
                id="category-description-input"
                class="mt-1 block w-full"
                v-model="form.description"
            />

            <InputError class="mt-2" :message="form.errors.description"/>
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing">
                {{ $t('ui.save') }}
            </PrimaryButton>

            <Transition
                enter-active-class="transition ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out"
                leave-to-class="opacity-0"
            >
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                    {{ $t('ui.saved') }}
                </p>
            </Transition>
        </div>
    </form>
</template>
