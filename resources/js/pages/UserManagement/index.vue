<template>
    <Toaster />
    <div class="container py-6">
        <div class="flex flex-col space-y-2">
            <h2 class="text-3xl font-bold tracking-tight">User Management</h2>
            <p class="text-muted-foreground">
                Manage your users and their roles.
            </p>
        </div>
        <!-- Tabs for switching between user list and create user -->
        <div class="mb-8">
            <!-- Users List Tab -->
            <div class="mt-6 space-y-6">
                <div>
                    <div class="space-y-4">
                        <div class="flex flex-col md:flex-row justify-between gap-4 items-start md:items-center">
                            <div class="relative w-full md:w-auto md:min-w-[240px]">
                                <input v-model="searchQuery" placeholder="Search users..."
                                    class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2" />
                                <button v-if="searchQuery" @click="searchQuery = ''"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-x">
                                        <path d="M18 6 6 18" />
                                        <path d="m6 6 12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="w-full md:w-auto flex items-center gap-5">
                                <select v-model="roleFilter"
                                    class="w-full md:w-[180px] rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                                    <option value="all">All Roles</option>
                                    <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name
                                    }}</option>
                                </select>

                                <!-- create user dialog -->
                                <CreateUserDialog :roles="roles.data" :jobTitles="jobTitles"
                                    :order-status="orderStatus" />
                            </div>

                        </div>

                        <!-- Users Table -->
                        <div class="rounded-md border border-border overflow-x-auto">
                            <UsersTable :users="users.data" :roles="roles.data"  :job-titles="jobTitles"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Toaster from '@/components/ui/toast/Toaster.vue';
import CreateUserDialog from '@/components/UserDep/CreateUserDialog.vue'
import UsersTable from '@/components/UserDep/UsersTable.vue';
import AppLayout from '@/layouts/AppLayout.vue'
import { ref, computed, onMounted, nextTick } from 'vue'
const propsData = defineProps({
    users: Array,
    jobTitles: Array,
    roles: Array,
});


defineOptions({
    layout: AppLayout,
});
</script>