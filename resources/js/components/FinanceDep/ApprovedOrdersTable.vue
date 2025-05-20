<template>
    <Card>
        <CardHeader class="flex flex-row items-center justify-between pb-2">
            <div class="space-y-1">
                <CardTitle>Pending Invoice Generation</CardTitle>
                <CardDescription>Orders approved by sales department ready for invoicing</CardDescription>
            </div>
            <Badge variant="secondary" class="ml-auto"> Orders</Badge>
        </CardHeader>
        <CardContent class="p-0">
            <div class="overflow-x-auto">
                <!-- <ApprovedOrdersTable :approved-orders="approvedOrders.data" /> -->
                <table v-if="approvedOrders.data.length > 0" class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-border">
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Order ID</th>
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Customer</th>
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Date</th>
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Amount</th>
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Status</th>
                            <th
                                class="text-right py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(order, index) in approvedOrders.data" :key="index"
                            class="border-b border-border hover:bg-muted/10">
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
                                    <Button size="sm"
                                        @click="generateInvoice(order.orderNumber)"
                                        :disabled="isGeneratingInvoice.active">
                                        <Loader2 v-if="isGeneratingInvoice.active &&
                                            isGeneratingInvoice.orderNumber == order.orderNumber"
                                            class="animate-spin" />
                                        <FileText v-else class="h-3.5 w-3.5 mr-1" />
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

            </div>
        </CardContent>
        <CardFooter v-if="approvedOrders.data.length > 0" class="flex items-center justify-between p-4">
            <div class="text-sm text-muted-foreground">
                Showing <strong>{{ approvedOrders.meta.from }}</strong> to <strong>{{ approvedOrders.meta.to }}</strong>
                of
                <strong>{{ approvedOrders.meta.total }}</strong> results
            </div>
            <div class="flex items-center space-x-2">
                <Link :href="approvedOrders.links.prev" preserve-scroll>
                <Button variant="outline" size="sm" :disabled="isNull(approvedOrders.links.prev)">Previous</Button>
                </Link>
                <Link :href="approvedOrders.links.next" preserve-scroll>
                <Button variant="outline" size="sm" :disabled="isNull(approvedOrders.links.next)">Next</Button>
                </Link>
            </div>
        </CardFooter>
    </Card>
    <OrderDetailsDialog v-if="showOrderDetails" :order="order" :is-loading="isLoading" :is-open="showOrderDetails"
        @update:open="showOrderDetails = $event" />
</template>

<script setup>
import { ref } from 'vue'
import Button from '@/components/ui/button/Button.vue'
import Badge from '../ui/badge/Badge.vue'
import { Eye, FileText, FolderX, Loader2 } from 'lucide-vue-next';
import OrderDetailsDialog from './OrderDetailsDialog.vue';
import axios from 'axios';
import Avatar from '../ui/avatar/Avatar.vue';
import AvatarFallback from '../ui/avatar/AvatarFallback.vue';
import Card from '../ui/card/Card.vue';
import CardHeader from '../ui/card/CardHeader.vue';
import CardContent from '../ui/card/CardContent.vue';
import { router } from '@inertiajs/vue3';
import { toast } from '../ui/toast';
import { isNull } from 'lodash';
import CardTitle from '../ui/card/CardTitle.vue';
import CardDescription from '../ui/card/CardDescription.vue';
const showOrderDetails = ref(false);
const isLoading = ref(false);
const isGeneratingInvoice = ref({
    active: false,
    orderNumber: null
});

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
            isLoading.value = false;
            showOrderDetails.value = !showOrderDetails.value;
        })
    isLoading.value = true;
    showOrderDetails.value = true;
}

const generateInvoice = (orderNumber) => {
    isGeneratingInvoice.value.active = true;
    isGeneratingInvoice.value.orderNumber = orderNumber;
    router.post(route('invoices.store'), { orderNumber: orderNumber }, {
        onSuccess: () => {
            isGeneratingInvoice.value.active = false;
            isGeneratingInvoice.value.orderNumber = null;
            toast({
                title: 'Invoice has been generated',
            });
        },
        onError: () => {
            isGeneratingInvoice.value.active = false;
            isGeneratingInvoice.value.orderNumber = null;
            toast({
                title: 'Something went wrong while generating invoice',
            })
        },
    })
}




</script>