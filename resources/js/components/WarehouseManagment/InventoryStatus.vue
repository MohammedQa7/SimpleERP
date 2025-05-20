<template>
    <div class="mb-6 grid gap-4 md:grid-cols-4">
        <Card>
            <CardHeader class="pb-2">
                <CardTitle class="text-sm font-medium text-muted-foreground">
                    Total Products
                </CardTitle>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">{{ productSummary.totalProducts.count }}</div>
                <p class="text-xs text-muted-foreground">
                    <span class="text-emerald-500">{{ productSummary.totalProducts.currentMonthCount }}+</span> new this
                    month
                </p>
            </CardContent>
        </Card>
        <Card>
            <CardHeader class="pb-2">
                <CardTitle class="text-sm font-medium text-muted-foreground">

                    Low Stock Items
                </CardTitle>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">{{ productSummary.lowStockItems.count }}</div>
                <p class="text-xs text-muted-foreground">
                    <span class="text-amber-500">{{ productSummary.lowStockItems.percentage }}%</span> of
                    inventory
                </p>
            </CardContent>
        </Card>
        <Card>
            <CardHeader class="pb-2">
                <CardTitle class="text-sm font-medium text-muted-foreground">
                    Out of Stock
                </CardTitle>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">{{ productSummary.outOfStockItems.count }}</div>
                <p class="text-xs text-muted-foreground">
                    <span class="text-red-500">{{ productSummary.outOfStockItems.percentage }}%</span> of
                    inventory
                </p>
            </CardContent>
        </Card>
        <Card>
            <CardHeader class="pb-2">
                <CardTitle class="text-sm font-medium text-muted-foreground">
                    Inventory Value
                </CardTitle>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">${{ productSummary.InventoryValue }}</div>
            </CardContent>
        </Card>
    </div>
</template>

<script setup>
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
const propsData = defineProps({
    productSummary: Object,
});
</script>