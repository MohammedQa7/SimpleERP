<template>
    <Toaster />
    <!-- Main Content -->
    <div class="container py-6">
        <div class="flex flex-col space-y-6">
            <!-- Dashboard Overview -->
            <div class="flex flex-col space-y-2">
                <h2 class="text-3xl font-bold tracking-tight">Attendance Logs</h2>
                <p class="text-muted-foreground">
                    Detailed history of all check-in and check-out activities
                </p>
            </div>
            <div class="w-full">
                <div class="space-y-4 mt-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium">{{ getCurrentDate() }} Attendance</h3>
                        <div class="flex items-center justify-between space-x-2">
                            <div class="flex items-center space-x-2">
                                <Input v-model="filtersQuery.search" placeholder="Search employee..." class="w-64" />
                            </div>
                            <div class="flex items-center space-x-2">

                                <!-- Attendance Date picker -->
                                <RangeDatePicker :startDate="filters.startDate" :endDate="filters.endDate"
                                    @bindDate="bindCalendarDate" />

                                <!-- Export Selection options -->
                                <ExportOptions :is-disabled="attendanceLogs.data.length <= 0" />
                            </div>
                        </div>
                    </div>
                    <!-- Attendance Logs Section -->
                    <AttendanceLogs :attendance-logs="attendanceLogs" />
                </div>

            </div>
        </div>
    </div>
</template>


<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import Toaster from '@/components/ui/toast/Toaster.vue'
import AttendanceLogs from '@/components/HrDep/Attendances/AttendanceLogs.vue'
import Input from '@/components/ui/input/Input.vue'
import { getCurrentDate } from '@/lib/todaysDate'
import ExportOptions from '@/components/ExportOptions.vue'
import RangeDatePicker from '@/components/RangeDatePicker.vue'
import { debounce } from 'lodash';
import { onMounted, ref, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3';
import { provideSSRWidth } from '@vueuse/core'
const page = usePage();
const propsData = defineProps({
    attendanceLogs: Array,
    filters: Array,
});
const filtersQuery = ref({
    search: '',
    startDate: null,
    endDate: null
});

const bindCalendarDate = (date) => {
    filtersQuery.value = { ...date };
};

const submitFilter = debounce(() => {
    router.get(route('attendances.logs.index', filtersQuery.value), {}, {
        preserveScroll: true,
        preserveState: true
    });
}, 500)


watch(filtersQuery, () => {
    submitFilter();
}, { deep: true })

onMounted(() => {

    if (propsData.filters) {
        filtersQuery.value = { ...propsData.filters };
    }
});

defineOptions({
    layout: AppLayout
})
</script>