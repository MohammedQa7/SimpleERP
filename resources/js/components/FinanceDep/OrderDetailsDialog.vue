<template>
    <Dialog :open="isDialogOpened" @update:open="isDialogOpened = $event">
        <DialogContent class="sm:max-w-4xl">
            <DialogHeader>
                <DialogTitle>Order Details</DialogTitle>
                <DialogDescription>Order #{{ order?.orderNumber || '' }}</DialogDescription>
            </DialogHeader>

            <!-- Loading skelaton -->
            <InvoiceSkelaton v-if="isLoading" />

            <!-- Dialog main content -->
            <div v-else class="grid grid-cols-1 gap-4 py-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-muted-foreground mb-1">Customer</h3>
                        <p class="text-sm font-medium">{{ order.customer.fullName }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-muted-foreground mb-1">Order Date</h3>
                        <p class="text-sm font-medium">{{ order.createdAt }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-muted-foreground mb-1">Approval Date</h3>
                        <p class="text-sm font-medium">{{ order.approvedAt }}</p>
                    </div>
                </div>

                <Separator />

                <div>
                    <h3 class="text-sm font-medium mb-2">Order Items</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b border-border">
                                    <th
                                        class="text-left py-2 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                        Item</th>
                                    <th
                                        class="text-left py-2 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                        Description</th>
                                    <th
                                        class="text-right py-2 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                        Quantity</th>
                                    <th
                                        class="text-right py-2 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                        Unit Price</th>
                                    <th
                                        class="text-right py-2 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in order.orderItems" :key="index"
                                    class="border-b border-border">
                                    <td class="py-2 px-4 text-sm">{{ item.product.name }}</td>
                                    <td class="py-2 px-4 text-sm">{{ item.product.description }}</td>
                                    <td class="py-2 px-4 text-sm text-right">{{ item.quantity }}</td>
                                    <td class="py-2 px-4 text-sm text-right">${{ item.product.sellingPrice }}</td>
                                    <td class="py-2 px-4 text-sm text-right">${{ item.totalAmount }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="py-2 px-4"></td>
                                    <td class="py-2 px-4 text-sm font-medium text-right">Subtotal</td>
                                    <td class="py-2 px-4 text-sm font-bold text-right">${{ order.totalPrice }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="py-2 px-4"></td>
                                    <td class="py-2 px-4 text-sm font-bold text-right">Total</td>
                                    <td class="py-2 px-4 text-sm font-bold text-right">${{ order.totalPrice }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-muted-foreground mb-1">Notes</h3>
                    <p class="text-sm">{{ order.notes }}</p>
                </div>

                <DialogFooter>
                    <DialogClose>
                        <Button variant="outline">Close</Button>
                    </DialogClose>
                    <Button @click="generateInvoice(order)">Generate Invoice</Button>
                </DialogFooter>
            </div>

        </DialogContent>
    </Dialog>
</template>

<script setup>
import { computed } from 'vue';
import Dialog from '../ui/dialog/Dialog.vue';
import DialogContent from '../ui/dialog/DialogContent.vue';
import InvoiceSkelaton from './InvoiceSkelaton.vue';
import DialogTitle from '../ui/dialog/DialogTitle.vue';
import DialogDescription from '../ui/dialog/DialogDescription.vue';
import DialogFooter from '../ui/dialog/DialogFooter.vue';
import Button from '../ui/button/Button.vue';
import Separator from '../ui/separator/Separator.vue';
import DialogClose from '../ui/dialog/DialogClose.vue';
const propsData = defineProps({
    order: Object,
    isOpen: Boolean,
    isLoading: Boolean,
})
const isDialogOpened = computed(() => {
    return propsData.isOpen;
})


</script>