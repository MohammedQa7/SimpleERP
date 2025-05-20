<template>
    <div class="min-h-screen bg-background text-foreground">
        <!-- Main Content -->
        <main class="container py-6 px-4 sm:px-6">
            <div class="flex flex-col gap-6">
                <!-- Folder  Section (Google Drive-style) -->
                <FolderSection :folders="folders" />
                <!-- Folder Navigation (Google Drive-style collapsible) -->
                <div>
                    <FileAndFolders />
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import FileAndFolders from '@/components/FileManager/FileAndFolders.vue'
import FolderSection from '@/components/FileManager/FolderSection.vue'
const propsData = defineProps({
    folders: Array,
});



defineOptions({
    layout: AppLayout,
});
</script>
