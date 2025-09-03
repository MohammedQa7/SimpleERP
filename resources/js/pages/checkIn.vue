<template>
  <div class="min-h-screen bg-background p-8">

    <div class="flex justify-center">
      <Button v-if="!isCheckedIn" @click="handleCheckIn"
        class="">
        <Clock class="mr-2 h-5 w-5" />
        Check In
      </Button>
      <div v-else class="text-center text-muted-foreground">
        <Clock class="mx-auto h-8 w-8 mb-2" />
        <p>You're checked in! Use the floating panel to check out.</p>
      </div>
    </div>

    <!-- Floating Status Section -->
    <div v-if="isCheckedIn"
      class="fixed top-4 right-4 p-4 shadow-lg border  backdrop-blur-sm transition-all duration-300 ease-in-out z-50 rounded-lg"
      :class="[
        isFloatingVisible ? 'translate-x-0 opacity-100' : 'translate-x-full opacity-0'
      ]">
      <div class="flex items-start justify-between gap-3 min-w-[280px]">
        <div class="flex-1 space-y-2">
          <div class="flex items-center gap-2 text-sm">
            <User class="h-4 w-4 text-muted-foreground" />
            <span class="font-medium">{{ userName }}</span>
          </div>

          <div class="space-y-1 text-xs text-muted-foreground">
            <div class="flex items-center gap-2">
              <span>Checked in:</span>
              <span class="font-mono">
                {{ checkInTime ? formatTime(checkInTime) : '' }} • {{ checkInTime ? formatDate(checkInTime) : '' }}
              </span>
            </div>

            <div class="flex items-center gap-2">
              <span>Current time:</span>
              <span class="font-mono font-medium text-foreground">{{ formatTime(currentTime) }}</span>
            </div>
          </div>
        </div>

        <button @click="isFloatingVisible = false"
          class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-6 w-6 p-0 ">
          <X class="h-3 w-3" />
        </button>
      </div>

      <div class="mt-3 pt-3 border-t transition-all duration-200 ease-in-out">
        <button @click="handleCheckOut"
          class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 w-full text-xs h-8">
          <LogOut class="h-3 w-3 mr-2" />
          Check Out
        </button>
      </div>
    </div>

    <!-- Show floating section button when hidden -->
    <button v-if="isCheckedIn && !isFloatingVisible" @click="isFloatingVisible = true"
      class="fixed top-4 right-4 shadow-lg bg-card/95 backdrop-blur-sm animate-pulse inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
      <Clock class="h-4 w-4 mr-2 animate-spin" />
      Status
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Clock, User, X, LogOut } from 'lucide-vue-next'
import Button from '@/components/ui/button/Button.vue'

const isCheckedIn = ref(false)
const checkInTime = ref(null)
const currentTime = ref(new Date())
const isFloatingVisible = ref(false)
const isFloatingHovered = ref(false)
const userName = ref('John Doe') // In a real app, this would come from auth

let timer = null

// Update current time every second
onMounted(() => {
  timer = setInterval(() => {
    currentTime.value = new Date()
  }, 1000)
})

onUnmounted(() => {
  if (timer) {
    clearInterval(timer)
  }
})

const handleCheckIn = () => {
  const now = new Date()
  isCheckedIn.value = true
  checkInTime.value = now
  isFloatingVisible.value = true
}

const handleCheckOut = () => {
  isCheckedIn.value = false
  checkInTime.value = null
  isFloatingVisible.value = false
}

const formatTime = (date) => {
  return date.toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: true,
  })
}

const formatDate = (date) => {
  return date.toLocaleDateString('en-US', {
    weekday: 'short',
    month: 'short',
    day: 'numeric',
  })
}
</script>
