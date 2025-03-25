<template>
    <Popover v-model:open="open">
        <PopoverTrigger as-child>
            <Button variant="outline" class="w-full justify-between items-center flex">
                <p class="text-muted-foreground">Select roles</p>
                <div class="flex  justify-center items-center">
                    <Badge v-for="(selectedItems, index) in selectedItems" :key="index" variant="ghost"
                        v-if="!isSelectedAboveTwo" class="ms-2">
                        {{ selectedItems }}</Badge>

                    <Badge v-else class="ms-2">
                        {{ selectedItems.length }} selected</Badge>
                </div>
            </Button>
        </PopoverTrigger>

        <PopoverContent class="p-0 max-w-[460px] w-[460px]" side="bottom">
            <Command>
                <CommandInput placeholder="search by name..." />
                <CommandList>
                    <CommandEmpty>No results found.</CommandEmpty>
                    <CommandGroup>
                        <CommandItem v-for="item in items" :key="item.label" :value="item.value"
                            @select="SelectItems(item.value)" class="!z-[99999] flex justify-between items-center"
                            :class="{ 'bg-muted': selectedItems.includes(item.value) }">

                            <div class="members-details flex items-center gap-2">
                                <div class="flex flex-col items-start">
                                    <span>{{ item.label }}</span>
                                </div>
                            </div>

                            <Check v-show="selectedItems.includes(item.value)" class="size-4" />

                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>

<script setup lang="ts">
import Button from '../ui/button/Button.vue';
import { Check } from 'lucide-vue-next';
import Popover from '../ui/popover/Popover.vue';
import PopoverTrigger from '../ui/popover/PopoverTrigger.vue';
import Badge from '../ui/badge/Badge.vue';
import PopoverContent from '../ui/popover/PopoverContent.vue';
import CommandList from '../ui/command/CommandList.vue';
import CommandInput from '../ui/command/CommandInput.vue';
import Command from '../ui/command/Command.vue';
import CommandEmpty from '../ui/command/CommandEmpty.vue';
import CommandGroup from '../ui/command/CommandGroup.vue';
import CommandItem from '../ui/command/CommandItem.vue';
import { ref, computed, watch } from 'vue';
const emit = defineEmits();
const open = ref(false);
interface Items {
    lable: string,
    value: string,
}
const propsData = defineProps<{ items: Items }>()


const selectedItems = ref<string[]>([]);
const SelectItems = (selectedItemsFromUser: string) => {
    if (!selectedItems.value.includes(selectedItemsFromUser)) {
        selectedItems.value.push(selectedItemsFromUser);
    } else {
        const clickedIndex = selectedItems.value.findIndex(item => item === selectedItemsFromUser);
        selectedItems.value.splice(clickedIndex, 1);
    }
}

const isSelectedAboveTwo = computed(() => {
    return selectedItems.value.length >= 4;
})

watch((selectedItems), (items) => {
    emit('bindSelectedItems', items)
}, { deep: true })
</script>