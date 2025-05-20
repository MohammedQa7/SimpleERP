<template>
    <!-- All Notifications Dialog -->
    <Dialog v-model:open="isDialogOpened" @update:open="isDialogOpened = $event">
        <DialogContent class="sm:max-w-[700px] ">
            <DialogHeader>
                <DialogTitle>All Notifications</DialogTitle>
                <DialogDescription>
                    View and manage all your notifications
                </DialogDescription>
            </DialogHeader>
            <Skeleton v-if="isLoading" class="h-96 rounded-xl" />
            <div v-else class="py-4">
                <div class="flex justify-between mb-4">
                    <div class="flex gap-2">
                        <Button variant="outline" size="sm"
                            :class="{ 'bg-primary text-primary-foreground': notificationFilter === 'all' }"
                            @click="notificationFilter = 'all'">
                            All
                        </Button>
                        <Button variant="outline" size="sm"
                            :class="{ 'bg-primary text-primary-foreground': notificationFilter === 'stock_request' }"
                            @click="notificationFilter = 'stock_request'">
                            Stock Requests
                        </Button>
                        <Button variant="outline" size="sm"
                            :class="{ 'bg-primary text-primary-foreground': notificationFilter === 'low_stock' }"
                            @click="notificationFilter = 'low_stock'">
                            Low Stock
                        </Button>
                    </div>
                    <!-- <Button v-if="unreadNotifications.length > 0" variant="ghost" size="sm" @click="markAllAsRead">
                        Mark all as read
                    </Button> -->
                </div>

                <div class="border rounded-md overflow-y-auto h-[350px] p-2">
                    <div v-if="notificaions.length == 0" class="p-4 text-center text-muted-foreground">
                        No notifications found
                    </div>
                    <div v-for="notification in notificaions" :key="notification.id" class="border-b last:border-0">
                        <div class="flex p-3 gap-3 cursor-pointer hover:bg-muted/50"
                            :class="{ 'bg-muted/20': !notification.read }"
                            @click="toggleNotificaionDetials(notification)">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                <ShoppingCartIcon v-if="!notification.type === 'stock_request'" class="h-5 w-5" />
                                <AlertCircleIcon v-else-if="notification.type === 'low_stock'" class="h-5 w-5" />
                                <InfoIcon v-else class="h-5 w-5" />
                            </div>

                            <div class="flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="text-sm font-medium">
                                        Stock Request: {{ notification.product.name }}
                                    </p>
                                    <p class="text-xs text-muted-foreground">{{ notification.createdAt }}</p>
                                </div>
                                <p class="text-xs text-muted-foreground mt-1">{{ notification.department }}
                                    requested {{ notification.requestedQuantity }}
                                </p>
                                <div>
                                    <Badge variant="outline">
                                        {{ notification.status }}
                                    </Badge>
                                </div>
                                <div v-if="notification.isRequestStatusPending" class="mt-2 flex gap-2">
                                    <Button size="sm" variant="outline" class="h-7 text-xs"
                                        @click.stop="approveStockRequest(notification)">
                                        Approve
                                    </Button>
                                    <Button size="sm" variant="outline" class="h-7 text-xs"
                                        @click.stop="rejectStockRequest(notification)">
                                        Reject
                                    </Button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <DialogFooter>
                <DialogClose>
                    <Button>
                        Close
                    </Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>


        <StockRequestDialog @update:open="stockRequestDetailsDialog.isOpen = $event"
            @acceptRequest="(stockRequest) => approveStockRequest(stockRequest)"
            @rejectRequest="(stockRequest) => rejectStockRequest(stockRequest)"
            :is-open="stockRequestDetailsDialog.isOpen" :stock-request="stockRequestDetailsDialog.notificaion" />
    </Dialog>

</template>

<script setup>
import { ref, computed, reactive, onMounted } from 'vue'
import Dialog from "@/components/ui/dialog/Dialog.vue"
import DialogContent from "@/components/ui/dialog/DialogContent.vue"
import DialogDescription from "@/components/ui/dialog/DialogDescription.vue"
import DialogFooter from "@/components/ui/dialog/DialogFooter.vue"
import DialogHeader from "@/components/ui/dialog/DialogHeader.vue"
import DialogTitle from "@/components/ui/dialog/DialogTitle.vue"
import { ShoppingCartIcon, AlertCircleIcon, InfoIcon, CheckCheck, Check, LogIn } from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import Skeleton from '@/components/ui/skeleton/Skeleton.vue'
import { router } from '@inertiajs/vue3';
import { toast } from '../ui/toast'
import Badge from '../ui/badge/Badge.vue'
import StockRequestDialog from './StockRequestDialog.vue'
import DialogClose from '../ui/dialog/DialogClose.vue'
const notificationFilter = ref('all');
const stockRequestDetailsDialog = ref({
    isOpen: false,
    notificaion: null,
});
const propsData = defineProps({
    notificaions: Array,
    isOpen: Boolean,
    isLoading: Boolean,
});
const isDialogOpened = computed(() => {
    return propsData.isOpen;
})

const approveStockRequest = (notificaion) => {
    router.post(route('approve.stock.request', { stock_request: notificaion.id }), {}, {
        onSuccess: () => {
            stockRequestDetailsDialog.value.isOpen = false;
            toast({
                title: 'Request has been apporved successfully.'
            });
        },
        onError: () => {
            toast({
                title: 'Something went wrong while trying to approve the request.'
            });
        }
    });
}
const rejectStockRequest = (notificaion) => {
    router.post(route('reject.stock.request', { stock_request: notificaion.id }), {}, {
        onSuccess: () => {
            stockRequestDetailsDialog.value.isOpen = false;
            toast({
                title: 'Request has been rejected  successfully.'
            });
        },
        onError: () => {
            toast({
                title: 'Something went wrong while trying to reject the request.'
            });
        }
    });
}

const toggleNotificaionDetials = (notificaion) => {
    stockRequestDetailsDialog.value.isOpen = true;
    stockRequestDetailsDialog.value.notificaion = notificaion
}

defineOptions({
    layout: AppLayout,
});
</script>