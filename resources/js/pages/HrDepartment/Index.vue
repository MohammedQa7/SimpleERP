<template>
    <div class="space-y-5">
        <!-- Statistics cards -->
        <Statistics :total-employees="totalEmployees" />


        <!-- Charts Row -->
        <ChartStatistics :department-employees-count="departmentEmployeesCount" />


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Recent Activities -->
            <RecentActivites />
            <!-- Upcoming Events -->
            <UpcomingEvents :events="upcomingEvents" />
        </div>
    </div>
</template>

<script setup>
import ChartStatistics from '@/components/HrDep/ChartStatistics.vue';
import RecentActivites from '@/components/HrDep/RecentActivites.vue';
import Statistics from '@/components/HrDep/Statistics.vue';
import UpcomingEvents from '@/components/HrDep/UpcomingEvents.vue';
import AppLayout from '@/layouts/AppLayout.vue';
const propsData = defineProps({
    departmentEmployeesCount: Array,
    totalEmployees: Array,
    upcomingEvents: Object,
});



defineOptions({
    layout: AppLayout
})
</script>