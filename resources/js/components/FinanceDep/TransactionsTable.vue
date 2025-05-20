<template>
    <Card class="mt-8">
        <CardHeader class="flex flex-row items-center justify-between pb-2">
            <div class="space-y-1">
                <CardTitle>Recently Generated Invoices</CardTitle>
                <CardDescription>Invoices created from sales orders</CardDescription>
            </div>
        </CardHeader>
        <CardContent class="p-0">
            <div class="overflow-x-auto">

                <!-- Invoice table -->
                <table v-if="transactions.data.length > 0" class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-border">
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Payment NO</th>
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Invoice ID</th>
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Customer</th>
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Method</th>
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Amount</th>
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Paid at</th>
                            <th
                                class="text-right py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(transaction, index) in transactions.data" :key="index"
                            class="border-b border-border hover:bg-muted/10">
                            <td class="py-3 px-4 text-sm font-medium">{{ transaction.paymentNumber }}</td>
                            <td class="py-3 px-4 text-sm">#{{ transaction.invoice.order.orderNumber }}</td>
                            <td class="py-3 px-4 text-sm">{{ transaction.invoice.order.customer.fullName }}</td>
                            <td class="py-3 px-4 text-sm">
                                <Badge>
                                    {{ transaction.paymentMethod }}
                                </Badge>
                            </td>
                            <td class="py-3 px-4 text-sm">${{ transaction.invoice.order.totalPrice }}</td>
                            <td class="py-3 px-4 text-sm">{{ transaction.createdAt }}</td>
                            <td class="py-3 px-4 text-sm text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Button variant="outline" size="sm" @click="viewTransaction(transaction)">
                                        <Eye class="h-3.5 w-3.5 mr-1" />
                                        View
                                    </Button>
                                    <Button size="sm" :disabled="transaction.isSent">
                                        <Send class="h-3.5 w-3.5 mr-1" />
                                        <span v-if="transaction.isSent">Sent</span>
                                        <span v-else>Send</span>
                                    </Button>
                                    <Button @click.prevent="download(transaction.paymentNumber)" size="sm">
                                        <Download class="h-3.5 w-3.5 mr-1" />
                                        <span>Download</span>
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
                    <h1 class="font-bold">No payment transactions were found</h1>
                </div>


            </div>
        </CardContent>
        <CardFooter v-if="transactions.data.length > 0" class="flex items-center justify-between p-4">
            <div class="text-sm text-muted-foreground">
                Showing <strong>{{ transactions.meta.from }}</strong> to <strong>{{
                    transactions.meta.to }}</strong> of
                <strong>{{ transactions.meta.total }}</strong> results
            </div>
            <div class="flex items-center space-x-2">
                <Link :href="transactions.links.prev" preserve-scroll>
                <Button variant="outline" size="sm" :disabled="isNull(transactions.links.prev)">Previous</Button>
                </Link>
                <Link :href="transactions.links.next" preserve-scroll>
                <Button variant="outline" size="sm" :disabled="isNull(transactions.links.next)">Next</Button>
                </Link>
            </div>
        </CardFooter>
    </Card>

    <TransactionDetailsDialog v-if="showTransactionDetails" :transaction="transaction" :is-loading="isLoading"
        :is-open="showTransactionDetails" @update:open="showTransactionDetails = $event;console.log('close')" />
</template>

<script setup>
import { ref } from 'vue'
import Button from '@/components/ui/button/Button.vue'
import Badge from '@/components/ui/badge/Badge.vue'
import { Download, Eye, FolderX, LogIn, Send } from 'lucide-vue-next';
import axios from 'axios';
import Avatar from '@/components/ui/avatar/Avatar.vue';
import AvatarFallback from '@/components/ui/avatar/AvatarFallback.vue';
import { isNull } from 'lodash';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import TransactionDetailsDialog from './TransactionDetailsDialog.vue';
const showTransactionDetails = ref(false);
const isLoading = ref(false);
const transaction = ref(null);
const propsData = defineProps({
    transactions: Array,
});

const viewTransaction = (selectedTransaction) => {
    isLoading.value = true;
    showTransactionDetails.value = true;
    axios.get(route('payments.show', { transaction: selectedTransaction.paymentNumber }))
        .then((response) => {
            isLoading.value = false;
            transaction.value = response.data.transaction;

        })
        .catch((error) => {
            isLoading.value = false;
            showTransactionDetails.value = !showTransactionDetails.value;
        })
    isLoading.value = true;
    showTransactionDetails.value = true;
}

const download = (invoiceNumber) => {
    const url = route('download', { invoice: invoiceNumber });
    window.location.href = url
}





</script>