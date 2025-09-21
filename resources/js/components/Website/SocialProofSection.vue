<template>
    <div class="w-full border-b border-[rgba(55,50,47,0.12)] flex flex-col justify-center items-center">
        <div
            class="self-stretch px-4 sm:px-6 md:px-24 py-8 sm:py-12 md:py-16 border-b border-[rgba(55,50,47,0.12)] flex justify-center items-center gap-6">
            <div
                class="w-full max-w-[586px] px-4 sm:px-6 py-4 sm:py-5  overflow-hidden rounded-lg flex flex-col justify-start items-center gap-3 sm:gap-4 shadow-none">
                <!-- Badge (kept border identical to React) -->
                <CustomBadge :text="'Social Proof'" :icon="'Building2'"/>

                <div
                    class="w-full max-w-[472.55px] text-center flex justify-center flex-col text-[#49423D] text-xl sm:text-2xl md:text-3xl lg:text-5xl font-semibold leading-tight md:leading-[60px] font-sans tracking-tight">
                    Confidence backed by results
                </div>
                <div
                    class="self-stretch text-center text-[#605A57] text-sm sm:text-base font-normal leading-6 sm:leading-7 font-sans">
                    Our customers achieve more each day
                    <br class="hidden sm:block" />
                    because their tools are simple, powerful, and clear.
                </div>
            </div>
        </div>

        <!-- Logo Grid -->
        <div class="self-stretch border-[rgba(55,50,47,0.12)] flex justify-center items-start border-t border-b-0">
            <!-- Left decorative pattern -->
            <CrossedLinesDecoration />

            <div
                class="flex-1 grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 gap-0 border-l border-r border-[rgba(55,50,47,0.12)]">
                <!-- Logo Grid - Responsive grid -->
                <div v-for="(n, index) in 8" :key="'logo-' + index"
                    class="h-24 xs:h-28 sm:h-32 md:h-36 lg:h-40 flex justify-center items-center gap-1 xs:gap-2 sm:gap-3 border-b border-[rgba(227,226,225,0.5)] md:border-l border-[#E3E2E1]">
                    <div
                        class="w-6 h-6 xs:w-7 xs:h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 relative shadow-[0px_-4px_8px_rgba(255,255,255,0.64)_inset] overflow-hidden rounded-full">
                        <img src="/horizon-icon.svg" alt="Horizon" class="w-full h-full object-contain" />
                    </div>
                    <div
                        class="text-center flex justify-center flex-col text-[#37322F] text-sm xs:text-base sm:text-lg md:text-xl lg:text-2xl font-medium leading-tight md:leading-9 font-sans">
                        Acute
                    </div>
                </div>
            </div>

            <CrossedLinesDecoration />
        </div>
    </div>
</template>

<script setup>
import { Building2 } from 'lucide-vue-next';
import CrossedLinesDecoration from './CrossedLinesDecoration.vue';
import CustomBadge from './CustomBadge.vue';

</script>