<script setup>
import {ref} from "vue";
import {Head} from "@inertiajs/vue3";
import StoreLayout from "@/Layouts/StoreLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Minicart from "@/Components/Store/Minicart.vue";
import Price from "@/Components/Price.vue";
import LinkButton from "@/Components/LinkButton.vue";

const props = defineProps({
    store: Object,
    category: Object,
    products: Array,
    order: Object,
});

const store = props.store;
const category = props.category;
const order = props.order;
const cartVisible = ref(false);

let title = store.info.name;
if (category) {
    title = `${category.name} - ${title}`;
}

const hasInCart = (product) => {
    if (!order.products) {
        return false;
    }

    for (const orderProduct of order.products) {
        if (orderProduct.product.id === product.id) {
            return true;
        }
    }
    return false;
};

const addToCart = (product) => {
    axios.post(
        route('orders.products.store'),
        {
            product_id: product.id,
        },
    ).then(response => {
        const orderProduct = response.data;
        order.products.push(orderProduct);
        cartVisible.value = true;
    });
};

const deleteOrderProduct = (orderProduct) => {
    axios.delete(
        route('orders.products.destroy', orderProduct.id),
    ).then(response => {
        order.products = order.products.filter(p => p.id !== orderProduct.id);
    });
};

const closeCart = () => {
    cartVisible.value = false;
}
</script>

<template>
    <Head :title="title"/>

    <StoreLayout>
        <Minicart
            :cartVisible="cartVisible"
            @delete-product="deleteOrderProduct"
            @close="closeCart"
        />

        <div class="space-y-6">
            <div v-if="category && category.description">
                <p>{{ category.description }}</p>
            </div>

            <div class="flex flex-wrap gap-6">
                <div v-for="product in products" class="flex flex-col p-4 space-y-3 bg-white shadow rounded-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="#cccccc"
                             viewBox="0 0 350 350">
                            <path
                                d="M5,350h340V0H5V350z M25,330v-62.212h300V330H25z M179.509,247.494H60.491L120,171.253L179.509,247.494z M176.443,211.061l33.683-32.323l74.654,69.05h-79.67L176.443,211.061z M325,96.574c-6.384,2.269-13.085,3.426-20,3.426 c-33.084,0-60-26.916-60-60c0-6.911,1.156-13.612,3.422-20H325V96.574z M25,20h202.516C225.845,26.479,225,33.166,225,40 c0,44.112,35.888,80,80,80c6.837,0,13.523-0.846,20-2.518v130.306h-10.767l-104.359-96.526l-45.801,43.951L120,138.748 l-85.109,109.04H25V20z"/>
                        </svg>
                    </div>

                    <div class="flex-1" style="max-width: 200px;">
                        {{ product.name }}
                    </div>

                    <div>
                        <Price :value="product.price"/>
                    </div>

                    <div>
                        <PrimaryButton v-if="!hasInCart(product)" @click="addToCart(product)">
                            Add to cart
                        </PrimaryButton>
                        <LinkButton v-else :href="route('stores.cart.checkout', store.id)">
                            Go to cart
                        </LinkButton>
                    </div>
                </div>
            </div>
        </div>
    </StoreLayout>
</template>
