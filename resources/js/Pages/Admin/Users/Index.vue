<script setup>
import {ref} from "vue";
import {format, parseISO} from "date-fns";
import {Head, useForm, usePage} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import HeadColumn from "@/Components/Table/HeadColumn.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import Row from "@/Components/Table/Row.vue";
import Column from "@/Components/Table/Column.vue";
import LinkPrimaryButton from "@/Components/LinkPrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    users: Object,
})

const currentStore = ref(usePage().props.store);
const switchStore = (newStoreId) => {
    axios.put(route('admin.stores.current.change'), {
        id: newStoreId,
    }).then(response => {
        currentStore.value = response.data;
        location.reload();
    });
};

const users = props.users.data;
const total = props.users.total;

let userToDelete = null;
const confirmingUserDeletion = ref(false);

const confirmUserDeletion = (user) => {
    userToDelete = user;
    confirmingUserDeletion.value = true;
};

const userDeleteForm = useForm({});

const deleteUser = () => {
    userDeleteForm.delete(route('admin.users.destroy', userToDelete.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => userDeleteForm.reset(),
    });
};

const closeModal = () => {
    userToDelete = null;
    confirmingUserDeletion.value = false;
};
</script>

<template>
    <Head :title="$t('ui.users.title')"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('ui.users.title') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <Table>
                    <TableHead>
                        <HeadColumn>
                            {{ $t('ui.id') }}&nbsp;&#9650;
                        </HeadColumn>
                        <HeadColumn>
                            {{ $t('ui.name') }}
                        </HeadColumn>
                        <HeadColumn>
                            {{ $t('ui.email') }}
                        </HeadColumn>
                        <HeadColumn>
                            {{ $t('ui.users.created_at') }}
                        </HeadColumn>
                        <HeadColumn class="hidden lg:table-cell">
                            {{ $t('ui.users.roles') }}
                        </HeadColumn>
                        <HeadColumn class="w-1">
                            {{ $t('ui.actions') }}
                        </HeadColumn>
                    </TableHead>

                    <TableBody>
                        <Row v-for="user in users"
                             :class="(currentStore.id === user.id) ? 'bg-indigo-50 hover:bg-indigo-100' : ''">
                            <Column>
                                {{ user.id }}
                            </Column>
                            <Column>
                                {{ user.name }}
                            </Column>
                            <Column>
                                {{ user.email }}
                            </Column>
                            <Column dir="ltr" class="rtl:text-right">
                                {{ format(parseISO(user.created_at), 'yyyy-MM-dd HH:mm:ss') }}
                            </Column>
                            <Column class="hidden lg:table-cell">
                                {{ user.roles.map(role => role.name).join(', ') }}
                            </Column>
                            <Column class="w-1">
                                <div class="flex gap-1">
                                    <SecondaryButton @click="switchStore(user.id)"
                                                     :disabled="currentStore.id === user.id"
                                                     class="text-sm !px-3 !py-1">
                                        {{ $t('ui.users.switch') }}
                                    </SecondaryButton>
                                    <LinkPrimaryButton :href="route('admin.users.edit', user.id)"
                                                       class="text-sm !px-3 !py-1">
                                        {{ $t('ui.edit') }}
                                    </LinkPrimaryButton>
                                    <DangerButton @click="confirmUserDeletion(user)" class="text-sm !px-3 !py-1">
                                        {{ $t('ui.delete') }}
                                    </DangerButton>
                                </div>
                            </Column>
                        </Row>
                    </TableBody>
                </Table>

                <div class="flex">
                    <div class="flex-1">
                        <Pagination :links="props.users.links"/>
                    </div>
                    <div class="px-4 py-2 justify-end">{{ $t('ui.total') }}: {{ total }}</div>
                </div>

            </div>
        </div>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ $t('ui.users.delete_confirm.text', {id: userToDelete.id}) }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ $t('ui.users.delete_confirm.description') }}
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        {{ $t('ui.cancel') }}
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': userDeleteForm.processing }"
                        :disabled="userDeleteForm.processing"
                        @click="deleteUser"
                    >
                        {{ $t('ui.users.delete') }}
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
