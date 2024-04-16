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
import LinkButton from "@/Components/LinkButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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
    <Head title="Users"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <Table>
                    <TableHead>
                        <HeadColumn>
                            ID&nbsp;&#9650;
                        </HeadColumn>
                        <HeadColumn>
                            Name
                        </HeadColumn>
                        <HeadColumn>
                            E-mail
                        </HeadColumn>
                        <HeadColumn>
                            Registered at
                        </HeadColumn>
                        <HeadColumn class="hidden lg:table-cell">
                            Roles
                        </HeadColumn>
                        <HeadColumn class="w-1">
                            Actions
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
                            <Column>
                                {{ format(parseISO(user.created_at), 'yyyy-MM-dd HH:mm:ss') }}
                            </Column>
                            <Column class="hidden lg:table-cell">
                                {{ user.roles.map(role => role.name).join(', ') }}
                            </Column>
                            <Column class="w-1">
                                <div class="flex gap-1">
                                    <PrimaryButton @click="switchStore(user.id)" :disabled="currentStore.id === user.id"
                                                   class="text-sm !px-3 !py-1">
                                        Switch
                                    </PrimaryButton>
                                    <LinkButton :href="route('admin.users.edit', user.id)" class="text-sm !px-3 !py-1">
                                        Edit
                                    </LinkButton>
                                    <DangerButton @click="confirmUserDeletion(user)" class="text-sm !px-3 !py-1">
                                        Delete
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
                    <div class="px-4 py-2 justify-end">Total: {{ total }}</div>
                </div>

            </div>
        </div>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete User #{{ userToDelete.id }}?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once the account is deleted, all of its resources and data will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': userDeleteForm.processing }"
                        :disabled="userDeleteForm.processing"
                        @click="deleteUser"
                    >
                        Delete User
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
