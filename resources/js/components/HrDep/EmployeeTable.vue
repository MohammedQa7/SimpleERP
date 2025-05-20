<template>
    <div class="overflow-x-auto">
        <table v-if="employees?.data?.length > 0" class="w-full border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-3 px-4 font-medium text-muted-foreground">Employee</th>
                    <th class="text-left py-3 px-4 font-medium text-muted-foreground">Department</th>
                    <th class="text-left py-3 px-4 font-medium text-muted-foreground">Position</th>
                    <th class="text-left py-3 px-4 font-medium text-muted-foreground">Contact</th>
                    <th class="text-right py-3 px-4 font-medium text-muted-foreground">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="employee in employees.data" :key="employee.id" class="border-b hover:bg-muted/50">
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <Avatar class="h-8 w-8">
                                <AvatarImage :src="employee.avatar" :alt="employee.name" />
                                <AvatarFallback>{{ getUserInitials(employee.name) }}</AvatarFallback>
                            </Avatar>
                            <div>
                                <p class="font-medium">{{ employee.name }}</p>
                                <p class="text-xs text-muted-foreground">{{ employee.employeeCode }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <Badge>
                            {{ employee.department || 'None' }}
                        </Badge>
                    </td>
                    <td class="py-3 px-4">{{ employee.jobTitle }}</td>
                    <td class="py-3 px-4">
                        <p>{{ employee.email }}</p>
                        <p class="text-xs text-muted-foreground">{{ employee.phoneNumber }}</p>
                    </td>
                    <td class="py-3 px-4 text-right">
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="ghost" size="icon">
                                    <MoreHorizontal class="h-4 w-4" />
                                    <span class="sr-only">Actions</span>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuItem>
                                    <User class="mr-2 h-4 w-4" />
                                    <span>View Profile</span>
                                </DropdownMenuItem>
                                <DropdownMenuItem>
                                    <Edit class="mr-2 h-4 w-4" />
                                    <span>Edit Details</span>
                                </DropdownMenuItem>
                                <DropdownMenuItem>
                                    <FileText class="mr-2 h-4 w-4" />
                                    <span>View Documents</span>
                                </DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem>
                                    <Trash class="mr-2 h-4 w-4" />
                                    <span>Delete</span>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Empty State -->
        <div v-else
            class="mt-8 flex flex-col items-center justify-center rounded-lg border-2 border-dashed  border-muted-foreground bg-muted p-12 text-center">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-50">
                <Users class="h-10 w-10 text-primary-foreground" />
            </div>
            <h3 class="mt-4 text-lg font-medium text-primary">No employees found</h3>
        </div>
    </div>
    <CustomPagination :item="employees" />

    <EditUserDialog v-if="isEditingDialogOpened" :is-open="isEditingDialogOpened" :is-loading="isLoading"
        :user="user?.data" :job-titles="jobTitles" :roles="roles" @update:open="isEditingDialogOpened = $event" />
</template>

<script setup>
import Button from '../ui/button/Button.vue';
import DropdownMenu from '../ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '../ui/dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '../ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuSeparator from '../ui/dropdown-menu/DropdownMenuSeparator.vue';
import DropdownMenuItem from '../ui/dropdown-menu/DropdownMenuItem.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import EditUserDialog from '../UserDep/EditUserDialog.vue';
import CustomPagination from '../CustomPagination.vue';
import { Edit, FileText, MoreHorizontal, Trash, User, Users } from 'lucide-vue-next';
import Badge from '../ui/badge/Badge.vue';
import Avatar from '../ui/avatar/Avatar.vue';
import AvatarImage from '../ui/avatar/AvatarImage.vue';
import AvatarFallback from '../ui/avatar/AvatarFallback.vue';
const isOpen = ref(true);
const isEditingDialogOpened = ref(false);
const isLoading = ref(false);
const user = ref(null);
const propsData = defineProps({
    employees: Array,
    roles: Array,
    departments: Array
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