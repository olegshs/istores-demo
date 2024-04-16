<script setup>
import {ref, watch} from "vue";
import {useForm, usePage} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {formatDateTime} from "@/formatDateTime.js";

const category = usePage().props.category;
const createdAt = ref(formatDateTime(category.created_at));
const updatedAt = ref(formatDateTime(category.updated_at));

const form = useForm({
    slug: category.slug.toLowerCase(),
    name: category.name,
    description: category.description,
});

const slug = ref(form.slug);
const cleanSlug = (value) => {
    return value.toLowerCase()
        .replace(/[^a-z0-9]/g, '-')
        .replace(/-{2,}/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
};
watch(slug, value => {
    slug.value = cleanSlug(value);
    form.slug = slug.value;
});

const updateCategory = () => {
    form.patch(route('manage.categories.update', category.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <form @submit.prevent="updateCategory" class="mt-6 space-y-6">
        <div>
            <InputLabel for="category-id-input" value="ID"/>

            <TextInput
                id="category-id-input"
                type="text"
                class="mt-1 block w-full bg-gray-50"
                v-model="category.id"
                readonly="readonly"
            />
        </div>

        <div>
            <InputLabel for="category-slug-input" value="Slug" required/>

            <TextInput
                id="category-slug-input"
                type="text"
                class="mt-1 block w-full"
                v-model="slug"
                @blur="e => e.target.value = cleanSlug(e.target.value)"
                required
            />

            <InputError class="mt-2" :message="form.errors.slug"/>
        </div>

        <div>
            <InputLabel for="category-name-input" value="Name" required/>

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
            <InputLabel for="category-description-input" value="Description"/>

            <TextArea
                id="category-description-input"
                class="mt-1 block w-full"
                v-model="form.description"
            />

            <InputError class="mt-2" :message="form.errors.description"/>
        </div>

        <div>
            <InputLabel for="category-created_at-input" value="Created at"/>

            <TextInput
                id="category-created_at-input"
                type="text"
                class="mt-1 block w-full bg-gray-50"
                v-model="createdAt"
                readonly="readonly"
            />
        </div>

        <div>
            <InputLabel for="category-updated_at-input" value="Updated at"/>

            <TextInput
                id="category-updated_at-input"
                type="text"
                class="mt-1 block w-full bg-gray-50"
                v-model="updatedAt"
                readonly="readonly"
            />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

            <Transition
                enter-active-class="transition ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out"
                leave-to-class="opacity-0"
            >
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
            </Transition>
        </div>
    </form>
</template>
