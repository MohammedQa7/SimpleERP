<template>
    <transition appear enter-active-class="transition-all duration-700 ease-[cubic-bezier(0.22,0.61,0.36,1)]"
        enter-from-class="translate-y-8 opacity-0 blur-sm" enter-to-class="translate-y-0 opacity-100 blur-0"
        :style="{ transitionDelay: delay + 'ms' }">
        <slot />

    </transition>
</template>

<script setup>
const propsData = defineProps({
    delay: Number,
});
</script>