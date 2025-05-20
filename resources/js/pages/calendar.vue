<template>
  <div class="bg-background rounded-lg border shadow-sm p-6 max-w-5xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
      <div>
        <h1 class="text-2xl font-bold text-foreground">ERP Calendar</h1>
        <p class="text-muted-foreground">{{ formattedViewDate }}</p>
      </div>
      <div class="flex items-center gap-4">
        <div class="flex items-center gap-2">
          <Button variant="outline" size="icon" @click="navigatePrevious">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
            <span class="sr-only">Previous</span>
          </Button>
          <Button variant="outline" size="sm" @click="resetToToday">Today</Button>
          <Button variant="outline" size="icon" @click="navigateNext">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
            <span class="sr-only">Next</span>
          </Button>
        </div>
        <div class="flex items-center gap-1">
          <Button 
            @click="currentView = 'week'"
            :variant="currentView === 'week' ? 'default' : 'outline'"
            size="sm"
          >
            Week
          </Button>
          <Button 
            @click="currentView = 'month'"
            :variant="currentView === 'month' ? 'default' : 'outline'"
            size="sm"
          >
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
          <div 
            class="text-2xl mt-1 w-10 h-10 flex items-center justify-center mx-auto rounded-full"
            :class="isToday(day.date) ? 'bg-primary text-primary-foreground' : 'text-foreground'"
          >
            {{ day.date.getDate() }}
          </div>
        </div>
      </div>

      <!-- Week events -->
      <div class="grid grid-cols-7 gap-2 mt-4">
        <div v-for="(day, dayIndex) in weekDays" :key="dayIndex" class="min-h-[200px] bg-muted rounded-lg p-2 relative">
          <div 
            v-for="event in getEventsForDate(day.date)" 
            :key="`${dayIndex}-${event.id}`"
            class="mb-2 p-2 rounded-lg cursor-pointer text-sm transition-all hover:shadow-md"
            :class="getEventClasses(event, true)"
            @click="selectEvent(event)"
          >
            <div class="font-medium">{{ event.title }}</div>
            <div class="text-xs mt-1 opacity-80">{{ formatEventTimeShort(event) }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Month View -->
    <div v-else-if="currentView === 'month'" class="overflow-hidden">
      <!-- Days of the week header -->
      <div class="grid grid-cols-7 mb-2">
        <div v-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']" :key="day" class="text-center py-2 font-medium text-sm text-muted-foreground">
          {{ day }}
        </div>
      </div>

      <!-- Month grid -->
      <div class="grid grid-cols-7 gap-1">
        <div 
          v-for="(day, index) in monthDays" 
          :key="index"
          class="min-h-[100px] border border-border p-1 relative"
          :class="{'bg-muted/50': !isCurrentMonth(day)}"
        >
          <div 
            class="text-sm w-6 h-6 flex items-center justify-center rounded-full mb-1"
            :class="isToday(day) ? 'bg-primary text-primary-foreground' : 'text-foreground'"
          >
            {{ day.getDate() }}
          </div>
          
          <div 
            v-for="event in getEventsForDate(day)" 
            :key="`month-${index}-${event.id}`"
            class="mb-1 px-1.5 py-1 rounded text-xs cursor-pointer truncate transition-colors"
            :class="getEventClasses(event, true, true)"
            @click="selectEvent(event)"
          >
            {{ event.title }}
          </div>
        </div>
      </div>
    </div>

    <!-- Event details dialog -->
    <Dialog :open="!!selectedEvent" @update:open="selectedEvent = null">
      <DialogContent v-if="selectedEvent" class="sm:max-w-md">
        <DialogHeader>
          <div class="flex items-start gap-3">
            <div :class="getEventIconClass(selectedEvent)" class="rounded-full p-2 flex items-center justify-center">
              <component :is="getEventIcon(selectedEvent)" class="h-5 w-5" />
            </div>
            <DialogTitle>{{ selectedEvent.title }}</DialogTitle>
          </div>
        </DialogHeader>
        
        <div class="space-y-4">
          <Card>
            <CardContent class="p-3 flex items-center gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <div>
                <div class="text-sm text-muted-foreground">Time</div>
                <div class="font-medium">{{ formatEventTime(selectedEvent) }}</div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-3 flex items-center gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <div>
                <div class="text-sm text-muted-foreground">Location</div>
                <div class="font-medium">{{ selectedEvent.location }}</div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-3 flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-muted-foreground mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <div>
                <div class="text-sm text-muted-foreground">Description</div>
                <div class="font-medium">{{ selectedEvent.description }}</div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-3 flex items-center gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              <div>
                <div class="text-sm text-muted-foreground">Assigned To</div>
                <div class="font-medium">{{ selectedEvent.assignedTo }}</div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-3 flex items-center gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
              </svg>
              <div>
                <div class="text-sm text-muted-foreground">Priority</div>
                <div class="font-medium capitalize">{{ selectedEvent.priority }}</div>
              </div>
            </CardContent>
          </Card>
          
          <div class="pt-4 flex justify-end gap-2">
            <Button variant="outline">Edit</Button>
            <Button>Complete</Button>
          </div>
        </div>
      </DialogContent>
    </Dialog>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, h } from 'vue';

// Import shadcn components individually
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Card, CardContent } from '@/components/ui/card';

// Current view (week, month)
const currentView = ref('week');

// Current date for navigation
const currentDate = ref(new Date());

// Sample data for events
const events = ref([
  {
    id: 1,
    title: 'Inventory Review',
    start: new Date(new Date().setHours(9, 0, 0)),
    end: new Date(new Date().setHours(10, 30, 0)),
    description: 'Quarterly inventory review with warehouse team',
    priority: 'medium',
    location: 'Warehouse A',
    assignedTo: 'John Smith',
    type: 'meeting'
  },
  {
    id: 2,
    title: 'Client Onboarding',
    start: new Date(new Date().setHours(11, 0, 0)),
    end: new Date(new Date().setHours(12, 0, 0)),
    description: 'New client onboarding process for ABC Corp',
    priority: 'high',
    location: 'Conference Room 2',
    assignedTo: 'Sarah Johnson',
    type: 'client'
  },
  {
    id: 3,
    title: 'System Maintenance',
    start: new Date(new Date().setHours(13, 0, 0)),
    end: new Date(new Date().setHours(14, 0, 0)),
    description: 'Scheduled maintenance for ERP system modules',
    priority: 'high',
    location: 'IT Department',
    assignedTo: 'Tech Team',
    type: 'maintenance'
  },
  {
    id: 4,
    title: 'Budget Planning',
    start: new Date(new Date().setHours(15, 0, 0)),
    end: new Date(new Date().setHours(16, 30, 0)),
    description: 'Q3 budget planning session with finance team',
    priority: 'medium',
    location: 'Finance Office',
    assignedTo: 'Finance Department',
    type: 'meeting'
  },
  {
    id: 5,
    title: 'Shipping Deadline',
    start: new Date(new Date().setHours(17, 0, 0)),
    end: new Date(new Date().setHours(17, 30, 0)),
    description: 'Final deadline for international shipments',
    priority: 'urgent',
    location: 'Shipping Department',
    assignedTo: 'Logistics Team',
    type: 'deadline'
  },
  // Additional events for week/month view
  {
    id: 6,
    title: 'Product Launch',
    start: new Date(new Date().setDate(new Date().getDate() + 1)),
    end: new Date(new Date().setDate(new Date().getDate() + 1)),
    description: 'New product line launch meeting',
    priority: 'high',
    location: 'Marketing Department',
    assignedTo: 'Product Team',
    type: 'meeting'
  },
  {
    id: 7,
    title: 'Vendor Meeting',
    start: new Date(new Date().setDate(new Date().getDate() + 2)),
    end: new Date(new Date().setDate(new Date().getDate() + 2)),
    description: 'Quarterly review with key suppliers',
    priority: 'medium',
    location: 'Conference Room 1',
    assignedTo: 'Procurement Team',
    type: 'client'
  },
  {
    id: 8,
    title: 'Staff Training',
    start: new Date(new Date().setDate(new Date().getDate() + 3)),
    end: new Date(new Date().setDate(new Date().getDate() + 3)),
    description: 'ERP system training for new staff',
    priority: 'medium',
    location: 'Training Room',
    assignedTo: 'HR Department',
    type: 'training'
  },
  {
    id: 9,
    title: 'Quarterly Report',
    start: new Date(new Date().setDate(new Date().getDate() + 5)),
    end: new Date(new Date().setDate(new Date().getDate() + 5)),
    description: 'Prepare quarterly financial reports',
    priority: 'high',
    location: 'Finance Office',
    assignedTo: 'Finance Team',
    type: 'deadline'
  }
]);

// Selected event for details modal
const selectedEvent = ref(null);

// Format the current date based on view
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

// Generate week days based on current date
const weekDays = computed(() => {
  const date = new Date(currentDate.value);
  const day = date.getDay(); // 0 = Sunday, 6 = Saturday
  
  // Calculate the start of the week (Sunday)
  const startDate = new Date(date);
  startDate.setDate(date.getDate() - day);
  
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

const resetToToday = () => {
  currentDate.value = new Date();
};

// Format event time
const formatEventTime = (event) => {
  const startTime = event.start.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
  const endTime = event.end.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
  return `${startTime} - ${endTime}`;
};

// Format event time (short version for week/month views)
const formatEventTimeShort = (event) => {
  return event.start.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
};

// Get event classes based on priority and type
const getEventClasses = (event, isCompact = false, isMini = false) => {
  // Priority classes using solid color tokens
  const priorityClasses = {
    low: isCompact 
      ? 'bg-card border border-border text-card-foreground hover:bg-accent' 
      : 'bg-card border-l-4 border-l-muted-foreground text-card-foreground',
    medium: isCompact 
      ? 'bg-accent border border-accent text-accent-foreground hover:bg-accent/80' 
      : 'bg-accent border-l-4 border-l-primary text-accent-foreground',
    high: isCompact 
      ? 'bg-popover border border-popover text-popover-foreground hover:bg-popover/90' 
      : 'bg-popover border-l-4 border-l-primary text-popover-foreground',
    urgent: isCompact 
      ? 'bg-card border-2 border-destructive text-card-foreground hover:bg-destructive/10' 
      : 'bg-card border-l-4 border-l-destructive text-card-foreground'
  };
  
  // Mini view (month view) has even more compact styling
  if (isMini) {
    return `${priorityClasses[event.priority]} text-xs py-0.5 px-1`;
  }
  
  return priorityClasses[event.priority];
};

// Get event icon based on type
const getEventIcon = (event) => {
  const icons = {
    meeting: {
      render() {
        return h('svg', { 
          xmlns: 'http://www.w3.org/2000/svg', 
          fill: 'none', 
          viewBox: '0 0 24 24', 
          stroke: 'currentColor', 
          'stroke-width': '2' 
        }, [
          h('path', { 
            'stroke-linecap': 'round', 
            'stroke-linejoin': 'round', 
            d: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' 
          })
        ]);
      }
    },
    client: {
      render() {
        return h('svg', { 
          xmlns: 'http://www.w3.org/2000/svg', 
          fill: 'none', 
          viewBox: '0 0 24 24', 
          stroke: 'currentColor', 
          'stroke-width': '2' 
        }, [
          h('path', { 
            'stroke-linecap': 'round', 
            'stroke-linejoin': 'round', 
            d: 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' 
          })
        ]);
      }
    },
    maintenance: {
      render() {
        return h('svg', { 
          xmlns: 'http://www.w3.org/2000/svg', 
          fill: 'none', 
          viewBox: '0 0 24 24', 
          stroke: 'currentColor', 
          'stroke-width': '2' 
        }, [
          h('path', { 
            'stroke-linecap': 'round', 
            'stroke-linejoin': 'round', 
            d: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z' 
          }),
          h('path', { 
            'stroke-linecap': 'round', 
            'stroke-linejoin': 'round', 
            d: 'M15 12a3 3 0 11-6 0 3 3 0 016 0z' 
          })
        ]);
      }
    },
    deadline: {
      render() {
        return h('svg', { 
          xmlns: 'http://www.w3.org/2000/svg', 
          fill: 'none', 
          viewBox: '0 0 24 24', 
          stroke: 'currentColor', 
          'stroke-width': '2' 
        }, [
          h('path', { 
            'stroke-linecap': 'round', 
            'stroke-linejoin': 'round', 
            d: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' 
          })
        ]);
      }
    },
    training: {
      render() {
        return h('svg', { 
          xmlns: 'http://www.w3.org/2000/svg', 
          fill: 'none', 
          viewBox: '0 0 24 24', 
          stroke: 'currentColor', 
          'stroke-width': '2' 
        }, [
          h('path', { 
            'stroke-linecap': 'round', 
            'stroke-linejoin': 'round', 
            d: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' 
          })
        ]);
      }
    }
  };
  
  return icons[event.type] || icons.meeting;
};

// Get event icon background class
const getEventIconClass = (event) => {
  const classes = {
    low: 'bg-muted text-muted-foreground',
    medium: 'bg-accent text-accent-foreground',
    high: 'bg-popover text-popover-foreground',
    urgent: 'bg-card text-destructive'
  };
  
  return classes[event.priority];
};

// Select an event to show details
const selectEvent = (event) => {
  selectedEvent.value = event;
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
  const viewDate = currentDate.value;
  return date.getMonth() === viewDate.getMonth() &&
         date.getFullYear() === viewDate.getFullYear();
};

// Get events for a specific date
const getEventsForDate = (date) => {
  return events.value.filter(event => {
    return event.start.getDate() === date.getDate() &&
           event.start.getMonth() === date.getMonth() &&
           event.start.getFullYear() === date.getFullYear();
  });
};
</script>