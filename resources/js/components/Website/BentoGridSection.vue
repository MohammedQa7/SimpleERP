<template>
    <div class="w-full border-b border-[rgba(55,50,47,0.12)] flex flex-col justify-center items-center">
        <!-- Header Section -->
        <div
            class="self-stretch px-4 sm:px-6 lg:px-0  py-8 sm:py-12 md:py-16 border-b border-[rgba(55,50,47,0.12)] flex justify-center items-center gap-6">
            <div
                class="w-full max-w-[616px]  px-4 sm:px-6 py-4 sm:py-5 overflow-hidden rounded-lg flex flex-col justify-start items-center gap-3 sm:gap-4 shadow-none">
                <!-- Badge (same border) -->
                <CustomBadge :text="'Bento Grid'" :icon="'LayoutGridIcon'"/>

                <div
                    class="w-full max-w-[598.06px] lg:w-[598.06px] text-center flex justify-center flex-col text-[#49423D] text-xl sm:text-2xl md:text-3xl lg:text-5xl font-semibold leading-tight md:leading-[60px] font-sans tracking-tight">
                    Built for absolute clarity and focused work
                </div>
                <div
                    class="self-stretch text-center text-[#605A57] text-sm sm:text-base font-normal leading-6 sm:leading-7 font-sans">
                    Stay focused with tools that organize, connect
                    <br />
                    and turn information into confident decisions.
                </div>
            </div>
        </div>

        <!-- Bento Grid Content -->
        <div class="self-stretch flex justify-center items-start">
            <!-- Left decorative pattern -->
            <CrossedLinesDecoration />

            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-0 border-l border-r border-[rgba(55,50,47,0.12)]">
                <!-- Top Left - Smart. Simple. Brilliant. -->
                <div
                    class="border-b border-r-0 md:border-r border-[rgba(55,50,47,0.12)] p-4 sm:p-6 md:p-8 lg:p-12 flex flex-col justify-start items-start gap-4 sm:gap-6">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-[#37322F] text-lg sm:text-xl font-semibold leading-tight font-sans">
                            Smart. Simple. Brilliant.
                        </h3>
                        <p class="text-[#605A57] text-sm md:text-base font-normal leading-relaxed font-sans">
                            Your data is beautifully organized so you see everything clearly without the clutter.
                        </p>
                    </div>
                    <div
                        class="w-full h-[200px] sm:h-[250px] md:h-[300px] rounded-lg flex items-center justify-center overflow-hidden">
                        <SmartSimpleBrilliant width="100%" height="100%" theme="light"
                            class="scale-50 sm:scale-65 md:scale-75 lg:scale-90" />
                    </div>
                </div>

                <!-- Top Right - Your work, in sync -->
                <div
                    class="border-b border-[rgba(55,50,47,0.12)] p-4 sm:p-6 md:p-8 lg:p-12 flex flex-col justify-start items-start gap-4 sm:gap-6">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-[#37322F] font-semibold leading-tight font-sans text-lg sm:text-xl">
                            Your work, in sync
                        </h3>
                        <p class="text-[#605A57] text-sm md:text-base font-normal leading-relaxed font-sans">
                            Every update flows instantly across your team and keeps collaboration effortless and fast.
                        </p>
                    </div>
                    <div
                        class="w-full h-[200px] sm:h-[250px] md:h-[300px] rounded-lg flex overflow-hidden text-right items-center justify-center">
                        <YourWorkInSync width="400" height="250" theme="light"
                            class="scale-60 sm:scale-75 md:scale-90" />
                    </div>
                </div>

                <!-- Bottom Left - Effortless integration -->
                <div
                    class="border-r-0 md:border-r border-[rgba(55,50,47,0.12)] p-4 sm:p-6 md:p-8 lg:p-12 flex flex-col justify-start items-start gap-4 sm:gap-6 bg-transparent">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-[#37322F] text-lg sm:text-xl font-semibold leading-tight font-sans">
                            Effortless integration
                        </h3>
                        <p class="text-[#605A57] text-sm md:text-base font-normal leading-relaxed font-sans">
                            All your favorite tools connect in one place and work together seamlessly by design.
                        </p>
                    </div>
                    <div
                        class="w-full h-[200px] sm:h-[250px] md:h-[300px] rounded-lg flex overflow-hidden justify-center items-center relative bg-transparent">
                        <div class="w-full h-full flex items-center justify-center bg-transparent">
                            <EffortlessIntegration width="400" height="250" class="max-w-full max-h-full" />
                        </div>
                        <!-- Gradient mask for soft bottom edge -->
                        <div
                            class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-[#F7F5F3] to-transparent pointer-events-none">
                        </div>
                    </div>
                </div>

                <!-- Bottom Right - Numbers that speak -->
                <div class="p-4 sm:p-6 md:p-8 lg:p-12 flex flex-col justify-start items-start gap-4 sm:gap-6">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-[#37322F] text-lg sm:text-xl font-semibold leading-tight font-sans">
                            Numbers that speak
                        </h3>
                        <p class="text-[#605A57] text-sm md:text-base font-normal leading-relaxed font-sans">
                            Track growth with precision and turn raw data into confident decisions you can trust.
                        </p>
                    </div>
                    <div
                        class="w-full h-[200px] sm:h-[250px] md:h-[300px] rounded-lg flex overflow-hidden items-center justify-center relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <NumbersThatSpeak width="100%" height="100%" theme="light"
                                class="w-full h-full object-contain" />
                        </div>
                        <!-- Gradient mask for soft bottom edge -->
                        <div
                            class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-[#F7F5F3] to-transparent pointer-events-none">
                        </div>

                        <!-- Fallback content if component doesn't render (kept hidden as original) -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-20 ">
                            <div class="flex flex-col items-center gap-2 p-4">
                                <div class="w-3/4 h-full bg-green-500 rounded-full"></div>
                            </div>
                            <div class="text-sm text-green-600">Growth Rate</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right decorative pattern -->
            <CrossedLinesDecoration />
        </div>
    </div>

</template>

<script setup>
import { LayoutGridIcon } from 'lucide-vue-next';
import CrossedLinesDecoration from './CrossedLinesDecoration.vue';
import CustomBadge from './CustomBadge.vue';

</script>