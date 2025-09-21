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

            <!-- Footer Section -->
            <FooterSection />




            <div class="col-span-12 text-sand-light-1 z-0">
                <svg class="w-full h-full" width="1280" height="308" viewBox="0 0 1072 219" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path transform="translate(0, 25)"
                        d="M25.8 218C9.3 218.3 7.15256e-07 209.3 7.15256e-07 192.8V3.49999H48V176L150.9 173V215L25.8 218ZM147.879 109.1C147.879 47.6 188.679 0.49999 255.879 0.49999C322.779 0.49999 363.579 47.6 363.579 109.1C363.579 170.9 322.779 218 255.879 218C188.679 218 147.879 170.9 147.879 109.1ZM195.879 109.1C195.879 149.9 215.979 176 255.879 176C295.779 176 315.579 149.9 315.579 109.1C315.579 68.6 295.779 42.5 255.879 42.5C215.979 42.5 195.879 68.6 195.879 109.1ZM390.82 215V3.49999H485.32L516.22 203H528.22L559.12 3.49999H653.62V215H605.62V45.5L614.62 15.5H602.62L568.72 215H475.72L441.82 15.5H429.82L438.82 45.5V215H390.82ZM683.789 215V3.49999H834.689V45.5H731.789V88.1H819.689V130.1H731.789V173H834.689V215H683.789ZM861.621 215V3.49999H956.121L1020.02 203H1032.02L1023.02 173V3.49999H1071.02V215H976.521L912.621 15.5H900.621L909.621 45.5V215H861.621Z"
                        fill="#37322F" />
                </svg>
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
import WebsiteLayout from './WebsiteLayout.vue'



defineOptions({
    layout: WebsiteLayout
});
</script>
