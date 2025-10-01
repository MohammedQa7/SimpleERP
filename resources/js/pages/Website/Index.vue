<template>

    <!-- All Sections -->
    <div class="self-stretch !pb-0 py-12 md:py-16 overflow-hidden border-b border-[rgba(55,50,47,0.06)] ">
        <div class="w-full flex flex-col justify-start items-center px-2 sm:px-4 lg:px-0 sm:pl-0 sm:pr-0 ">


            <!-- Heading Section -->
            <HeadingSection />

            <!-- Dashborad Content & Features -->
            <DashboardAndFeatureSection />

            <!-- Social Proof Section -->
            <SocialProofSection />

            <!-- Bento Grid Section -->
            <BentoGridSection />

            <!-- Documentation Section -->

            <!-- Testimonials Section -->

            <!-- Pricing Section -->
            <PricingSection />

            <!-- FAQ Section -->

            <!-- CTA Section -->

            <!-- Business Hero Section -->
            <BusinessHero />

        </div>
    </div>
</template>

<script setup lang="ts">
import BentoGridSection from '@/components/Website/BentoGridSection.vue'
import BusinessHero from '@/components/Website/BusinessHero.vue'
import DashboardAndFeatureSection from '@/components/Website/DashboardAndFeatureSection.vue'
import FooterSection from '@/components/Website/FooterSection.vue'
import HeadingSection from '@/components/Website/HeadingSection.vue'
import PricingSection from '@/components/Website/PricingSection.vue'
import SocialProofSection from '@/components/Website/SocialProofSection.vue'
import WebsiteLayout from './WebsiteLayout.vue'
import SlideUpAnimation from '@/components/Website/SlideUpAnimation.vue'

defineOptions({
    layout: WebsiteLayout
});
</script>
