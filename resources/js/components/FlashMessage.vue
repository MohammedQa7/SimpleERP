<template>
    <div v-if="type == 'success'"
        class="mb-6 flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 p-4 shadow-sm">
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100">
            <Check class="h-5 w-5 text-emerald-600" />
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-semibold text-emerald-900">Success</h4>
            <p class="text-sm text-emerald-700">{{ message }}</p>
        </div>
    </div>

    <!-- Error Notification -->
    <div v-if="type == 'error'"
        class="mb-6 flex items-center gap-3 rounded-lg border border-red-200 bg-red-50 p-4 shadow-sm">
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100">
            <AlertCircle class="h-5 w-5 text-red-600" />
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-semibold text-red-900">Connection Failed</h4>
            <p class="text-sm text-red-700">{{ message }}</p>
        </div>
    </div>
</template>

<script setup>
import { AlertCircle, Check } from 'lucide-vue-next';


const propsData = defineProps({
    message: String,
    type: String,
})

</script>