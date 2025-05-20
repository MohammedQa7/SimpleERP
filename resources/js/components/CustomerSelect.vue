<template>
    <div class="flex flex-col space-y-2">
        <UseTemplate>
            <Command :disabled="disabled">
                <CommandInput placeholder="Find customer" />
                <CommandList>
                    <CommandEmpty>No results found.</CommandEmpty>
                    <CommandGroup>
                        <CommandItem v-for="customer of customers.data" :key="customer.customerCode"
                            :value="customer.customerCode" @select="onCustomerSelect(customer)">
                            {{ customer.fullName }}
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </UseTemplate>

        <Popover v-model:open="isOpen">
            <PopoverTrigger as-child :disabled="disabled">
                <Button variant="outline" class=" justify-start">
                    {{ selectedCustomer ? selectedCustomer.fullName :
                        preSelectedCustomer ? preSelectedCustomer.fullName : "Select a customer" }}
                </Button>
            </PopoverTrigger>
            <PopoverContent class="w-[200px] p-0 ">
                <CustomerList />
            </PopoverContent>
        </Popover>
    </div>
</template>

<script setup>
import { createReusableTemplate } from '@vueuse/core';
import Button from './ui/button/Button.vue';
import Command from './ui/command/Command.vue';
import CommandEmpty from './ui/command/CommandEmpty.vue';
import CommandGroup from './ui/command/CommandGroup.vue';
import CommandInput from './ui/command/CommandInput.vue';
import CommandItem from './ui/command/CommandItem.vue';
import CommandList from './ui/command/CommandList.vue';
import Popover from './ui/popover/Popover.vue';
import PopoverContent from './ui/popover/PopoverContent.vue';
import PopoverTrigger from './ui/popover/PopoverTrigger.vue';
import { ref } from 'vue';
const [UseTemplate, CustomerList] = createReusableTemplate()
const isOpen = ref(false)
const selectedCustomer = ref(null);
const emit = defineEmits();
const propsData = defineProps({
    customers: Array,
    preSelectedCustomer: Object,
    disabled: Boolean,
})

const onCustomerSelect = (customer) => {
    selectedCustomer.value = customer;
    emit('bindSelectedCustomer', customer);
    isOpen.value = false
}

</script>