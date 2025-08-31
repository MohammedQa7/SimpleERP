<template>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <Card>
            <CardHeader>
                <CardTitle>Employee Distribution</CardTitle>
                <CardDescription>Department-wise employee distribution</CardDescription>
            </CardHeader>
            <CardContent>
                <BarChart class="p-6" index="department" :data="departmentEmployeesCount" :categories="['count']" :y-formatter="(tick, i) => {
                    return typeof tick === 'number'
                        ? tick.toLocaleString()
                        : ''
                }" :rounded-corners="4" />
            </CardContent>
        </Card>
        <Card>
            <CardHeader>
                <CardTitle>Attendance Trends</CardTitle>
                <CardDescription>Monthly attendance statistics</CardDescription>
            </CardHeader>
            <CardContent>
                <div class="h-80 flex items-center justify-center">
                    <!-- Placeholder for chart -->
                    <div class="w-full h-full flex items-center justify-center bg-muted/20 rounded-md">
                        <div class="text-center">
                            <LineChart class="h-12 w-12 mx-auto text-muted-foreground" />
                            <p class="mt-2 text-sm text-muted-foreground">Attendance Trend Chart</p>
                        </div>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>


<script setup>
import { LineChart, PieChart } from 'lucide-vue-next';
import Card from '../ui/card/Card.vue';
import CardDescription from '../ui/card/CardDescription.vue';
import CardHeader from '../ui/card/CardHeader.vue';
import CardTitle from '../ui/card/CardTitle.vue';
import BarChart from '../ui/chart-bar/BarChart.vue';
const data = [
    { name: 'Jan', total: Math.floor(Math.random() * 2000) + 500, predicted: Math.floor(Math.random() * 2000) + 500 },
    { name: 'Feb', total: Math.floor(Math.random() * 2000) + 500, predicted: Math.floor(Math.random() * 2000) + 500 },
    { name: 'Mar', total: Math.floor(Math.random() * 2000) + 500, predicted: Math.floor(Math.random() * 2000) + 500 },
    { name: 'Apr', total: Math.floor(Math.random() * 2000) + 500, predicted: Math.floor(Math.random() * 2000) + 500 },
    { name: 'May', total: Math.floor(Math.random() * 2000) + 500, predicted: Math.floor(Math.random() * 2000) + 500 },
    { name: 'Jun', total: Math.floor(Math.random() * 2000) + 500, predicted: Math.floor(Math.random() * 2000) + 500 },
    { name: 'Jul', total: Math.floor(Math.random() * 2000) + 500, predicted: Math.floor(Math.random() * 2000) + 500 },
]
const propsData = defineProps({
    departmentEmployeesCount: Array,
});

</script>