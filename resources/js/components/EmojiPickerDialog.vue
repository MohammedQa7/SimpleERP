<template>
    <EmojiPicker v-if="isOpen" :native="true" theme="dark" @select="onSelectEmoji" />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { toast } from 'vue-sonner';
import EmojiPicker from 'vue3-emoji-picker'
const propsData = defineProps({
    isOpen: Boolean,
})
function onSelectEmoji(emoji: any) {

    // navigator.clipboard.writeText('test')
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(emoji.i)
            .then(() => {
                toast.success('Copied to clipboard!');
            })
            .catch((err) => {
                toast.warning('Failed to copy: ' + err);
            });
    } else {
        toast.warning('Clipboard Api is not available');
        console.error('Clipboard Api is not available');
    }
}

</script>