<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button variant="outline" :class="cn(
                ' ps-3 text-start font-normal',
                !date && 'text-muted-foreground',
            )">
                <span>{{ date
                    ? df.format(toDate(date))
                    : "Pick a date" }}</span>
                <CalendarIcon class="ms-auto h-4 w-4 opacity-50" />
            </Button>
            <input hidden>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <Calendar v-model="date" calendar-label="Date of birth" initial-focus />
        </PopoverContent>
    </Popover>
</template>

<script setup>
import { ref, computed } from 'vue'
import {
    Plus,
    Trash,
    CalendarIcon
} from 'lucide-vue-next'

import Button from '@/components/ui/button/Button.vue'
import Calendar from '@/components/ui/calendar/Calendar.vue'
import Popover from '@/components/ui/popover/Popover.vue'
import PopoverTrigger from '@/components/ui/popover/PopoverTrigger.vue'
import PopoverContent from '@/components/ui/popover/PopoverContent.vue'
import { cn } from '@/lib/utils'
import { DateFormatter, parseDate } from '@internationalized/date'
import { watch } from 'vue'
import { toDate } from 'radix-vue/date'
import { format, parse } from "date-fns";
const df = new DateFormatter('en-US', {
    dateStyle: 'long',
})
const date = ref();


const emit = defineEmits();

const onBindSelectedCustomer = (customer) => {
    form.customerId = customer.id

}

watch(date, () => {
    if (date) {
        const formatedDate = date.value.day + '/' + date.value.month + '/' + date.value.year;
        emit('bindCalendarDate', formatedDate);
    }
})




</script>
