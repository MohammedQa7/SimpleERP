<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';
import QuickAccessCommand from './QuickAccessCommand.vue';
import { ChevronRight, Sparkles } from 'lucide-vue-next';
import { ref } from 'vue';
import WorkSession from './WorkSession.vue';
import WorkSessionV2 from './WorkSessionV2.vue';
const isOpen = ref(false);
defineProps<{
    breadcrumbs?: BreadcrumbItemType[];
}>();
</script>

<template>
    <header
        class="relative flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12 md:px-4">
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />

            <template v-if="breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>

            <!-- Hotkey for quick search -->
            <QuickAccessCommand />

            <!-- Checking in and out for employees -->
            <!-- <WorkSession /> -->
        </div>

    </header>



</template>