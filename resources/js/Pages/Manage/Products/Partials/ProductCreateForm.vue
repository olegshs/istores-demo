<script setup>
import {useForm} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import SlugInput from "@/Components/SlugInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const product = {
    slug: '',
    name: '',
    description: '',
    price: '',
};

const form = useForm({
    slug: product.slug,
    name: product.name,
    description: product.description,
    price: product.price,
});

const createProduct = () => {
    form.post(route('manage.products.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <form @submit.prevent="createProduct" class="mt-6 space-y-6">
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
                min="0"
                step=".01"
                class="mt-1 block w-full"
                v-model="form.price"
                required
            />

            <InputError class="mt-2" :message="form.errors.price"/>
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
