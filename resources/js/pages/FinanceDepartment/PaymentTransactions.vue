<template>
    <Toaster />
    <div>
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Paid Invoices</h1>
                <p class="text-muted-foreground">Track payment transactions</p>
            </div>
        </div>

        <!-- Filters -->
        <Card class="mb-6">
            <CardContent class="p-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <Input v-model="filters.search" placeholder="Search orders..." class="pl-9" />
                        <Search class="absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" />
                    </div>
                    <Select v-model="filters.date" >
                        <SelectTrigger class="w-full md:w-[180px]">
                            <SelectValue placeholder="Date Range" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">All Time</SelectItem>
                            <SelectItem value="today">Today</SelectItem>
                            <SelectItem value="week">This Week</SelectItem>
                            <SelectItem value="month">This Month</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </CardContent>
        </Card>

        <!-- Paid Invoice -->
        <div>
            <!-- Transactions table -->
            <TransactionsTable :transactions="paymentTransactions" />
        </div>

    </div>

</template>

<script setup>
import { ref, computed } from 'vue'
import { Search } from 'lucide-vue-next'

// Import shadcn-vue components
import Card from '@/components/ui/card/Card.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import Select from '@/components/ui/select/Select.vue'
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue'
import SelectValue from '@/components/ui/select/SelectValue.vue'
import SelectContent from '@/components/ui/select/SelectContent.vue'
import SelectItem from '@/components/ui/select/SelectItem.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import Input from '@/components/ui/input/Input.vue'
import Toaster from '@/components/ui/toast/Toaster.vue'
import TransactionsTable from '@/components/FinanceDep/TransactionsTable.vue'
const filters = ref({
    search: '',
    date: 'all',
});
const propsData = defineProps({
    paymentTransactions: Array,
});


defineOptions({
    layout: AppLayout,
});
</script>