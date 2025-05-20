<template>
    <EmojiPicker v-if="isOpen" :native="true" theme="dark" @select="onSelectEmoji" />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import EmojiPicker from 'vue3-emoji-picker'
import { toast } from './ui/toast';
const propsData = defineProps({
    isOpen: Boolean,
})
function onSelectEmoji(emoji: any) {
    navigator.clipboard.writeText(emoji.i)
        .then(() => {
            toast({
                title: 'Copied'
            })
        })
        .catch(err => {
            console.error("Failed to copy");
        });
}

</script>