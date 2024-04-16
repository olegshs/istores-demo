<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import StoreLayout from "@/Layouts/StoreLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Price from "@/Components/Price.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";

const props = defineProps({
    store: Object,
    order: Object,
});

const store = props.store;
const order = props.order;

const getTotal = () =>
    order.products.reduce(
        (sum, product) => sum + Number(product.price) * product.quantity,
        0,
    );

const changeQuantity = (orderProduct) => {
    axios.patch(
        route('orders.products.update', orderProduct.id),
        {
            quantity: orderProduct.quantity,
        },
    );
};

const deleteProduct = (orderProduct) => {
    axios.delete(
        route('orders.products.destroy', orderProduct.id),
    ).then(response => {
        order.products = order.products.filter(p => p.id !== orderProduct.id);
    });
}

const submitOrder = () => {
    const form = useForm(order.details);
    form.post(route('stores.cart.pay', store.id));
};
</script>

<template>
    <Head title="Checkout"/>

    <StoreLayout>
        <div class="p-6 text-gray-900 bg-white shadow sm:rounded-lg">
            <section>
                <header>
                    <h2 class="p-2 text-xl font-medium text-gray-900">
                        Cart
                    </h2>
                </header>
                <div v-if="order.products.length > 0">
                    <div
                        v-for="orderProduct in order.products"
                        class="flex flex-wrap items-center hover:bg-gray-100 py-2 lg:py-0 border-b"
                    >
                        <div class="w-full p-2 lg:w-1/2">
                            {{ orderProduct.product.name }}
                        </div>
                        <div class="w-full lg:w-1/2 flex items-center">
                            <div class="w-36 p-2 text-right">
                                <TextInput
                                    type="number"
                                    v-model="orderProduct.quantity"
                                    @change="changeQuantity(orderProduct)"
                                    class="w-20"
                                    min="1"
                                />
                            </div>
                            <div class="w-36 p-2 text-right">
                                <Price :value="orderProduct.price"/>
                            </div>
                            <div class="w-36 p-2 text-right">
                                <Price :value="orderProduct.price * orderProduct.quantity"/>
                            </div>
                            <div class="w-36 p-2 pe-0 text-right">
                                <DangerButton @click="deleteProduct(orderProduct)">
                                    Remove
                                </DangerButton>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center">
                        <div class="w-full p-2 lg:w-1/2">
                        </div>
                        <div class="w-full lg:w-1/2 flex items-center py-3">
                            <div class="w-36 p-2 text-right">
                            </div>
                            <div class="w-36 p-2 text-right">
                                Total:
                            </div>
                            <div class="w-36 p-2 text-right">
                                <Price :value="getTotal()"/>
                            </div>
                            <div class="w-36 p-2 pe-0 text-right">
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="p-2 text-gray-500">
                    <p>Your cart is empty.</p>
                </div>
            </section>
        </div>

        <div class="p-6 text-gray-900 bg-white shadow sm:rounded-lg">
            <section class="max-w-xl">
                <header>
                    <h2 class="p-2 text-xl font-medium text-gray-900">
                        Order Details
                    </h2>
                </header>
                <form class="p-2 py-4 space-y-6">
                    <div>
                        <InputLabel for="order-details-name-input" value="Name" required/>

                        <TextInput
                            id="order-details-name-input"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="order.details.name"
                            required
                        />
                    </div>
                    <div>
                        <InputLabel for="order-details-email-input" value="Email" required/>

                        <TextInput
                            id="order-details-email-input"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="order.details.email"
                            required
                        />
                    </div>
                    <div>
                        <InputLabel for="order-details-phone-input" value="Phone" required/>

                        <TextInput
                            id="order-details-phone-input"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="order.details.phone"
                            required
                        />
                    </div>
                    <div>
                        <InputLabel for="order-details-address-input" value="Address" required/>

                        <TextArea
                            id="order-details-address-input"
                            class="mt-1 block w-full"
                            v-model="order.details.address"
                            required
                        />
                    </div>
                    <div>
                        <InputLabel for="order-details-comment-input" value="Comment"/>

                        <TextArea
                            id="order-details-comment-input"
                            class="mt-1 block w-full"
                            v-model="order.details.comment"
                        />
                    </div>
                </form>
            </section>
        </div>

        <div class="p-6 text-gray-900 bg-white shadow sm:rounded-lg">
            <section class="max-w-xl">
                <header>
                    <h2 class="p-2 text-xl font-medium text-gray-900">
                        Pay
                    </h2>
                </header>
                <div class="p-2 space-y-6">
                    <PrimaryButton @click="submitOrder">
                        Pay with a credit card
                    </PrimaryButton>
                </div>
            </section>
        </div>
    </StoreLayout>
</template>