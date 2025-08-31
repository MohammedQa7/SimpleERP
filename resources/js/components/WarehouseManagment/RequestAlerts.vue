    <template>
        <Alert class="mb-6 border-l-4 border-l-amber-500 shadow-md hover:shadow-lg transition-shadow duration-200"
            variant="warning">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <AlertCircleIcon class="h-5 w-5 text-amber-600 animate-pulse" />
                    </div>
                    <div class="flex-1">
                        <AlertTitle class=" font-semibold text-lg mb-1">
                            Pending Stock Requests
                        </AlertTitle>
                        <AlertDescription>
                            <div class="mb-3">
                                You have
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 bg-amber-700 text-white text-sm font-bold rounded-full mx-1">
                                    {{ pendingStockRequests }}
                                </span>
                                pending stock {{ pendingStockRequests === 1 ? 'request' : 'requests' }} from other
                                departments.
                            </div>
                            <div class="text-sm  mb-2 font-medium">
                                ⏰ Immediate attention required to avoid stock shortages
                            </div>
                        </AlertDescription>
                    </div>
                </div>
                <div class="flex-shrink-0 ml-4">
                    <Button variant="default"
                        class="bg-amber-600 hover:bg-amber-700 text-white font-medium px-4 py-2 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105">
                        <span class="flex items-center space-x-2">
                            <span>Review Requests</span>
                            <span class="text-xs bg-amber-500 px-2 py-1 rounded-full font-semibold">
                                {{ pendingStockRequests }}
                            </span>
                        </span>
                    </Button>
                </div>
            </div>
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
