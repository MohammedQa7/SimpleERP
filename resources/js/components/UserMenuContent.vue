<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import type { User } from '@/types';
import { Link } from '@inertiajs/vue3';
import { CircleIcon, LogOut, Plus, Settings } from 'lucide-vue-next';
import AccountSwticher from './AccountSwitcher.vue';
import Separator from './ui/separator/Separator.vue';
import Badge from './ui/badge/Badge.vue';
interface Props {
    user: User;
}

defineProps<Props>();
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal space-y-2">
        <div>
            <span class="flex  p-1 text-left text-xs font-bold">Accounts</span>
            <div class="flex items-center gap-2  text-left text-sm mb-2 p-1">
                <UserInfo :user="user" :show-email="true" />
                <Badge class="bg-muted px-1 py-0.5 pointer-events-none">
                    <CircleIcon :size="8" class="fill-green-700 " />
                </Badge>
            </div>

            <!-- Other logged in accounts -->
            <AccountSwticher />
        </div>

        <Separator />

        <!-- Sign in with new account section -->
        <DropdownMenuItem :as-child="true">
            <Link :href="route('accounts.switch.login')">
                <Plus class="size-4" />
                <div class="text-muted-foreground">
                    Sign in with new account
                </div>
            </Link>
        </DropdownMenuItem>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="route('profile.edit')" as="button">
                <Settings class="mr-2 h-4 w-4" />
                Settings
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem :as-child="true">
        <Link class="block w-full" method="post" :href="route('logout')" as="button">
            <LogOut class="mr-2 h-4 w-4" />
            Log out
        </Link>
    </DropdownMenuItem>
</template>
