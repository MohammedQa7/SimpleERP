<template>

    <!-- Dashboard Content -->
    <div
        class="w-full max-w-[960px] lg:w-[960px] pt-2 sm:pt-4 pb-6 sm:pb-8 md:pb-10 px-2 sm:px-4  lg:px-11 flex flex-col justify-center items-center gap-2 relative z-5 my-8 sm:my-12 md:my-16 lg:my-16 mb-0 lg:pb-0">
        <div
            class="w-full max-w-[960px] lg:w-[960px] h-[200px] sm:h-[280px] md:h-[450px] lg:h-[695.55px] bg-white shadow-[0px_0px_0px_0.9056603908538818px_rgba(0,0,0,0.08)] overflow-hidden rounded-[6px] sm:rounded-[8px] lg:rounded-[9.06px] flex flex-col justify-start items-start">

            <div class="self-stretch flex-1 flex justify-start items-start">
                <!-- Main Content -->
                <div class="w-full h-full flex items-center justify-center">
                    <div class="relative w-full h-full overflow-hidden">
                        <!-- Product Image 1 - Plan your schedules -->
                        <Transition enterActiveClass="transition-all duration-500 ease-in-out"
                            enterFromClass="opacity-0 scale-95 blur-sm" enterToClass="opacity-100 scale-100 blur-0"
                            leaveActiveClass="transition-all duration-500 ease-in-out"
                            leaveFromClass="opacity-100 scale-100 blur-0" leaveToClass="opacity-0 scale-95 blur-sm">
                            <div v-if="activeCard == 0">
                                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/dsadsadsa.jpg-xTHS4hGwCWp2H5bTj8np6DXZUyrxX7.jpeg"
                                    alt="Schedules Dashboard - Customer Subscription Management"
                                    class="w-full h-full object-cover" />
                            </div>

                        </Transition>

                        <!-- Product Image 2 - Data to insights -->
                        <Transition enterActiveClass="transition-all duration-500 ease-in-out"
                            enterFromClass="opacity-0 scale-95 blur-sm" enterToClass="opacity-100 scale-100 blur-0"
                            leaveActiveClass="transition-all duration-500 ease-in-out"
                            leaveFromClass="opacity-100 scale-100 blur-0" leaveToClass="opacity-0 scale-95 blur-sm">
                            <div v-if="activeCard == 2">
                                <img src="/analytics-dashboard-with-charts-graphs-and-data-vi.jpg"
                                    alt="Analytics Dashboard" class="w-full h-full object-cover" />
                            </div>
                        </Transition>

                        <!-- Product Image 3 - Data visualization -->
                        <Transition enterActiveClass="transition-all duration-500 ease-in-out"
                            enterFromClass="opacity-0 scale-95 blur-sm" enterToClass="opacity-100 scale-100 blur-0"
                            leaveActiveClass="transition-all duration-500 ease-in-out"
                            leaveFromClass="opacity-100 scale-100 blur-0" leaveToClass="opacity-0 scale-95 blur-sm">
                            <div v-if="activeCard == 3">
                                <img src="/data-visualization-dashboard-with-interactive-char.jpg"
                                    alt="Data Visualization Dashboard" class="w-full h-full object-contain" />
                            </div>
                        </Transition>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="self-stretch border-t border-[#E0DEDB] border-b  flex justify-center items-start">
        <!-- Left decorative pattern -->
        <CrossedLinesDecoration />

        <div class="flex-1 px-0 sm:px-2 md:px-0 flex flex-col md:flex-row justify-center items-stretch gap-0">

            <div :class="[
                'w-full md:flex-1 self-stretch px-6 py-5 overflow-hidden flex flex-col justify-start items-start gap-2 cursor-pointer relative border-b md:border-b-0 last:border-b-0',
                activeCard === 0 ? 'bg-white shadow-[0px_0px_0px_0.75px_border-red-300_inset]' : 'border-l-0 border-r-0 md:border border-[#E0DEDB]/80'
            ]" @click="handleCardClick(0)">
                <div v-if="activeCard === 0" class="absolute top-0 left-0 w-full h-0.5 bg-[rgba(50,45,43,0.08)]">
                    <div class="h-full bg-[#322D2B] transition-all duration-100 ease-linear"
                        :style="{ width: progress + '%' }"></div>
                </div>

                <div
                    class="self-stretch flex justify-center flex-col text-[#49423D] text-sm md:text-sm font-semibold leading-6 md:leading-6 font-sans">
                    Plan your schedules
                </div>
                <div
                    class="self-stretch text-[#605A57] text-[13px] md:text-[13px] font-normal leading-[22px] md:leading-[22px] font-sans">
                    Streamline customer subscriptions and billing with automated scheduling tools.
                </div>
            </div>

            <div :class="[
                'w-full md:flex-1 self-stretch px-6 py-5 overflow-hidden flex flex-col justify-start items-start gap-2 cursor-pointer relative border-b md:border-b-0 last:border-b-0',
                activeCard === 1 ? 'bg-white shadow-[0px_0px_0px_0.75px_#E0DEDB_inset]' : 'border-l-0 border-r-0 md:border border-[#E0DEDB]/80'
            ]" @click="handleCardClick(1)">
                <div v-if="activeCard === 1" class="absolute top-0 left-0 w-full h-0.5 bg-[rgba(50,45,43,0.08)]">
                    <div class="h-full bg-[#322D2B] transition-all duration-100 ease-linear"
                        :style="{ width: progress + '%' }"></div>
                </div>

                <div
                    class="self-stretch flex justify-center flex-col text-[#49423D] text-sm md:text-sm font-semibold leading-6 md:leading-6 font-sans">
                    Analytics & insights
                </div>
                <div
                    class="self-stretch text-[#605A57] text-[13px] md:text-[13px] font-normal leading-[22px] md:leading-[22px] font-sans">
                    Transform your business data into actionable insights with real-time analytics.
                </div>
            </div>

            <div :class="[
                'w-full md:flex-1 self-stretch px-6 py-5 overflow-hidden flex flex-col justify-start items-start gap-2 cursor-pointer relative border-b md:border-b-0 last:border-b-0',
                activeCard === 2 ? 'bg-white shadow-[0px_0px_0px_0.75px_#E0DEDB_inset]' : 'border-l-0 border-r-0 md:border border-[#E0DEDB]/80'
            ]" @click="handleCardClick(2)">
                <div v-if="activeCard === 2" class="absolute top-0 left-0 w-full h-0.5 bg-[rgba(50,45,43,0.08)]">
                    <div class="h-full bg-[#322D2B] transition-all duration-100 ease-linear"
                        :style="{ width: progress + '%' }"></div>
                </div>

                <div
                    class="self-stretch flex justify-center flex-col text-[#49423D] text-sm md:text-sm font-semibold leading-6 md:leading-6 font-sans">
                    Collaborate seamlessly
                </div>
                <div
                    class="self-stretch text-[#605A57] text-[13px] md:text-[13px] font-normal leading-[22px] md:leading-[22px] font-sans">
                    Keep your team aligned with shared dashboards and collaborative workflows.
                </div>
            </div>
        </div>

        <!-- Right decorative pattern -->
        <CrossedLinesDecoration />
    </div>
</template>
<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue'
import CrossedLinesDecoration from './CrossedLinesDecoration.vue'


const activeCard = ref(0)
const progress = ref(0)
let intervalId: number | undefined
let isMounted = true

function handleCardClick(index: number) {
    if (!isMounted) return
    activeCard.value = index
    progress.value = 0
}

onMounted(() => {
    isMounted = true
    intervalId = window.setInterval(() => {
        if (!isMounted) return
        if (progress.value >= 100) {
            activeCard.value = (activeCard.value + 1) % 3
            progress.value = 0
        } else {
            progress.value += 2 // 2% every 100ms = 5 seconds total
        }
    }, 100)
})

onUnmounted(() => {
    isMounted = false
    if (intervalId) clearInterval(intervalId)
})
</script>