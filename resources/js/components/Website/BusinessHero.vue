<template>
    <div
        class="self-stretch px-4 sm:px-6 py-8 sm:py-12 md:py-16 border-b border-[rgba(55,50,47,0.12)] flex justify-center items-center gap-6">
        <div class="w-full max-h-[750px] h-[550px] flex justify-center items-center rounded-[60px]"
            style="background-image: url('/Assets/Images/landscape-business.png'); background-repeat: no-repeat; background-size:cover;">
            <div
                class="w-full max-w-[586px] px-6 py-5 md:py-8 overflow-hidden rounded-lg flex flex-col justify-start items-center gap-6 relative z-20">
                <div class="self-stretch flex flex-col justify-start items-start gap-3">
                    <div
                        class="self-stretch text-center flex justify-center flex-col text-white text-3xl md:text-5xl font-semibold leading-tight md:leading-[56px] font-sans tracking-tight">
                        Ready to transform your business?
                    </div>
                    <div class="self-stretch text-center text-white  text-base leading-7 font-sans font-medium">
                        Join thousands of businesses streamlining their operations,
                        <br />
                        managing schedules, and growing with data-driven insights.
                    </div>
                </div>
                <div class="w-full flex justify-center items-center gap-12">
                    <div class="flex justify-start items-center gap-4">
                        <CtaButton />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import Button from '../ui/button/Button.vue';
import CtaButton from './CtaButton.vue';

</script>