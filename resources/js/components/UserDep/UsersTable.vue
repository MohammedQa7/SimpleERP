<template>
    <table class="w-full">
        <thead>
            <tr class="border-b border-border bg-muted/50">
                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                    Name</th>
                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                    Email</th>
                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                    Role</th>
                <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">
                    Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id" class="border-b border-border transition-colors hover:bg-muted/50">
                <td class="p-4 align-middle font-medium">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-muted flex items-center justify-center overflow-hidden">
                            <img v-if="user.profilePhotoUrl" :src="user.profilePhotoUrl" :alt="user.profilePhotoUrl"
                                class="h-full w-full object-cover" />
                            <span v-else class="text-muted-foreground font-medium">{{
                                getUserInitials(user.name) }}</span>
                        </div>
                        <span>{{ user.name }}</span>
                    </div>
                </td>
                <td class="p-4 align-middle">{{ user.email }}</td>
                <td class="p-4 align-middle">
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                        <Collapsible v-model:open="isOpen" class="w-[350px] space-y-2">
                            <div class="flex items-center justify-between space-x-4 ">
                                <Badge :class="getRoleBadgeClass(user?.roles[0]?.label)">
                                    {{ user?.roles[0]?.label ?? 'None' }}
                                </Badge>
                                <CollapsibleTrigger v-if="user.roles.length > 1" as-child>
                                    <Button variant="ghost" size="sm" class=" px-2">
                                        <ChevronsUpDown class="h-4 w-4" />
                                        <span>More</span>
                                    </Button>
                                </CollapsibleTrigger>
                            </div>
                            <CollapsibleContent v-for="(role, index) in user.roles" :key="index" class="space-y-2">
                                <Badge v-if="index != 0" :class="getRoleBadgeClass(role.label)">
                                    {{ role?.label }}
                                </Badge>
                            </CollapsibleContent>
                        </Collapsible>
                    </span>

                </td>
                <td class="p-4 align-middle text-right">
                    <div class="relative inline-block text-left">
                        <DropdownMenu>
                            <DropdownMenuTrigger>
                                <Button variant="ghost">
                                    <EllipsisVertical class=" rotate-90" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent class=" me-12">
                                <DropdownMenuLabel>Modifications</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem @click.prevent="toggleEditUserDialog(true, user.accountCode)">
                                    <Edit2 />
                                    Edit
                                </DropdownMenuItem>

                                <DropdownMenuItem>
                                    <UserRoundCog />
                                    Change Role
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </td>
            </tr>
            <tr v-if="users.length === 0">
                <td colspan="5" class="p-4 text-center py-6">No users found</td>
            </tr>
        </tbody>
    </table>

    <EditUserDialog v-if="isEditingDialogOpened" :is-open="isEditingDialogOpened" :is-loading="isLoading"
        :user="user?.data" :job-titles="jobTitles" :roles="roles" @Close="toggleEditUserDialog" />
</template>

<script setup>
import { ChevronsUpDown, Edit2, EllipsisVertical, Flame, Loader2, UserRoundCog } from 'lucide-vue-next';
import Collapsible from '../ui/collapsible/Collapsible.vue';
import CollapsibleTrigger from '../ui/collapsible/CollapsibleTrigger.vue';
import Button from '../ui/button/Button.vue';
import CollapsibleContent from '../ui/collapsible/CollapsibleContent.vue';
import Badge from '../ui/badge/Badge.vue';
import { getRoleBadgeClass } from '@/composables/getRoleBadgeClass.js';
import DropdownMenu from '../ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '../ui/dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '../ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuLabel from '../ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuSeparator from '../ui/dropdown-menu/DropdownMenuSeparator.vue';
import DropdownMenuItem from '../ui/dropdown-menu/DropdownMenuItem.vue';
import EditUserDialog from './EditUserDialog.vue';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
const isEditingDialogOpened = ref(false);
const isLoading = ref(false);
const user = ref(null);
const propsData = defineProps({
    users: Array,
    roles: Array,
    jobTitles: Array
});


const toggleEditUserDialog = (eventData = true, employeeCode) => {
    isLoading.value = true;
    isEditingDialogOpened.value = true;
    if (eventData) {
        router.visit(route('users.edit', { user: employeeCode }), {
            only: ['user'],
            preserveScroll: true,
            preserveState: true,
            preserveUrl: true,
            onSuccess: (page) => {
                user.value = page.props.user;
                isLoading.value = false;
            },
            onError: () => {
                isEditingDialogOpened.value = false;
                isLoading.value = false;
            }
        })

    } else {
        // Close the dialog (this event data is coming the defineEmit in the composable closeDialog.js file)
        isEditingDialogOpened.value = eventData;
    }
}

const getUserInitials = (name) => {
    if (!name) return ''
    return name
        .split(' ')
        .map(part => part.charAt(0))
        .join('')
        .toUpperCase()
        .substring(0, 2)
}




</script>