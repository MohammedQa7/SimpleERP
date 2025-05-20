<template>
    <div>
        <div class="folder-heading flex justify-between items-center">
            <h2 class="text-lg font-medium mb-4">Folder access</h2>
            <!-- Storage usage indicator (Google Drive-style) -->
            <div class="ml-auto flex items-center gap-2 bg-card rounded-full border px-4 py-1.5 shadow-sm">
                <HardDrive class="h-4 w-4 text-primary" />
                <span class="text-sm font-medium">2.4 GB used</span>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <Card v-for="(folder, index) in folders.data" :key="index"
                class="overflow-hidden border hover:shadow-md transition-shadow">
                <Link :href="route('folders.show', { folder: folder.id })">
                <CardContent class="p-0">
                    <div class="aspect-video bg-muted flex items-center justify-center">
                        <Folder class="h-10 w-10 text-muted-foreground/60" />
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-medium truncate">{{ folder.name }}</h3>
                        <p class="text-xs text-muted-foreground">Created {{ folder.createdAt }}</p>
                    </div>
                </CardContent>
                </Link>
            </Card>
        </div>
    </div>

</template>
<script setup>
import { ref } from 'vue'
import {
    Folder,
    HardDrive,
} from 'lucide-vue-next'

import {
    Card,
    CardContent,

} from '@/components/ui/card'

const propsData = defineProps({
    folders: Array,
});


</script>