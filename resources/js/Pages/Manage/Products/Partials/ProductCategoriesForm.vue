<script setup>
import {ref, toRaw} from "vue";
import {usePage} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Text from "@/Components/Text.vue";

const product = usePage().props.product;
const allCategories = usePage().props.all_categories;

const currentCategoryIds = product.categories.map(category => category.id);

const categoryMap = new Map();
toRaw(allCategories).forEach((category) => {
    const hasCategory = currentCategoryIds.indexOf(category.id) !== -1;
    categoryMap.set(category.id, hasCategory);
})

const toggleCategory = (id) => {
    categoryMap.set(id, !categoryMap.get(id));
};

const saving = ref(false);
const saved = ref(false);

const save = () => {
    saving.value = true;

    const newCategoryIds = [];
    categoryMap.forEach((v, k) => {
        if (v) {
            newCategoryIds.push(k);
        }
    });

    axios.put(route('manage.products.categories.update', product.id), {
        category_ids: newCategoryIds,
    }).then(response => {
        saving.value = false;
        saved.value = true;

        setTimeout(() => {
            saved.value = false;
        }, 2000);
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ $t('ui.categories.title') }}
            </h2>
        </header>

        <div class="mt-6 space-y-6">
            <div class="space-y-3">
                <div v-for="category in allCategories">
                    <label class="flex items-center">
                        <input type="checkbox" :checked="categoryMap.get(category.id)"
                               @change="toggleCategory(category.id)"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"/>

                        <span class="ms-2">
                            {{ category.name }}
                        </span>
                    </label>
                    <p class="mt-1 text-sm text-gray-600">
                        <Text :content="category.description"/>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton @click="save" :disabled="saving">
                    {{ $t('ui.save') }}
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="saved" class="text-sm text-gray-600">
                        {{ $t('ui.saved') }}
                    </p>
                </Transition>
            </div>
        </div>
    </section>
</template>
