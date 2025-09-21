<script setup lang="ts">
import type { DateRange } from 'radix-vue'
import { Button } from '@/components/ui/button'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import { RangeCalendar } from '@/components/ui/range-calendar'
import { cn } from '@/lib/utils'
import {
  DateFormatter,
  getLocalTimeZone,
  parseDate,
} from '@internationalized/date'
import { Calendar, Calendar as CalendarIcon } from 'lucide-vue-next'
import { onMounted, type Ref, ref, watch } from 'vue'
const df = new DateFormatter('en-US', { dateStyle: 'medium' })
const propsData = defineProps({
  startDate: String,
  endDate: String,
});

const emit = defineEmits();

const value = ref({
  start: undefined,
  end: undefined,
}) as Ref<DateRange>


watch((value), () => {
  if (value.value.start && value.value.end) {
    const dates = {
      startDate: value.value.start.toString(),
      endDate: value.value.end.toString(),
    }
    emit('bindDate', dates);
  }
}, { deep: true })


onMounted(() => {
  if (propsData.startDate && propsData.endDate) {
    value.value.start = parseDate(propsData.startDate);
    value.value.end = parseDate(propsData.endDate);
  }
});
</script>

<template>
  <Popover>
    <PopoverTrigger as-child>
      <Button variant="outline" size="sm" :class="cn(
        'flex flex-wrap justify-start text-left',
        !value && 'text-muted-foreground',
      )">
        <Calendar class="mr-2 h-4 w-4" />
        <template v-if="value.start">
          <template v-if="value.end">
            {{ df.format(value.start.toDate(getLocalTimeZone())) }} - {{
              df.format(value.end.toDate(getLocalTimeZone())) }}
          </template>

          <template v-else>
            {{ df.format(value.start.toDate(getLocalTimeZone())) }}
          </template>
        </template>
        <template v-else>
          Date Range
        </template>
      </Button>
    </PopoverTrigger>
    <PopoverContent class="w-auto p-0">
      <RangeCalendar v-model="value" initial-focus :number-of-months="2"
        @update:start-value="(startDate: any) => value.start = startDate" />
    </PopoverContent>
  </Popover>
</template>