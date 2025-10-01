<script setup lang="ts">
import AnnouncementsDialog from '@/components/AnnouncementsDialog.vue';
import Toaster from '@/components/ui/toast/Toaster.vue';
import WorkSessionV2 from '@/components/WorkSessionV2.vue';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { nextTick, onMounted, ref } from 'vue';
const isAnnouncementDialogOpened = ref(false);
const page = usePage();

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}
withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});


onMounted(() => {
    if (localStorage.getItem('lastAnnouncementViewed') != page.props?.lastAnnouncement) {
        localStorage.setItem('lastAnnouncementViewed', String(page.props.lastAnnouncement));
        isAnnouncementDialogOpened.value = true;
    }
})
</script>

<template>
    <Toaster />
    <!-- Announcments Section -->
    <AnnouncementsDialog v-if="page.props.lastAnnouncement" :is-open="isAnnouncementDialogOpened"
        @update:open="isAnnouncementDialogOpened = $event" />

    <WorkSessionV2 />

    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>
</template>
