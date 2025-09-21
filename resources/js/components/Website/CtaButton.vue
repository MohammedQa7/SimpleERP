<template>
    <Button class="bg-website-primary  text-white rounded-full py-6 px-12 hover:bg-website-primary/90">
        {{ text ?? 'Start for free' }}
    </Button>
</template>
<script setup>
import Button from '../ui/button/Button.vue';
const propsData = defineProps({
    text: String,
});
</script>