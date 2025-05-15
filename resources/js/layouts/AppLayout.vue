<script setup lang="ts">
import AnnouncementsDialog from '@/components/AnnouncementsDialog.vue';
import { Toaster } from '@/components/ui/sonner/';
// import Toaster from '@/components/ui/toast/Toaster.vue';
import WorkSessionV2 from '@/components/WorkSessionV2.vue';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { nextTick, onMounted, ref, watch } from 'vue';
import { toast } from 'vue-sonner';
import 'vue-sonner/style.css'
import isNull from 'lodash';
const isAnnouncementDialogOpened = ref(false);
const page = usePage();

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}
withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

watch(() => page.flash?.message, () => {
    if (page.flash.type) {
        page.flash.type == 'success'
            ? toast.success(page?.flash?.message, { position: 'top-center', duration: 6500 })

            : toast.error(page?.flash?.message, { position: 'top-center', duration: 6500 });

        page.flash.message = null
        page.flash.type = null
    }

})

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
