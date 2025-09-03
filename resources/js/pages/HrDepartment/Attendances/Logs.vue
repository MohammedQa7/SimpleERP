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
                                <Input placeholder="Search employee..." class="w-64" />
                            </div>
                            <div class="flex items-center space-x-2">
                                <Button variant="outline" size="sm">
                                    <Calendar class="mr-2 h-4 w-4" />
                                    Date Range
                                </Button>

                                <ExportOptions />
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
import { Calendar } from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import Toaster from '@/components/ui/toast/Toaster.vue'
import AttendanceLogs from '@/components/HrDep/Attendances/AttendanceLogs.vue'
import Input from '@/components/ui/input/Input.vue'
import { getCurrentDate } from '@/lib/todaysDate'
import ExportOptions from '@/components/ExportOptions.vue'
const propsData = defineProps({
    attendanceLogs: Array,
});


defineOptions({
    layout: AppLayout
})
</script>