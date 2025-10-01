<template>
    
    <!-- Heading  -->
    <div class="w-full flex flex-col justify-center items-center gap-3 sm:gap-4 md:gap-5 lg:gap-6">

        <div
            class="w-full max-w-[748px] lg:w-[748px] text-center flex justify-center flex-col text-website-secondary text-[24px] xs:text-[28px] sm:text-[36px] md:text-[52px] lg:text-[80px] font-normal leading-[1.1] sm:leading-[1.15] md:leading-[1.2] lg:leading-24  px-2 sm:px-4 md:px-0 ">
            <SlideUpAnimation :delay="150">
                <span>Effortless custom contract
                    billing </span>
            </SlideUpAnimation>

            <SlideUpAnimation :delay="250">
                <span>by Lomen</span>
            </SlideUpAnimation>
        </div>
    </div>

    <!-- Site Image Preview Section -->
    <div
        class="w-full max-w-[497px] lg:w-[497px] flex flex-col justify-center items-center gap-6 sm:gap-8 md:gap-10 lg:gap-12 relative z-10 mt-6 sm:mt-8 md:mt-10 lg:mt-12">
        <SlideUpAnimation :delay="300">
            <div class="backdrop-blur-[8.25px] flex justify-start items-center gap-4">
                <CtaButton />
            </div>
        </SlideUpAnimation>
    </div>
</template>
<script setup>
import { Transition } from 'vue';
import CtaButton from './CtaButton.vue';
import SlideUpAnimation from './SlideUpAnimation.vue';

</script>
