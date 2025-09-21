<template>

    <!-- Heading  -->
    <div class="w-full flex flex-col justify-center items-center gap-3 sm:gap-4 md:gap-5 lg:gap-6">
        <h1
            class="w-full max-w-[748px] lg:w-[748px] text-center flex justify-center flex-col text-website-secondary text-[24px] xs:text-[28px] sm:text-[36px] md:text-[52px] lg:text-[80px] font-normal leading-[1.1] sm:leading-[1.15] md:leading-[1.2] lg:leading-24  px-2 sm:px-4 md:px-0">
            Effortless custom contract
            billing by Lomen
        </h1>
        <h1
            class="w-full max-w-[506px] lg:w-[506px] text-center flex justify-center flex-col text-website-secondary/80 sm:text-lg md:text-xl leading-[1.4] sm:leading-[1.45] md:leading-[1.5] lg:leading-7 font-sans px-2 sm:px-4 md:px-0 lg:text-lg font-medium text-sm ">
            Streamline your billing process with seamless automation
            <br class="hidden sm:block" />
            for every custom contract, tailored by Lomen.
        </h1>
    </div>

    <!-- Site Image Preview Section -->
    <div
        class="w-full max-w-[497px] lg:w-[497px] flex flex-col justify-center items-center gap-6 sm:gap-8 md:gap-10 lg:gap-12 relative z-10 mt-6 sm:mt-8 md:mt-10 lg:mt-12">
        <div class="backdrop-blur-[8.25px] flex justify-start items-center gap-4">
            <CtaButton />
        </div>
    </div>
</template>
<script setup>
import CtaButton from './CtaButton.vue';

</script>
