<script setup>
import {ref} from "vue";
import {useForm, usePage} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import SlugInput from "@/Components/SlugInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {formatDateTime} from "@/formatDateTime.js";

const product = usePage().props.product;
const createdAt = ref(formatDateTime(product.created_at));
const updatedAt = ref(formatDateTime(product.updated_at));

const form = useForm({
    slug: product.slug.toLowerCase(),
    name: product.name,
    description: product.description,
    price: product.price,
});

const updateProduct = () => {
    form.patch(route('manage.products.update', product.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <form @submit.prevent="updateProduct" class="mt-6 space-y-6">
        <div>
            <InputLabel for="product-id-input" :value="$t('ui.id')"/>

            <TextInput
                id="product-id-input"
                type="text"
                class="mt-1 block w-full bg-gray-50"
                v-model="product.id"
                readonly="readonly"
            />
        </div>

        <div>
            <InputLabel for="product-slug-input" :value="$t('ui.slug')" required/>

            <SlugInput
                id="product-slug-input"
                class="mt-1 block w-full"
                v-model="form.slug"
                required
            />

            <InputError class="mt-2" :message="form.errors.slug"/>
        </div>

        <div>
            <InputLabel for="product-name-input" :value="$t('ui.name')" required/>

            <TextInput
                id="product-name-input"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
            />

            <InputError class="mt-2" :message="form.errors.name"/>
        </div>

        <div>
            <InputLabel for="product-description-input" :value="$t('ui.description')"/>

            <TextArea
                id="product-description-input"
                class="mt-1 block w-full"
                v-model="form.description"
            />

            <InputError class="mt-2" :message="form.errors.description"/>
        </div>

        <div>
            <InputLabel for="product-price-input" :value="$t('ui.products.price')" required/>

            <TextInput
                id="product-price-input"
                type="number"
                step=".01"
                class="mt-1 block w-full"
                v-model="form.price"
                required
            />

            <InputError class="mt-2" :message="form.errors.price"/>
        </div>

        <div>
            <InputLabel for="product-created_at-input" :value="$t('ui.created_at')"/>

            <TextInput
                id="product-created_at-input"
                type="text"
                class="mt-1 block w-full bg-gray-50"
                v-model="createdAt"
                readonly="readonly"
            />
        </div>

        <div>
            <InputLabel for="product-updated_at-input" :value="$t('ui.updated_at')"/>

            <TextInput
                id="product-updated_at-input"
                type="text"
                class="mt-1 block w-full bg-gray-50"
                v-model="updatedAt"
                readonly="readonly"
            />
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
