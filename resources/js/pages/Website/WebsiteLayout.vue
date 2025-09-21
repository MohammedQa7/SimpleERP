<template>
    <div
        class="w-full min-h-screen relative bg-website-background overflow-x-hidden flex flex-col justify-start items-center">
        <div class="relative flex flex-col justify-start items-center w-full">
            <!-- Main container with proper margins -->
            <div
                class="w-full sm:pt-20 md:pt-24 pt-16 max-w-none px-4 sm:px-6  lg:px-0 lg:max-w-[1060px] lg:w-[1060px] relative flex flex-col justify-start items-start min-h-screen">
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
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import BentoGridSection from '@/components/Website/BentoGridSection.vue'
import BusinessHero from '@/components/Website/BusinessHero.vue'
import DashboardAndFeatureSection from '@/components/Website/DashboardAndFeatureSection.vue'
import FooterSection from '@/components/Website/FooterSection.vue'
import HeadingSection from '@/components/Website/HeadingSection.vue'
import Navbar from '@/components/Website/Navbar.vue'
import PricingSection from '@/components/Website/PricingSection.vue'
import SocialProofSection from '@/components/Website/SocialProofSection.vue'
import Pricing from './Pricing.vue'

</script>
