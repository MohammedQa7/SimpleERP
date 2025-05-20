<template>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Events Calendar</h2>
    </div>

    <div class="bg-background rounded-lg border shadow-sm p-6 max-w-full ">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 ">
            <div>
                <h1 class="text-2xl font-bold text-foreground">ERP Calendar</h1>
                <p class="text-muted-foreground">{{ formattedViewDate }}</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <Button variant="outline" size="icon" @click="navigatePrevious">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </Button>
                    <Button variant="outline" size="sm" @click="resetToToday">Today</Button>
                    <Button variant="outline" size="icon" @click="navigateNext">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-right">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </Button>
                </div>
                <div class="flex items-center gap-1">
                    <Button @click="currentView = 'week'" :variant="currentView === 'week' ? 'default' : 'outline'"
                        size="sm">
                        Week
                    </Button>
                    <Button @click="currentView = 'month'" :variant="currentView === 'month' ? 'default' : 'outline'"
                        size="sm">
                        Month
                    </Button>
                </div>
            </div>
        </div>

        <!-- Week View -->
        <div v-if="currentView === 'week'" class="overflow-hidden">
            <!-- Days of the week header -->
            <div class="grid grid-cols-7 mb-2">
                <div v-for="(day, index) in weekDays" :key="index" class="text-center py-2">
                    <div class="font-medium text-sm">{{ day.name }}</div>
                    <div class="text-2xl mt-1 w-10 h-10 flex items-center justify-center mx-auto rounded-full"
                        :class="isToday(day.date) ? 'bg-primary text-primary-foreground' : 'text-foreground'">
                        {{ day.date.getDate() }}
                    </div>
                </div>
            </div>

            <!-- Week events -->
            <div class="grid grid-cols-7 gap-2 mt-4">
                <div v-for="(day, dayIndex) in weekDays" :key="dayIndex"
                    class="min-h-[200px] bg-muted rounded-lg p-2 relative">
                    <div v-for="event in getEventsForDate(day.date)" :key="`${dayIndex}-${event.id}`"
                        class="mb-2 p-2 rounded-lg cursor-pointer text-sm transition-all hover:shadow-md"
                        :class="getEventClasses(event, true)" @click="selectEvent(event)">
                        <div class="font-medium">{{ event.title }}</div>
                        <div class="text-xs mt-1 opacity-80">{{ event.startsAt }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Month View -->
        <div v-else-if="currentView === 'month'" class="overflow-hidden">
            <!-- Days of the week header -->
            <div class="grid grid-cols-7 mb-2">
                <div v-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']" :key="day"
                    class="text-center py-2 font-medium text-sm text-muted-foreground">
                    {{ day }}
                </div>
            </div>

            <!-- Month grid -->
            <div class="grid grid-cols-7 gap-1">
                <div v-for="(day, index) in monthDays" :key="index"
                    class="min-h-[100px] border border-border p-1 relative"
                    :class="{ 'bg-muted/50': !isCurrentMonth(day) }">
                    <div class="text-sm w-6 h-6 flex items-center justify-center rounded-full mb-1"
                        :class="isToday(day) ? 'bg-primary text-primary-foreground' : 'text-foreground'">
                        {{ day.getDate() }}
                    </div>

                    <div v-for="event in getEventsForDate(day)" :key="`month-${index}-${event.id}`"
                        class="mb-1 px-1.5 py-1 rounded text-xs cursor-pointer truncate transition-colors"
                        :class="getEventClasses(event, true, true)" @click="selectEvent(event)">
                        {{ event.title }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Event details dialog -->
        <EventDetailsDialog v-if="selectedEvent" :event="selectedEvent" :is-open="isEventDetailsDialogOpened"
            @update:open="isEventDetailsDialogOpened = $event" />
    </div>
</template>

<script setup>
import { ref, computed, h } from 'vue';
import { Button } from '@/components/ui/button';
import dayjs from 'dayjs';
import EventDetailsDialog from '@/components/HrDep/EventDetailsDialog.vue';
import AppLayout from '@/layouts/AppLayout.vue';
const isEventDetailsDialogOpened = ref(false);
const selectedEvent = ref(null);
const currentView = ref('week');
const currentDate = ref(new Date());
const propsData = defineProps({
    events: Array,
});


// Select an event to show details
const selectEvent = (event) => {
    console.log(event);

    selectedEvent.value = event
    isEventDetailsDialogOpened.value = true;
};


const formattedViewDate = computed(() => {
    if (currentView.value === 'week') {
        const startOfWeek = weekDays.value[0].date;
        const endOfWeek = weekDays.value[6].date;

        // If same month
        if (startOfWeek.getMonth() === endOfWeek.getMonth()) {
            return `${startOfWeek.toLocaleDateString('en-US', { month: 'long' })} ${startOfWeek.getDate()} - ${endOfWeek.getDate()}, ${startOfWeek.getFullYear()}`;
        }

        // If different months
        return `${startOfWeek.toLocaleDateString('en-US', { month: 'short' })} ${startOfWeek.getDate()} - ${endOfWeek.toLocaleDateString('en-US', { month: 'short' })} ${endOfWeek.getDate()}, ${startOfWeek.getFullYear()}`;
    } else {
        return currentDate.value.toLocaleDateString('en-US', {
            month: 'long',
            year: 'numeric'
        });
    }
});

// Generate week days
const weekDays = computed(() => {
    const day = currentDate.value.getDay(); // 0 = Sunday, 6 = Saturday
    // Calculate the start of the week (Sunday)
    const startDate = new Date(currentDate.value);
    startDate.setDate(currentDate.value.getDate() - day);

    // Generate 7 days
    return Array.from({ length: 7 }, (_, i) => {
        const date = new Date(startDate);
        date.setDate(startDate.getDate() + i);
        return {
            name: date.toLocaleDateString('en-US', { weekday: 'short' }),
            date: date
        };
    });
});

// Generate month days
// Generate month days based on current date
const monthDays = computed(() => {
    const date = new Date(currentDate.value);
    const year = date.getFullYear();
    const month = date.getMonth();

    // First day of the month
    const firstDay = new Date(year, month, 1);
    const firstDayOfWeek = firstDay.getDay(); // 0 = Sunday, 6 = Saturday

    // Last day of the month
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();

    // Previous month days to show
    const prevMonthDays = [];
    if (firstDayOfWeek > 0) {
        const prevMonth = new Date(year, month, 0);
        const prevMonthDaysCount = prevMonth.getDate();

        for (let i = firstDayOfWeek - 1; i >= 0; i--) {
            const day = new Date(year, month - 1, prevMonthDaysCount - i);
            prevMonthDays.push(day);
        }
    }

    // Current month days
    const currentMonthDays = [];
    for (let i = 1; i <= daysInMonth; i++) {
        const day = new Date(year, month, i);
        currentMonthDays.push(day);
    }

    // Next month days to fill the grid (6 rows x 7 columns = 42 cells)
    const nextMonthDays = [];
    const totalDays = prevMonthDays.length + currentMonthDays.length;
    const remainingDays = 42 - totalDays;

    for (let i = 1; i <= remainingDays; i++) {
        const day = new Date(year, month + 1, i);
        nextMonthDays.push(day);
    }

    return [...prevMonthDays, ...currentMonthDays, ...nextMonthDays];
});



// Get event classes based on priority and type
const getEventClasses = (event, isCompact = false, isMini = false) => {
    // Priority classes using shadcn design tokens
    const priorityClasses = {
        Low: isCompact
            ? 'bg-background border border-border text-foreground hover:bg-muted/90 ring-1 ring-ring/10'
            : 'bg-background border-l-4 border-l-primary/30 text-foreground',
        Medium: isCompact
            ? 'bg-primary/5 border border-primary/20 text-primary hover:bg-primary/10'
            : 'bg-primary/5 border-l-4 border-l-primary/50 text-primary',
        Normal: isCompact
            ? 'bg-secondary/60 border border-secondary/20 text-secondary-foreground hover:bg-secondary/20'
            : 'bg-secondary/60 border-l-4 border-l-secondary/50 text-secondary-foreground',
        High: isCompact
            ? 'bg-destructive/10 border border-destructive/20 text-destructive-foreground hover:bg-destructive/20'
            : 'bg-destructive/10 border-l-4 border-l-destructive/50 text-destructive-foreground'
    };

    // Mini view (month view) has even more compact styling
    if (isMini) {
        return `${priorityClasses[event.priority]} text-xs py-0.5 px-1`;
    }

    return priorityClasses[event.priority];
};


// Check if a date is today
const isToday = (date) => {
    const today = new Date();
    return date.getDate() === today.getDate() &&
        date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear();
};

// Check if a date is in the current month
const isCurrentMonth = (date) => {
    const today = new Date();
    return date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear();
};


const resetToToday = () => {
    currentDate.value = new Date();
}

// Navigation functions
const navigatePrevious = () => {
    const newDate = new Date(currentDate.value);

    if (currentView.value === 'week') {
        // Go to previous week
        newDate.setDate(newDate.getDate() - 7);
    } else {
        // Go to previous month
        newDate.setMonth(newDate.getMonth() - 1);
    }

    currentDate.value = newDate;
};

const navigateNext = () => {
    const newDate = new Date(currentDate.value);

    if (currentView.value === 'week') {
        // Go to next week
        newDate.setDate(newDate.getDate() + 7);
    } else {
        // Go to next month
        newDate.setMonth(newDate.getMonth() + 1);
    }

    currentDate.value = newDate;
};

// Get events for a specific date
const getEventsForDate = (calendarDate) => {
    const fomratedCalendarDate = new Date(calendarDate).toISOString();
    return propsData.events.data.filter(event => {
        return dayjs(fomratedCalendarDate).isSame(dayjs(event.startDate), 'day')
    });
};

defineOptions({
    layout: AppLayout,
})
</script>
