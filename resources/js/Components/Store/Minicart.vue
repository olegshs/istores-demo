<script setup>
import {usePage} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import LinkPrimaryButton from "@/Components/LinkPrimaryButton.vue";
import Price from "@/Components/Price.vue";

const props = defineProps({
    cartVisible: Boolean,
});

const emit = defineEmits([
    'close',
    'deleteProduct',
]);

const close = () => {
    emit('close');
};

const store = usePage().props.store;
const order = usePage().props.order;

const deleteProduct = (orderProduct) => {
    emit('deleteProduct', orderProduct);
}
</script>

<template>
    <Modal :show="cartVisible && (order.products.length > 0)" @close="close">
        <div class="p-6">
            <h2 class="text-xl font-medium text-gray-500 p-2">
                {{ $t('ui.cart.title') }}
            </h2>

            <div>
                <div v-for="orderProduct in order.products" class="flex items-baseline p-2 hover:bg-gray-100 border-b">
                    <div class="flex-1">
                        {{ orderProduct.product.name }}
                    </div>
                    <div class="px-4">
                        <Price :value="orderProduct.price"/>
                    </div>
                    <div>
                        <DangerButton @click="deleteProduct(orderProduct)" class="text-sm !px-2 !py-1">
                            {{ $t('ui.cart.remove') }}
                        </DangerButton>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="close">
                    {{ $t('ui.cart.close') }}
                </SecondaryButton>

                <LinkPrimaryButton
                    :href="route('stores.cart.checkout', store.id)"
                    class="ms-3"
                    @click=""
                >
                    {{ $t('ui.cart.checkout') }}
                </LinkPrimaryButton>
            </div>
        </div>
    </Modal>
</template>
