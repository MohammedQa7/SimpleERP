<template>
    <div class="w-full min-h-screen relative bg-website-background  flex flex-col justify-start items-center">
        <div class="relative flex flex-col justify-start items-center w-full font-sans">
            <!-- Main container with proper margins -->
            <div
                class="w-full sm:pt-20 md:pt-24 pt-16 max-w-none px-4 sm:px-6  lg:px-0 lg:max-w-[1200px] lg:w-[1200px] relative flex flex-col justify-start items-start min-h-screen">
                <!-- Left vertical line -->
                <div
                    class="w-[1px] h-full absolute left-4 sm:left-6 md:left-8 lg:left-0 top-0 bg-website-secondary/10 shadow-[1px_0px_0px_white] z-0">
                </div>

                <!-- Right vertical line -->
                <div
                    class="w-[1px] h-full absolute right-4 sm:right-6 md:right-8 lg:right-0 top-0  bg-website-secondary/10 shadow-[1px_0px_0px_white] z-0">
                </div>

                <!-- Navigation Bar -->
                <Navbar />

                <!-- All Sections -->
                <slot />
                <FooterSection />
            </div>
        </div>

    </div>


</template>

<script setup lang="ts">

import FooterSection from '@/components/Website/FooterSection.vue';
import Navbar from '@/components/Website/Navbar.vue'
import { useAppearance } from '@/composables/useAppearance';
import { useForm } from '@inertiajs/vue3';
import { ImageDownIcon } from 'lucide-vue-next';
import { computed, onMounted, ref, toRef, watch } from 'vue';
const appearance = useAppearance();


onMounted(() => {
    appearance.updateAppearance('light')
})
</script>
