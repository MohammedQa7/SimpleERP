<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { SharedData, type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, DiamondPercent, Folder, LayoutGrid, Percent, SquarePercent, SquareUser } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
const page = usePage<SharedData>();
const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },


    {
        title: 'Sales Management',
        href: new URL(route('orders.index')).pathname,
        icon: SquarePercent,
    },

    {
        title: 'Users Management',
        href: new URL(route('users.index')).pathname,
        icon: SquareUser,
    },

    {
        title: 'Finance Management',
        isActive: page.url == new URL(route('invoices.index')).pathname || page.url == new URL(route('users.index')).pathname,
        icon: SquareUser,
        subItems: [
            {
                title: 'Statistics',
                href: new URL(route('users.index')).pathname,
                icon: SquareUser,
            },

            {
                title: 'Invoices',
                href: new URL(route('invoices.index')).pathname,
                icon: SquareUser,
            },
        ],
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
