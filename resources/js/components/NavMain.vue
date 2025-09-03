<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import Collapsible from './ui/collapsible/Collapsible.vue';
import CollapsibleTrigger from './ui/collapsible/CollapsibleTrigger.vue';
import CollapsibleContent from './ui/collapsible/CollapsibleContent.vue';
import SidebarMenuSub from './ui/sidebar/SidebarMenuSub.vue';
import SidebarMenuSubItem from './ui/sidebar/SidebarMenuSubItem.vue';
import SidebarMenuSubButton from './ui/sidebar/SidebarMenuSubButton.vue';
import { ChevronRight } from 'lucide-vue-next';
import { computed, ref } from 'vue';

defineProps<{
    items: NavItem[];
}>();

const page = usePage<SharedData>();

</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton v-if="item.href" as-child :is-active="item.href === page.url">
                    <Link :href="item.href">
                    <component :is="item.icon" />
                    <span>{{ item.title }} </span>
                    </Link>
                </SidebarMenuButton>

                <Collapsible v-else :default-open="item.isActive" class="group/collapsible">
                    <CollapsibleTrigger as-child>
                        <SidebarMenuButton>
                            <component class="size-4" :is="item.icon" />
                            <span>{{ item.title }}</span>
                            <ChevronRight
                                class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                        </SidebarMenuButton>
                    </CollapsibleTrigger>
                    <CollapsibleContent>
                        <SidebarMenuSub>
                            <SidebarMenuSubItem v-for="subItem in item.subItems" :key="item.title">
                                <SidebarMenuSubButton as-child
                                    :is-active="subItem.href == page.props.ziggy.location ? item.isActive = true : false">
                                    <Link :href="subItem.href">
                                    <component class="size-4" :is="subItem.icon" />
                                    <span>{{ subItem.title }} </span>
                                    </Link>
                                </SidebarMenuSubButton>
                            </SidebarMenuSubItem>
                        </SidebarMenuSub>
                    </CollapsibleContent>
                </Collapsible>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
