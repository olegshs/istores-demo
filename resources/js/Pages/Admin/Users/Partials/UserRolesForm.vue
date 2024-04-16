<script setup>
import {ref, toRaw} from "vue";
import {usePage} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const user = usePage().props.user;
const allRoles = usePage().props.all_roles;

const currentRoleIds = user.roles.map(role => role.id);

const roleMap = new Map();
toRaw(allRoles).forEach((role) => {
    const hasRole = currentRoleIds.indexOf(role.id) !== -1;
    roleMap.set(role.id, hasRole);
})

const toggleRole = (id) => {
    roleMap.set(id, !roleMap.get(id));
};

const saving = ref(false);
const saved = ref(false);

const save = () => {
    saving.value = true;

    const newRoleIds = [];
    roleMap.forEach((v, k) => {
        if (v) {
            newRoleIds.push(k);
        }
    });

    axios.put(route('admin.users.roles.update', user.id), {
        role_ids: newRoleIds,
    }).then(() => {
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
            <h2 class="text-lg font-medium text-gray-900">User Roles</h2>
        </header>

        <div class="mt-6 space-y-6">
            <div class="space-y-3">
                <div v-for="role in allRoles">
                    <label class="flex items-center">
                        <input type="checkbox" :checked="roleMap.get(role.id)" @change="toggleRole(role.id)"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"/>

                        <span class="ms-2">
                            {{ role.name }}
                        </span>
                    </label>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ role.description }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton @click="save" :disabled="saving">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="saved" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </div>
    </section>
</template>
