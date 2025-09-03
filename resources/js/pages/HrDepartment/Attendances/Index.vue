<template>
    <Toaster />
    <!-- Main Content -->
    <div class="container py-6">
        <div class="flex flex-col space-y-6">
            <!-- Dashboard Overview -->
            <div class="flex flex-col space-y-2">
                <h2 class="text-3xl font-bold tracking-tight"> Attendance Dashboard</h2>
                <p class="text-muted-foreground">
                    Track and manage employee attendance
                </p>
            </div>

            <div class="w-full">
                <div class="space-y-4 mt-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium">Sep 1, 2025 Attendance</h3>
                        <div class="flex items-center space-x-2">
                            <Button variant="outline">
                                <Filter class="mr-2 h-4 w-4" />
                                Filter
                            </Button>

                            <Link :href="route('attendances.logs.index')">
                            <Button>
                                <Eye class="mr-2 h-4 w-4" />
                                View Attendance Logs
                            </Button>
                            </Link>
                        </div>
                    </div>

                    <!-- Attendance Table -->
                    <AttendanceTable :attendances="attendances" />
                </div>

            </div>
        </div>
    </div>


</template>


<script setup>
import { DollarSign, ShoppingCart, BarChart, Users, Filter, Eye, } from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import Card from '@/components/ui/card/Card.vue'
import CardHeader from '@/components/ui/card/CardHeader.vue'
import CardTitle from '@/components/ui/card/CardTitle.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import Button from '@/components/ui/button/Button.vue'
import Toaster from '@/components/ui/toast/Toaster.vue'
import AttendanceTable from '@/components/HrDep/Attendances/AttendanceTable.vue'
const propsData = defineProps({
    attendances: Array,
});


defineOptions({
    layout: AppLayout
})
</script>