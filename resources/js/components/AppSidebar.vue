<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { SharedData, type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { AlignStartHorizontal, AlignStartVertical, BookOpen, ChartArea, Clock, Coins, CoinsIcon, DiamondPercent, DollarSign, Folder, LayoutGrid, Package, Paperclip, Percent, Receipt, SquarePercent, SquareUser, UserCircle2, Users } from 'lucide-vue-next';
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
        isActive: page.url == new URL(route('invoices.index')).pathname || page.url == new URL(route('finance.statistics')).pathname,
        icon: Coins,
        subItems: [
            {
                title: 'Statistics',
                href: new URL(route('finance.statistics')).pathname,
                icon: ChartArea,
            },

            {
                title: 'Invoices',
                href: new URL(route('invoices.index')).pathname,
                icon: Paperclip,
            },
            {
                title: 'Payment Transactions',
                href: new URL(route('payments.index')).pathname,
                icon: CoinsIcon,
            },
        ],
    },

    {
        title: 'Warehouse Management',
        href: new URL(route('products.index')).pathname,
        icon: Package,
    },

    {
        title: 'HR Management',
        isActive: page.url == new URL(route('employees.index')).pathname,
        icon: Users,
        subItems: [
            {
                title: 'Statistics',
                href: new URL(route('hr.statistics')).pathname,
                icon: AlignStartVertical,
            },
            {
                title: 'Employees',
                href: new URL(route('employees.index')).pathname,
                icon: UserCircle2,
            },

            {
                title: 'Attendances',
                href: new URL(route('invoices.index')).pathname,
                icon: Clock,
            },
            {
                title: 'Payroll',
                href: new URL(route('payments.index')).pathname,
                icon: DollarSign,
            },
        ],
    },

    {
        title: 'Drive Files',
        href: new URL(route('folders.index')).pathname,
        icon: Folder,
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
