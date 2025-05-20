<template>
    <Alert class="mb-6" variant="warning">
        <AlertCircleIcon class="h-4 w-4" />
        <AlertTitle>Pending Stock Requests</AlertTitle>
        <AlertDescription>
            You have {{ pendingStockRequests }} pending stock requests from other departments.
            <Button variant="link" class="p-0 h-auto text-amber-600 font-medium">
                Review requests
            </Button>
        </AlertDescription>
    </Alert>
</template>

<script setup>
import Alert from '@/components/ui/alert/Alert.vue';
import AlertDescription from '@/components/ui/alert/AlertDescription.vue';
import AlertTitle from '@/components/ui/alert/AlertTitle.vue';
import Button from '@/components/ui/button/Button.vue';
import { AlertCircleIcon } from 'lucide-vue-next';
const propsData = defineProps({
    pendingStockRequests: Number,
});
</script>