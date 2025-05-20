<template>
    <div
        class="mt-8 flex flex-col items-center justify-center rounded-lg border-2 border-dashed  border-muted-foreground bg-muted p-12 text-center">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50">
            <component :is="LucideIcons[icon]" class="h-7 w-7 text-primary-foreground" />
        </div>
        <h3 class="mt-4 text-lg font-medium text-primary">{{ title }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ subTitle }}</p>
    </div>
</template>

<script setup>
import * as LucideIcons from 'lucide-vue-next';
const propsData = defineProps({
    title: Text,
    subTitle: Text,
    icon: Text,
});
</script>