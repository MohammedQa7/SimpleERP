<template>
    <table v-if="approvedOrders.length > 0" class="w-full border-collapse">
        <thead>
            <tr class="border-b border-border">
                <th class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                    Order ID</th>
                <th class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                    Customer</th>
                <th class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                    Date</th>
                <th class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                    Amount</th>
                <th class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                    Status</th>
                <th class="text-right py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                    Actions</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(order, index) in approvedOrders" :key="index" class="border-b border-border hover:bg-muted/10">
                <td class="py-3 px-4 text-sm font-medium">#{{ order.orderNumber }}</td>
                <td class="py-3 px-4 text-sm">{{ order.customer.fullName }}</td>
                <td class="py-3 px-4 text-sm">{{ order.createdAt }}</td>
                <td class="py-3 px-4 text-sm">${{ order.totalPrice }}</td>
                <td class="py-3 px-4 text-sm">
                    <Badge variant="success">{{ order.status }}</Badge>
                </td>
                <td class="py-3 px-4 text-sm text-right">
                    <div class="flex items-center justify-end gap-2">
                        <Button variant="outline" size="sm" @click="viewOrder(order)">
                            <Eye class="h-3.5 w-3.5 mr-1" />
                            View
                        </Button>
                        <Button size="sm" @click="generateInvoice(order)">
                            <FileText class="h-3.5 w-3.5 mr-1" />
                            Generate Invoice
                        </Button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Not found -->
    <div v-else class="w-full flex-col flex items-center justify-center my-10">
        <Avatar class="p-7">
            <AvatarFallback>
                <FolderX size="28" />
            </AvatarFallback>
        </Avatar>
        <h1 class="font-bold">No orders were found</h1>
    </div>

    <OrderDetailsDialog v-if="showOrderDetails" :order="order" :is-loading="isLoading" :is-open="showOrderDetails"
        @update:open="showOrderDetails = $event" />
</template>

<script setup>
import { ref } from 'vue'
import Button from '@/components/ui/button/Button.vue'
import Badge from '../ui/badge/Badge.vue'
import { Eye, FileText, FolderX } from 'lucide-vue-next';
import OrderDetailsDialog from './OrderDetailsDialog.vue';
import axios from 'axios';
import Avatar from '../ui/avatar/Avatar.vue';
import AvatarFallback from '../ui/avatar/AvatarFallback.vue';
const showOrderDetails = ref(false);
const isLoading = ref(false);

const order = ref(null);
const propsData = defineProps({
    approvedOrders: Array,
});


const viewOrder = (selectedOrder) => {
    isLoading.value = true;
    showOrderDetails.value = true;
    axios.get(route('orders.show', { order: selectedOrder.orderNumber }))
        .then((response) => {
            isLoading.value = false;
            order.value = response.data.order;
        })
        .catch((error) => {
            isLoading.value = !isLoading;
            showOrderDetails.value = !showOrderDetails.value;
        })
    isLoading.value = true;
    showOrderDetails.value = true;
}



</script>