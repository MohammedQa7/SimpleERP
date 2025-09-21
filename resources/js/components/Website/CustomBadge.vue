<template>
    <div
        class="px-[14px] py-[6px] bg-white shadow-[0px_0px_0px_4px_rgba(55,50,47,0.05)] overflow-hidden rounded-[90px] flex justify-start items-center gap-[8px] border border-website-primary/10 shadow-xs">
        <div class="w-[14px] h-[14px] relative overflow-hidden flex items-center justify-center">
            <component :is="lucideIcons[icon]"></component>
        </div>
        <div
            class="text-center flex justify-center flex-col text-website-secondary text-xs font-medium leading-3 font-sans">
            {{ text }}
        </div>
    </div>
</template>
<script setup>
import * as lucideIcons from 'lucide-vue-next';

const propsData = defineProps({
    text: String,
    icon: String,
});
</script>