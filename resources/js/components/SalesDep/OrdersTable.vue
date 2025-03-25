<template>
    <Card>
        <CardContent class="p-0">
            <!-- Table Header -->
            <div class="grid grid-cols-6 gap-4 border-b p-4 font-medium text-muted-foreground">
                <div>Order ID</div>
                <div>Customer</div>
                <div>Status</div>
                <div>Date</div>
                <div>Amount</div>
                <div>Actions</div>
            </div>

            <!-- Table Body -->
            <div class="divide-y">
                <div v-for="order in orders.data" :key="order.id"
                    class="grid grid-cols-6 gap-4 p-4 items-center hover:bg-muted/50">
                    <div>{{ order.orderNumber }}</div>
                    <div>{{ order.customer.fullName }}</div>
                    <div>
                        <Badge :variant="order.status === orderStatus['APPROVED'] ? 'default' :
                            order.status === orderStatus['WAITING_FOR_RESTOCK'] ? 'secondary' :
                                order.status === orderStatus['CANCELED'] ? 'destructive' :
                                    'outline'
                            ">
                            {{ order.status }}
                        </Badge>
                    </div>
                    <div>{{ order.createdAt }}</div>
                    <div>${{ order.totalPrice }}</div>
                    <div class="flex space-x-2">
                        <Button @click.prevent="toggleOrderDialog(true, order.orderNumber)" variant="outline"
                            size="icon">
                            <Edit class="h-4 w-4" />
                            <span class="sr-only">Edit</span>
                        </Button>
                        <Button variant="outline" size="icon">
                            <Trash class="h-4 w-4" />
                            <span class="sr-only">Delete</span>
                        </Button>
                    </div>
                </div>
            </div>
        </CardContent>
        <CardFooter class="flex items-center justify-between p-4">
            <div class="text-sm text-muted-foreground">
                Showing <strong>{{ orders.meta.from }}</strong> to <strong>{{ orders.meta.to }}</strong> of <strong>{{
                    orders.meta.total
                }}</strong> results
            </div>
            <div class="flex items-center space-x-2">
                <Link :href="orders.links.prev" preserve-scroll>
                <Button variant="outline" size="sm" :disabled="isNull(orders.links.prev)">Previous</Button>
                </Link>
                <Link :href="orders.links.next" preserve-scroll>
                <Button variant="outline" size="sm" :disabled="isNull(orders.links.next)">Next</Button>
                </Link>
            </div>
        </CardFooter>
    </Card>

    <EditOrderDialog v-if="editOrderDialog" :is-open="editOrderDialog" :is-loading="isLoading" :customers="customers"
        :products="products" :order="order" :order-status="orderStatus" @Close="toggleOrderDialog" />
</template>

<script setup>
import { ref } from 'vue'
import { Trash, Edit } from 'lucide-vue-next'
import Card from '@/components/ui/card/Card.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import Button from '@/components/ui/button/Button.vue'
import Badge from '../ui/badge/Badge.vue'
import EditOrderDialog from './EditOrderDialog.vue'
import { router, Link } from '@inertiajs/vue3'
import { isNull } from 'lodash';
import axios from 'axios'
const editOrderDialog = ref(false);
const isLoading = ref(false);
const customers = ref([]);
const products = ref([]);
const order = ref(null);
const propsData = defineProps({
    orders: Array,
    orderStatus: Array,
});



const toggleOrderDialog = (eventData = true, orderNumber) => {

    if (eventData) {
        isLoading.value = true;
        editOrderDialog.value = !editOrderDialog.value;
        router.visit(route('orders.edit', { order: orderNumber }), {
            only: ['order', 'customers', 'products'],
            preserveScroll: true,
            preserveState: true,
            preserveUrl: true,
            onSuccess: (page) => {
                isLoading.value = false;
                customers.value = page.props.customers;
                products.value = page.props.products;
                order.value = page.props.order;
            },
            onError: () => {
                isLoading.value = false;
            }
        });

    } else {
        // Close the dialog (this event data is coming the defineEmit in the composable closeDialog.js file)
        editOrderDialog.value = eventData;
    }
}



</script>