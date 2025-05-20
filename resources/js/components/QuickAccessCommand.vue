<template>
    <div>
        <p class="text-sm text-muted-foreground">
            Press
            <kbd
                class="pointer-events-none inline-flex h-5 select-none items-center gap-1 rounded border bg-muted px-1.5 font-mono text-[10px] font-medium text-muted-foreground opacity-100">
                <span class="text-xs">⌘</span>K For Quick Search
            </kbd>
        </p>
        <CommandDialog v-model:open="open">
            <Button v-if="openEmojiPicker" @click.prevent="openEmojiPicker = false" variant="outline">
                <ArrowLeft />
                Back
            </Button>
            <CommandInput v-if="!openEmojiPicker" placeholder="Type a command or search..." />
            <CommandList v-if="!openEmojiPicker">
                <CommandEmpty>No results found.</CommandEmpty>
                <CommandGroup heading="Suggestions">
                    <CommandItem value="statistics" @select="navigateTo(route('finance.dashboard'))">
                        Latest Statistics
                    </CommandItem>
                    <CommandItem value="search-emoji" @select="openEmojiPicker = true">
                        Search Emoji
                    </CommandItem>

                </CommandGroup>
                <CommandSeparator />
                <CommandGroup heading="Settings">
                    <CommandItem value="profile" @select="navigateTo(route('profile.edit'))">
                        Profile
                    </CommandItem>
                </CommandGroup>
            </CommandList>
            <EmojiPickerDialog v-if="open" :is-open="openEmojiPicker" class="p-6" />
        </CommandDialog>

    </div>



</template>

<script setup lang="ts">
import {
    CommandDialog,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
    CommandSeparator,
} from '@/components/ui/command'
import { router } from '@inertiajs/vue3'

import { useMagicKeys } from '@vueuse/core'
import { ref, watch } from 'vue'
import EmojiPickerDialog from './EmojiPickerDialog.vue'
import Button from './ui/button/Button.vue'
import { ArrowLeft } from 'lucide-vue-next'
import { toast } from './ui/toast'

const open = ref(false)
const openEmojiPicker = ref(false);

const { Meta_K, Ctrl_K } = useMagicKeys({
    passive: false,
    onEventFired(e) {
        if (e.key === 'k' && (e.metaKey || e.ctrlKey))
            e.preventDefault()
    },
})


watch([Meta_K, Ctrl_K], (v) => {
    if (v[0] || v[1])
        handleOpenChange()
})

function handleOpenChange() {
    open.value = !open.value
    openEmojiPicker.value = false;
}

const navigateTo = (url: any) => {
    open.value = !open.value
    router.get(url);
}

</script>