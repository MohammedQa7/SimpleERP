<template>
    <!-- Hero Section -->

    <div
        class=" pt-12 pb-8 sm:pb-12 md:pb-16 flex flex-col justify-start items-center px-2 sm:px-4 md:px-8 lg:px-0 w-full">
        <div
            class="w-full max-w-[937px] lg:w-[937px] flex flex-col justify-center items-center gap-3 sm:gap-4 md:gap-5 lg:gap-6">
            <div
                class="self-stretch rounded-[3px] flex flex-col justify-center items-center gap-4 sm:gap-5 md:gap-6 lg:gap-8">
                <Badge text="Plans & Pricing">
                    <template #icon>
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6 1V11M8.5 3H4.75C4.28587 3 3.84075 3.18437 3.51256 3.51256C3.18437 3.84075 3 4.28587 3 4.75C3 5.21413 3.18437 5.65925 3.51256 5.98744C3.84075 6.31563 4.28587 6.5 4.75 6.5H7.25C7.71413 6.5 8.15925 6.68437 8.48744 7.01256C8.81563 7.34075 9 7.78587 9 8.25C9 8.71413 8.81563 9.15925 8.48744 9.48744C8.15925 9.81563 7.71413 10 7.25 10H3.5"
                                stroke="#37322F" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </template>
                </Badge>

                <SlideUpAnimation :delay="150">
                    <div
                        class="w-full max-w-[748.71px] lg:w-[748.71px] text-center flex justify-center flex-col text-website-secondary text-[24px] xs:text-[28px] sm:text-[36px] md:text-[52px] lg:text-[80px] font-normal leading-[1.1] sm:leading-[1.15] md:leading-[1.2] lg:leading-24 font-sans px-2 sm:px-4 md:px-0">
                        Choose the perfect plan
                        for your business
                    </div>
                </SlideUpAnimation>

                <SlideUpAnimation :delay="250">
                    <div
                        class="w-full max-w-[506.08px] lg:w-[506.08px] text-center flex justify-center flex-col text-website-secondary/75 sm:text-lg md:text-xl leading-[1.4] sm:leading-[1.45] md:leading-[1.5] lg:leading-7 font-sans px-2 sm:px-4 md:px-0 lg:text-lg font-medium text-sm">
                        Scale your operations with flexible pricing that grows with your team.
                        Start free, upgrade when you're ready.
                    </div>
                </SlideUpAnimation>
            </div>
        </div>

        <!-- Billing Toggle Section -->
        <SlideUpAnimation :delay="400">
            <div
                class="w-full max-w-[960px] lg:w-[960px] px-6 md:px-16 py-9 relative flex justify-center items-center gap-4 mt-8">
                <!-- Horizontal line -->
                <div
                    class="w-full max-w-[1060px] h-0 absolute left-1/2 transform -translate-x-1/2 top-[63px] border-t border-website-secondary/12 z-0">
                </div>

                <!-- Toggle Container -->
                <div
                    class="p-3 relative bg-website-primary/5 border border-website-primary/5 backdrop-blur-[44px] backdrop-saturate-150 backdrop-brightness-110 flex justify-center items-center rounded-lg z-20 before:absolute before:inset-0 before:bg-white before:opacity-60 before:rounded-lg before:-z-10">
                    <div
                        class="p-[2px] bg-website-primary/10 shadow-[0px_1px_0px_white] rounded-[99px] border-[0.5px] border-website-primary/10 flex justify-center items-center gap-[2px] relative">
                        <div
                            :class="['absolute top-[2px] w-[calc(50%-1px)] h-[calc(100%-4px)] bg-white shadow-[0px_2px_4px_rgba(0,0,0,0.08)] rounded-[99px] transition-all duration-300 ease-in-out', billingPeriod === 'annually' ? 'left-[2px]' : 'right-[2px]']" />

                        <button @click="setBillingPeriod('annually')"
                            class="px-4 py-1 rounded-[99px] flex justify-center items-center gap-2 transition-colors duration-300 relative z-10 flex-1">
                            <div
                                :class="['text-[13px] font-medium leading-5 font-sans transition-colors duration-300', billingPeriod === 'annually' ? ' text-website-primary' : 'text-website-secondary/30']">
                                Annually
                            </div>
                        </button>

                        <button @click="setBillingPeriod('monthly')"
                            class="px-4 py-1 rounded-[99px] flex justify-center items-center gap-2 transition-colors duration-300 relative z-10 flex-1">
                            <div
                                :class="['text-[13px] font-medium leading-5 font-sans transition-colors duration-300', billingPeriod === 'monthly' ? ' text-website-primary' : 'text-website-secondary/30']">
                                Monthly
                            </div>
                        </button>
                    </div>

                    <!-- Decorative dots -->
                    <div
                        class="w-[3px] h-[3px] absolute left-[5px] top-[5.25px] bg-website-primary/10 shadow-[0px_0px_0.5px_rgba(0,0,0,0.12)] rounded-ful">
                    </div>
                    <div
                        class="w-[3px] h-[3px] absolute right-[5px] top-[5.25px] bg-website-primary/10 shadow-[0px_0px_0.5px_rgba(0,0,0,0.12)] rounded-full">
                    </div>
                    <div
                        class="w-[3px] h-[3px] absolute left-[5px] bottom-[5.25px] bg-website-primary/10 shadow-[0px_0px_0.5px_rgba(0,0,0,0.12)] rounded-full">
                    </div>
                    <div
                        class="w-[3px] h-[3px] absolute right-[5px] bottom-[5.25px] bg-website-primary/10 shadow-[0px_0px_0.5px_rgba(0,0,0,0.12)] rounded-full">
                    </div>
                </div>
            </div>
        </SlideUpAnimation>

        <!-- Table -->
        <ComparisonTable :plans="filteredPlans" :period="billingPeriod"
            :features-and-categories="featuresAndCategories" />
    </div>


</template>

<script setup lang="ts">
import CrossedLinesDecoration from '@/components/Website/CrossedLinesDecoration.vue'
import { ref, defineComponent, h, watch, computed } from 'vue'
import WebsiteLayout from './WebsiteLayout.vue'
import ComparisonTable from '@/components/Website/Pricing/ComparisonTable.vue'
import Badge from '@/components/ui/badge/Badge.vue'
import SlideUpAnimation from '@/components/Website/SlideUpAnimation.vue'
import { router } from '@inertiajs/vue3'
import { useEcho, useEchoPublic } from '@laravel/echo-vue'

const propsData = defineProps({
    plans: Array,
    featuresAndCategories: Array,
});

type BillingPeriod = 'monthly' | 'annually'
const billingPeriod = ref<BillingPeriod>('monthly')

function setBillingPeriod(period: BillingPeriod) {
    billingPeriod.value = period
}

// Computed property to filter plans
const filteredPlans = computed(() => {
    return propsData.plans?.data?.filter(plan => plan.prices[billingPeriod.value])
})



defineOptions({
    layout: WebsiteLayout,
})
</script>
