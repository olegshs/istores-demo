<script setup>
import {ref} from "vue";
import {useForm, usePage} from '@inertiajs/vue3';
import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import HeadColumn from "@/Components/Table/HeadColumn.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import Row from "@/Components/Table/Row.vue";
import Column from "@/Components/Table/Column.vue";
import LinkButton from "@/Components/LinkButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import Pagination from "@/Components/Pagination.vue";

const props = usePage().props;
const products = props.products.data;
const total = props.products.total;

let productToDelete = null;
let confirmingDeletion = ref(false);

const confirmDeletion = (product) => {
    productToDelete = product;
    confirmingDeletion.value = true;
};

const deleteForm = useForm({});

const deleteProduct = () => {
    deleteForm.delete(route('manage.products.destroy', productToDelete.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => deleteForm.reset(),
    })
};

const closeModal = () => {
    productToDelete = null;
    confirmingDeletion.value = false;
};
</script>

<template>
    <Table>
        <TableHead>
            <HeadColumn>
                ID&nbsp;&#9660;
            </HeadColumn>
            <HeadColumn>
                Slug
            </HeadColumn>
            <HeadColumn>
                Name
            </HeadColumn>
            <HeadColumn class="hidden lg:table-cell">
                Description
            </HeadColumn>
            <HeadColumn class="hidden lg:table-cell">
                Categories
            </HeadColumn>
            <HeadColumn>
                Price
            </HeadColumn>
            <HeadColumn class="w-1">
                Actions
            </HeadColumn>
        </TableHead>
        <TableBody>
            <Row v-for="product in products">
                <Column>
                    {{ product.id }}
                </Column>
                <Column>
                    {{ product.slug }}
                </Column>
                <Column>
                    {{ product.name }}
                </Column>
                <Column class="hidden lg:table-cell">
                    {{ product.description }}
                </Column>
                <column class="hidden lg:table-cell">
                    {{ product.categories.map(category => category.name).join(', ') }}
                </column>
                <Column>
                    {{ product.price }}
                </Column>
                <Column class="w-1">
                    <div class="flex gap-1">
                        <LinkButton :href="route('manage.products.edit', product.id)" class="text-sm !px-3 !py-1">
                            Edit
                        </LinkButton>
                        <DangerButton @click="confirmDeletion(product)" class="text-sm !px-3 !py-1">
                            Delete
                        </DangerButton>
                    </div>
                </Column>
            </Row>
        </TableBody>
    </Table>

    <div class="flex">
        <div class="flex-1">
            <Pagination :links="props.products.links"/>
        </div>
        <div class="px-4 py-2 justify-end">Total: {{ total }}</div>
    </div>

    <Modal :show="confirmingDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Are you sure you want to delete Product #{{ productToDelete.id }}?
            </h2>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    Cancel
                </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{ 'opacity-25': deleteForm.processing }"
                    :disabled="deleteForm.processing"
                    @click="deleteProduct"
                >
                    Delete Product
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
