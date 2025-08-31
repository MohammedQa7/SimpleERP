<template>
    <div class="min-h-screen bg-background text-foreground">
        <!-- Main Content -->
        <CustomBreadcrumb :breadcrumbs="breadcrumbArray" />
        <main class="container py-6 px-4 sm:px-6">
            <div class="flex flex-col gap-6">
                <!-- Folder  Section (Google Drive-style) -->
                <div class="space-y-3">
                    <h1 class="text-xl font-bold tracking-tight">Folders</h1>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        <Card v-for="(folder, index) in folder.data.subFolders" :key="index"
                            class="overflow-hidden border hover:shadow-md transition-shadow">
                            <Link :href="route('folders.show', { folder: folder.id })" preserve-state preserve-scroll
                                @click.prevent="buildBreadcrumb(folder)">
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

                <!-- FILES Section -->
                <div class="space-y-3">
                    <h1 class="text-xl font-bold tracking-tight">Files</h1>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        <Card v-for="(attachment, index) in folder.data.attachments" :key="index"
                            class="overflow-hidden border hover:shadow-md transition-shadow">
                            <Link preserve-state preserve-scroll>
                            <CardContent class="p-0">
                                <div class="p-4">
                                    <div class="flex items-center gap-3 mb-2">
                                        <FileImage class="h-10 w-10 text-muted-foreground" />
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-medium text-sm truncate">{{ attachment.name }}</h3>
                                            <p class="text-xs text-muted-foreground">{{ attachment.size }}</p>
                                        </div>
                                    </div>
                                    <div class="text-xs text-muted-foreground">
                                        Created {{ attachment.createdAt }}
                                    </div>
                                </div>
                            </CardContent>
                            </Link>
                        </Card>
                    </div>
                </div>

            </div>
        </main>
    </div>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import { FileImage, Folder } from 'lucide-vue-next';
import { computed, onMounted, ref } from 'vue';
import CustomBreadcrumb from '@/components/CustomBreadcrumb.vue';
const breadcrumbArray = ref([]);
const breadcrumbSet = new Set()
const propsData = defineProps({
    folder: Array,
});


function buildBreadcrumb(folder) {

    // Start the recursive chain
    addParents(folder)

    return breadcrumbArray.value
}
function addParents(folder) {
    if (folder.parentFolder) {
        addParents(folder.parentFolder)
    }
    // Add the current folder
    if (!breadcrumbSet.has(folder.id)) {
        breadcrumbArray.value.push({
            id: folder.id,
            name: folder.name,
            route: route('folders.show', { folder: folder.id })
        })
        breadcrumbSet.add(folder.id)
    }
}


onMounted(() => {
    buildBreadcrumb(propsData.folder.data)
})


defineOptions({
    layout: AppLayout,
});
</script>
