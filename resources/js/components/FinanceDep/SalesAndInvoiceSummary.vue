<template>
    <Card v-for="(sale, key) in salesSummary" :key="key">
        <CardContent class="p-6">
            <div class="flex items-center justify-between space-x-4">
                <div class="flex flex-col space-y-1">
                    <span class="text-sm font-medium text-muted-foreground">{{ sale.title }}</span>
                    <span class="text-2xl font-bold">${{ sale.value }}</span>
                </div>
                <div :class="`p-2 rounded-full bg-${sale.color}-900/30`">
                    <component :is="LucideIcons[sale.icon]" :class="`text-${sale.color}-600`" />
                </div>

            </div>
            <div class="flex items-center pt-4 text-sm">
                <div :class="sale.percentage > 0 ? 'text-emerald-500' : sale.percentage == 0 ? 'text-primary' : ' text-rose-500'"
                    class="flex items-center">
                    <component
                        :is="sale.percentage > 0 ? LucideIcons.TrendingUp : sale.percentage == 0 ? LucideIcons.MoveRight : LucideIcons.TrendingDown"
                        class="mr-1 h-3 w-3" />
                    {{ sale.percentage }}%
                </div>
                <span class="text-muted-foreground ml-2">from last month</span>
            </div>
        </CardContent>
    </Card>
    <Card v-for="(invoice, key) in invoiceSummary" :key="key">
        <CardContent class="p-6">
            <div class="flex items-center justify-between space-x-4">
                <div class="flex flex-col space-y-1">
                    <span class="text-sm font-medium text-muted-foreground">{{ invoice.title }}</span>
                    <span class="text-2xl font-bold">{{ invoice.value
                    }}</span>
                </div>

                <div :class="`p-2 rounded-full bg-${invoice.color}-900/30`">
                    <component :is="LucideIcons[invoice.icon]" :class="`text-${invoice.color}-600`" />
                </div>
            </div>
            <div class="flex items-center pt-4 text-sm">
                <div :class="invoice.percentage > 0 ? 'text-emerald-500' : invoice.percentage == 0 ? 'text-primary' : ' text-rose-500'"
                    class="flex items-center">
                    <component
                        :is="invoice.percentage > 0 ? LucideIcons.TrendingUp : invoice.percentage == 0 ? LucideIcons.MoveRight : LucideIcons.TrendingDown"
                        class="mr-1 h-3 w-3" />
                    {{ invoice.percentage }}%
                </div>
                <span class="text-muted-foreground ml-2">from last month</span>
            </div>
        </CardContent>
    </Card>


</template>

<script setup>
import { resolveComponent } from 'vue';
import Card from '../ui/card/Card.vue';
import CardContent from '../ui/card/CardContent.vue';
import * as LucideIcons from 'lucide-vue-next';
const propsData = defineProps({
    salesSummary: Array,
    invoiceSummary: Array,
});

console.log(propsData.summary);

</script>