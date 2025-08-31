<template>
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Dashboard</h1>
            <p class="text-muted-foreground">Financial overview and key metrics</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <SalesAndInvoiceSummary :sales-summary="salesSummary" :invoice-summary="invoiceSummary" />
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
        <Card>
            <CardHeader class="flex flex-row items-center justify-between pb-2">
                <div class="space-y-1">
                    <CardTitle>Revenue vs Expenses</CardTitle>
                    <CardDescription>Monthly comparison for the current year</CardDescription>
                </div>
            </CardHeader>
            <CardContent>
                <AreaChart :data="data" index="name" :categories="['revenue', 'expenses']" />

            </CardContent>
        </Card>
        <Card>
            <CardHeader class="flex flex-row items-center justify-between pb-2">
                <div class="space-y-1">
                    <CardTitle>Cash Flow</CardTitle>
                    <CardDescription>Daily cash flow for the current month</CardDescription>
                </div>
            </CardHeader>
            <CardContent>
                <AreaChart :data="dailyCashFlow" index="day" :categories="['cash']" />
            </CardContent>
        </Card>
    </div>

    <!-- Recent Invoices -->
    <Card>
        <CardHeader class="flex flex-row items-center justify-between pb-2">
            <div class="space-y-1">
                <CardTitle>Recent Invoices</CardTitle>
                <CardDescription>Latest invoices from your customers</CardDescription>
            </div>
            <Button variant="outline" size="sm" @click="activeTab = 'invoices'">
                View all
                <ChevronRight class="ml-1 h-4 w-4" />
            </Button>
        </CardHeader>
        <CardContent>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-border">
                            <th
                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Invoice</th>
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
                        </tr>
                    </thead>
                    <!-- <tbody>
                        <tr v-for="(invoice, index) in recentInvoices" :key="index"
                            class="border-b border-border hover:bg-muted/10">
                            <td class="py-3 px-4 text-sm font-medium">#{{ invoice.id }}</td>
                            <td class="py-3 px-4 text-sm">{{ invoice.customer }}</td>
                            <td class="py-3 px-4 text-sm">{{ invoice.date }}</td>
                            <td class="py-3 px-4 text-sm">${{ invoice.amount.toFixed(2) }}</td>
                            <td class="py-3 px-4 text-sm">
                                <Badge :variant="getStatusVariant(invoice.status)">
                                    {{ invoice.status }}
                                </Badge>
                            </td>
                        </tr>
                    </tbody> -->
                </table>
            </div>
        </CardContent>
    </Card>


</template>

<script setup>
import SalesAndInvoiceSummary from '@/components/FinanceDep/SalesAndInvoiceSummary.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import AreaChart from '@/components/ui/chart-area/AreaChart.vue';
import LineChart from '@/components/ui/chart-line/LineChart.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { ChevronRight, } from 'lucide-vue-next';
const propsData = defineProps({
    salesSummary: Array,
    invoiceSummary: Array,
    dailyCashFlow: Array,

});

const data = [
    { name: 'Jan', revenue: Math.floor(Math.random() * 5000) + 2000, expenses: Math.floor(Math.random() * 3000) + 1000 },
    { name: 'Feb', revenue: Math.floor(Math.random() * 5000) + 2000, expenses: Math.floor(Math.random() * 3000) + 1000 },
    { name: 'Mar', revenue: Math.floor(Math.random() * 5000) + 2000, expenses: Math.floor(Math.random() * 3000) + 1000 },
    { name: 'Apr', revenue: Math.floor(Math.random() * 5000) + 2000, expenses: Math.floor(Math.random() * 3000) + 1000 },
    { name: 'May', revenue: Math.floor(Math.random() * 5000) + 2000, expenses: Math.floor(Math.random() * 3000) + 1000 },
    { name: 'Jun', revenue: Math.floor(Math.random() * 5000) + 2000, expenses: Math.floor(Math.random() * 3000) + 1000 },
    { name: 'Jul', revenue: Math.floor(Math.random() * 5000) + 2000, expenses: Math.floor(Math.random() * 3000) + 1000 },
];

defineOptions({
    layout: AppLayout,
})
</script>