<script setup>
import {ref} from "vue";
import {router, usePage} from '@inertiajs/vue3';
import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import HeadColumn from "@/Components/Table/HeadColumn.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import Row from "@/Components/Table/Row.vue";
import Column from "@/Components/Table/Column.vue";
import LinkPrimaryButton from "@/Components/LinkPrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Text from "@/Components/Text.vue";
import Modal from "@/Components/Modal.vue";
import Pagination from "@/Components/Pagination.vue";

const props = usePage().props;
const categories = props.categories.data;
const total = props.categories.total;

let categoryToDelete = null;
const confirmingDeletion = ref(false);
const deleting = ref(false);

const confirmDeletion = (category) => {
    categoryToDelete = category;
    confirmingDeletion.value = true;
};

const deleteCategory = () => {
    deleting.value = true;

    router.delete(route('manage.categories.destroy', categoryToDelete.id), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => {
            closeModal();
        },
        onFinish: () => {
            deleting.value = false
        }
    });
};

const closeModal = () => {
    categoryToDelete = null;
    confirmingDeletion.value = false;
};
</script>

<template>
    <Table>
        <TableHead>
            <HeadColumn>
                {{ $t('ui.id') }}
            </HeadColumn>
            <HeadColumn>
                {{ $t('ui.slug') }}
            </HeadColumn>
            <HeadColumn>
                {{ $t('ui.name') }}&nbsp;&#9650;
            </HeadColumn>
            <HeadColumn class="hidden lg:table-cell">
                {{ $t('ui.description') }}
            </HeadColumn>
            <HeadColumn class="w-1">
                {{ $t('ui.actions') }}
            </HeadColumn>
        </TableHead>
        <TableBody>
            <Row v-for="category in categories">
                <Column>
                    {{ category.id }}
                </Column>
                <Column>
                    {{ category.slug }}
                </Column>
                <Column>
                    <Text :content="category.name"/>
                </Column>
                <Column class="hidden lg:table-cell">
                    <Text :content="category.description"/>
                </Column>
                <Column class="w-1">
                    <div class="flex gap-1">
                        <LinkPrimaryButton :href="route('manage.categories.edit', category.id)"
                                           class="text-sm !px-3 !py-1">
                            {{ $t('ui.edit') }}
                        </LinkPrimaryButton>
                        <DangerButton @click="confirmDeletion(category)" class="text-sm !px-3 !py-1">
                            {{ $t('ui.delete') }}
                        </DangerButton>
                    </div>
                </Column>
            </Row>
        </TableBody>
    </Table>

    <div class="flex">
        <div class="flex-1">
            <Pagination :links="props.categories.links"/>
        </div>
        <div class="px-4 py-2 justify-end">{{ $t('ui.total') }}: {{ total }}</div>
    </div>

    <Modal :show="confirmingDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ $t('ui.categories.delete_confirm.text', {id: categoryToDelete.id}) }}
            </h2>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    {{ $t('ui.cancel') }}
                </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{ 'opacity-25': deleting }"
                    :disabled="deleting"
                    @click="deleteCategory"
                >
                    {{ $t('ui.categories.delete') }}
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
