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
                <table v-if="recentInvoice.data.length > 0" class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-border">
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Invoice ID</th>
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
                        <tr v-for="(invoice, index) in recentInvoice.data" :key="index"
                            class="border-b border-border hover:bg-muted/10">
                            <td class="py-3 px-4 text-sm font-medium">#{{ invoice.invoiceNumber }}</td>
                            <td class="py-3 px-4 text-sm">{{ invoice.order.orderNumber }}</td>
                            <td class="py-3 px-4 text-sm">{{ invoice.order.customer.fullName }}</td>
                            <td class="py-3 px-4 text-sm">{{ invoice.createdAt }}</td>
                            <td class="py-3 px-4 text-sm">${{ invoice.order.totalPrice }}</td>
                            <td class="py-3 px-4 text-sm">
                                <Badge variant="outline" :class="getStatusVariant(invoice.status)">{{ invoice.status }}
                                </Badge>
                            </td>
                            <td class="py-3 px-4 text-sm text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Button variant="outline" size="sm" @click="viewInvoice(invoice)">
                                        <Eye class="h-3.5 w-3.5 mr-1" />
                                        View
                                    </Button>
                                    <Button size="sm" :disabled="invoice.isSent">
                                        <Send class="h-3.5 w-3.5 mr-1" />
                                        <span v-if="invoice.isSent">Sent</span>
                                        <span v-else>Send</span>
                                    </Button>
                                    <Button @click.prevent="download(invoice.invoiceFile)" size="sm">
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
                    <h1 class="font-bold">No invoices were found</h1>
                </div>


            </div>
        </CardContent>
        <CardFooter v-if="recentInvoice.data.length > 0" class="flex items-center justify-between p-4">
            <div class="text-sm text-muted-foreground">
                Showing <strong>{{ recentInvoice.meta.from }}</strong> to <strong>{{
                    recentInvoice.meta.to }}</strong> of
                <strong>{{ recentInvoice.meta.total }}</strong> results
            </div>
            <div class="flex items-center space-x-2">
                <Link :href="recentInvoice.links.prev" preserve-scroll>
                <Button variant="outline" size="sm" :disabled="isNull(recentInvoice.links.prev)">Previous</Button>
                </Link>
                <Link :href="recentInvoice.links.next" preserve-scroll>
                <Button variant="outline" size="sm" :disabled="isNull(recentInvoice.links.next)">Next</Button>
                </Link>
            </div>
        </CardFooter>
    </Card>

    <InvoiceDetailsDialog v-if="showInvoiceDetails" :invoice="invoice" :is-loading="isLoading"
        :is-open="showInvoiceDetails" @update:open="showInvoiceDetails = $event" />
</template>

<script setup>
import { ref } from 'vue'
import Button from '@/components/ui/button/Button.vue'
import Badge from '../ui/badge/Badge.vue'
import { Download, Eye, FileText, FolderX, Loader2, Send } from 'lucide-vue-next';
import axios from 'axios';
import Avatar from '../ui/avatar/Avatar.vue';
import AvatarFallback from '../ui/avatar/AvatarFallback.vue';
import { getStatusVariant } from '@/composables/getStatusVariant';
import InvoiceDetailsDialog from './InvoiceDetailsDialog.vue';
import { isNull } from 'lodash';
import Card from '../ui/card/Card.vue';
import CardHeader from '../ui/card/CardHeader.vue';
import CardTitle from '../ui/card/CardTitle.vue';
import CardDescription from '../ui/card/CardDescription.vue';
import CardFooter from '../ui/card/CardFooter.vue';
const showInvoiceDetails = ref(false);
const isLoading = ref(false);
const invoice = ref(null);
const propsData = defineProps({
    recentInvoice: Array,
});

const viewInvoice = (selectedInvoice) => {
    isLoading.value = true;
    showInvoiceDetails.value = true;
    axios.get(route('invoices.show', { invoice: selectedInvoice.invoiceNumber }))
        .then((response) => {
            isLoading.value = false;
            invoice.value = response.data.invoice;
        })
        .catch((error) => {
            isLoading.value = false;
            showInvoiceDetails.value = !showInvoiceDetails.value;
        })
    isLoading.value = true;
    showInvoiceDetails.value = true;
}

const download = (invoiceFile) => {
    const url = route('download', { media: invoiceFile });
    window.location.href = url
}





</script>