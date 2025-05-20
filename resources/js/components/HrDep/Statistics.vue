<template>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">Total Employees</CardTitle>
                <Users class="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">{{ totalEmployees.count }}</div>
                <p class="text-xs text-muted-foreground">
                    {{ totalEmployees.percentage }}% from last month
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
</template>

<script setup>
import { BarChart, DollarSign, ShoppingCart, Users } from 'lucide-vue-next';
import Card from '../ui/card/Card.vue';
import CardHeader from '../ui/card/CardHeader.vue';
import CardTitle from '../ui/card/CardTitle.vue';
import CardContent from '../ui/card/CardContent.vue';

const propsData = defineProps({
    totalEmployees: Array,
});

</script>