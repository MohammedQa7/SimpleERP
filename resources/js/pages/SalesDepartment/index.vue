<template>
    <Toaster />
    <!-- Main Content -->
    <div class="container py-6">
        <div class="flex flex-col space-y-6">
            <!-- Dashboard Overview -->
            <div class="flex flex-col space-y-2">
                <h2 class="text-3xl font-bold tracking-tight">Sales Dashboard</h2>
                <p class="text-muted-foreground">
                    Manage your sales and orders
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Total Revenue</CardTitle>
                        <DollarSign class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">$45,231.89</div>
                        <p class="text-xs text-muted-foreground">
                            +20.1% from last month
                        </p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">New Orders</CardTitle>
                        <ShoppingCart class="h-4 w-4 text-muted-foreground" />

                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">+12,234</div>
                        <p class="text-xs text-muted-foreground">
                            +19% from last month
                        </p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Sales Conversion</CardTitle>
                        <BarChart class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">24.5%</div>
                        <p class="text-xs text-muted-foreground">
                            +5.2% from last month
                        </p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Active Customers</CardTitle>
                        <Users class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">573</div>
                        <p class="text-xs text-muted-foreground">
                            +201 since last week
                        </p>
                    </CardContent>
                </Card>
            </div>

            <!-- Tabs -->
            <div class="w-full">
                <div class="border-b">
                    <div class="flex h-10 items-center space-x-4 text-sm">
                        <button
                            :class="activeTab === 'orders' ? 'border-b-2 border-primary font-medium text-foreground' : 'text-muted-foreground'"
                            @click="activeTab = 'orders'" class="px-4">
                            Orders
                        </button>
                    </div>
                </div>

                <!-- Orders Tab -->
                <div v-if="activeTab === 'orders'" class="space-y-4 mt-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium">Recent Orders</h3>
                        <div class="flex items-center space-x-2">
                            <Button variant="outline">
                                <Filter class="mr-2 h-4 w-4" />
                                Filter
                            </Button>

                            <!-- Order Dialog -->
                            <CreateOrderDialog />
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <OrdersTable :orders="orders" :order-status="orderStatus" />
                </div>

            </div>
        </div>
    </div>


</template>


<script setup>
import { ref } from 'vue'
import { DollarSign, ShoppingCart, BarChart, Users, Filter, } from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import Card from '@/components/ui/card/Card.vue'
import CardHeader from '@/components/ui/card/CardHeader.vue'
import CardTitle from '@/components/ui/card/CardTitle.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import Button from '@/components/ui/button/Button.vue'
import OrdersTable from '@/components/SalesDep/OrdersTable.vue'
import CreateOrderDialog from '@/components/SalesDep/CreateOrderDialog.vue'
import Toaster from '@/components/ui/toast/Toaster.vue'
const activeTab = ref('orders');
const propsData = defineProps({
    orders: Array,
    orderStatus: Array,
});


defineOptions({
    layout: AppLayout
})
</script>