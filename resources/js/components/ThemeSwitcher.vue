<template>
    <HeadingSmall title="Themes" description="Select a theme that matches your workflow and aesthetic" />
    <!-- Theme Grid -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
        <button v-for="theme in themes.data" :key="theme.name" @click.prevent="useTheme(theme.fileName)"
            class="group relative overflow-hidden rounded-2xl border p-5 ">

            <!-- Color Palette Display -->
            <div class="relative mb-6 flex gap-1.5">
                <div v-for="(color, index) in theme.colorPalette" :key="index"
                    class="h-16 flex-1 rounded-lg shadow-lg transition-transform group-hover:scale-105 " :style="{
                        backgroundColor: color,
                        transitionDelay: `${index * 30}ms`,
                    }" />
            </div>

            <!-- Theme Name & Selection -->
            <div class=" flex items-center justify-between">
                <div class="text-left">
                    <h3 class="font-semibold ">{{ theme.name }}</h3>
                    <p class="text-xs ">{{ theme.colorPalette.length }} colors</p>
                </div>
                <Badge v-if="selectedTheme == theme.fileName"
                    class=" bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400 border border-green-200 dark:border-green-800  pointer-events-none">
                    Selected
                </Badge>
            </div>

            <!-- Hover Shine Effect -->
            <div class="pointer-events-none absolute inset-0 opacity-0 transition-opacity group-hover:opacity-100">
                <div class="absolute inset-0 translate-x-[-100%] bg-gradient-to-r from-transparent via-white/5 to-transparent group-hover:translate-x-[100%] group-hover:duration-1000"
                    style="transition: transform 0.6s ease" />
            </div>
        </button>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import HeadingSmall from './HeadingSmall.vue'
import { getStoredTheme, useCustomTheme } from '@/composables/useCustomTheme'
import Badge from './ui/badge/Badge.vue'
const selectedTheme = ref(null);
const propsData = defineProps({
    themes: Array,
})

const useTheme = (themeFileName) => {
    useCustomTheme(themeFileName)
    selectedTheme.value = themeFileName
}

onMounted(() => {
    selectedTheme.value = getStoredTheme();
})

</script>
