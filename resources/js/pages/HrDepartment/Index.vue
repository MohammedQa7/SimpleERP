<template>
    <div class="space-y-5">
        <Statistics :total-employees="totalEmployees" />
        <!-- Charts Row -->
        <ChartStatistics />


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
    totalEmployees: Array,
    upcomingEvents: Object,
});



defineOptions({
    layout: AppLayout
})
</script>