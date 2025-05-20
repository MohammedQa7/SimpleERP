<template>
    <!-- Horizontal Filters -->
    <div class="my-6 grid gap-4 md:grid-cols-4">

        <!-- User Filter -->
        <div class="space-y-2 flex flex-col justify-center gap-2">
            <Label for="stock-status">User</Label>
            <Popover v-model:open="open">
                <PopoverTrigger as-child>
                    <Button variant="outline" class=" justify-start">
                        <template v-if="filter.user">
                            {{ filter.user }}
                        </template>
                        <template v-else>
                            <h1 class="text-muted-foreground">Select a user</h1>
                        </template>
                    </Button>
                </PopoverTrigger>
                <PopoverContent class="p-0" side="bottom" align="start">
                    <Command>
                        <CommandInput placeholder="Change status..." />
                        <CommandList>
                            <CommandEmpty>No results found.</CommandEmpty>
                            <CommandGroup>
                                <CommandItem @select="() => {
                                    filter.user = null
                                    open = false
                                }">
                                    All users
                                </CommandItem>
                                <CommandItem v-for="user in users.data" :key="user.name" :value="user.name" @select="() => {
                                    filter.user = user.name
                                    open = false
                                }">
                                    {{ user.name }}
                                </CommandItem>
                            </CommandGroup>
                        </CommandList>
                    </Command>
                </PopoverContent>
            </Popover>
        </div>
        <!-- Date Range Filter -->
        <div class="space-y-2">
            <Label for="stock-status">Date</Label>
            <Select v-model="filter.date">
                <SelectTrigger>
                    <SelectValue placeholder="Select a date" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem @select="filter.date = null">
                            All times
                        </SelectItem>
                        <SelectItem value="today">
                            Today
                        </SelectItem>
                        <SelectItem value="this_week">
                            This Week
                        </SelectItem>
                        <SelectItem value="this_month">
                            This Month
                        </SelectItem>
                        <SelectItem value="last_three_months">
                            3 Months Ago
                        </SelectItem>
                        <SelectItem value="last_year">
                            Last Year
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>

        <!-- Change Type Filter -->
        <div class="space-y-2">
            <Label for="stock-status">Type</Label>
            <Select v-model="filter.type">
                <SelectTrigger>
                    <SelectValue placeholder="Select a type" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem @select="filter.type = null">
                            All Changes
                        </SelectItem>
                        <SelectItem value="name">
                            Name Updates
                        </SelectItem>
                        <SelectItem value="price">
                            Price Updates
                        </SelectItem>
                        <SelectItem value="category">
                            Category Updates
                        </SelectItem>
                        <SelectItem value="stock">
                            Stock Updates
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>

        <div class="flex justify-end items-start">
            <Button variant="ghost" size="sm" class="h-8" @click="reset">
                <X class="h-3.5 w-3.5 mr-1.5" />
                Reset
            </Button>
        </div>
    </div>


</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import { X } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList } from '@/components/ui/command'
import Select from '@/components/ui/select/Select.vue'
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue'
import SelectValue from '@/components/ui/select/SelectValue.vue'
import SelectContent from '@/components/ui/select/SelectContent.vue'
import SelectGroup from '@/components/ui/select/SelectGroup.vue'
import SelectItem from '@/components/ui/select/SelectItem.vue'
import Label from '@/components/ui/label/Label.vue'
import { router } from '@inertiajs/vue3'
import { debounce } from 'lodash';
const open = ref(false)
const emit = defineEmits();
const propsData = defineProps({
    product: Object,
    users: Array,
    queryString: Array,
});
const filter = ref({
    user: '',
    date: null,
    type: null,
});


const submitFilter = debounce(() => {
    router.get(route('product.history', [propsData.product.data.sku, filter.value]), {}, {
        preserveScroll: true,
        preserveState: true,
        onStart: () => {
            emit('bindLoadingStatus', true);
        },
        onSuccess: () => {
            emit('bindLoadingStatus', false);
        }
    });
}, 500)

const reset = () => {
    filter.value.user = '';
    filter.value.date = null;
    filter.value.type = null;
}

watch(filter, () => {
    submitFilter();
}, { deep: true })

onMounted(() => {
    filter.value = { ...propsData.queryString };
})

</script>