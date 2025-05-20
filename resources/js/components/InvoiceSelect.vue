<template>
    <div class="flex flex-col space-y-2">
        <UseTemplate>
            <Command>
                <CommandInput placeholder="Find invoice by number" />
                <CommandList>
                    <CommandEmpty>No results found.</CommandEmpty>
                    <CommandGroup>
                        <CommandItem v-for="invoice of invoices.data" :key="invoice.invoiceNumber"
                            :value="invoice.invoiceNumber" @select="onInvoiceSelect(invoice)">
                            {{ invoice.invoiceNumber }}
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </UseTemplate>

        <Popover v-model:open="isOpen">
            <PopoverTrigger as-child>
                <Button variant="outline" class=" justify-start">
                    {{ selectedInvoice ? selectedInvoice.invoiceNumber : "Select a invoice" }}
                </Button>
            </PopoverTrigger>
            <PopoverContent class="w-[300px] md:w-[500px] p-0 ">
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
const selectedInvoice = ref(null);
const emit = defineEmits();
const propsData = defineProps({
    invoices: Array,
})

const onInvoiceSelect = (invoice) => {
    ;
    selectedInvoice.value = invoice;
    emit('bindSelectedInvoice', invoice);
    isOpen.value = false
}

</script>