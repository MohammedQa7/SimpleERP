<template>

    <!-- Employee View -->
    <div class="container mx-auto">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Welcome Section -->
                <div
                    class="rounded-lg border bg-card text-card-foreground shadow-sm border-primary/20 bg-gradient-to-r from-primary/5 to-secondary/5">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <div class="flex items-center gap-3">
                            <User class="h-6 w-6 text-primary" />
                            <div>
                                <h3 class="text-2xl font-semibold leading-none tracking-tight text-balance">Welcome
                                    to Your HR Portal</h3>
                                <p class="text-sm text-muted-foreground">
                                    Easily submit vacation requests, day-off applications, and urgent situation
                                    reports
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Request Types -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-balance">What would you like to request?</h2>
                    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
                        <div v-for="request, key in requestTypes" :key="key"
                            @click.prevent="toggleFormRequestDialog(request.title)" :class="[
                                'rounded-lg  bg-card text-card-foreground shadow-sm cursor-pointer transition-all hover:shadow-md hover:scale-[1.02] border-2',
                                getLeaveRequestTypeClass(request.title)
                            ]">
                            <div class="flex flex-col justify-between space-y-1.5 p-6 pb-3">
                                <div class="flex items-start gap-3">
                                    <div class="space-y-1">
                                        <h3 class="text-base font-semibold leading-none tracking-tight text-balance">
                                            {{ request.title }}</h3>
                                        <p class="text-sm text-muted-foreground ">{{ request.description }}</p>
                                    </div>
                                </div>

                                <div>
                                    <h1>Submit Request →</h1>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Tips -->
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3
                            class="flex items-center gap-2 text-2xl font-semibold leading-none tracking-tight text-balance">
                            <FileText class="h-5 w-5" />
                            Quick Tips
                        </h3>
                    </div>
                    <div class="p-6 pt-0 space-y-3">
                        <div class="grid md:grid-cols-2 gap-4 text-sm">
                            <div class="space-y-2">
                                <h4 class="font-medium">Before Submitting:</h4>
                                <ul class="space-y-1 text-muted-foreground ">
                                    <li>• Check your remaining vacation days</li>
                                    <li>• Ensure adequate coverage for your role</li>
                                    <li>• Submit requests as early as possible</li>
                                </ul>
                            </div>
                            <div class="space-y-2">
                                <h4 class="font-medium">Response Times:</h4>
                                <ul class="space-y-1 text-muted-foreground ">
                                    <li>• Vacation requests: 3-5 business days</li>
                                    <li>• Day-off requests: 1-2 business days</li>
                                    <li>• Urgent requests: Same day response</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Recent Requests -->
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="text-lg font-semibold leading-none tracking-tight text-balance">Your Recent
                            Requests</h3>
                        <p class="text-sm text-muted-foreground">Track your submitted requests</p>
                    </div>
                    <div class="p-6 pt-0 space-y-3">
                        <div v-if="employeeRequests.data.length > 0" class="space-y-3">
                            <div v-for="request in employeeRequests.data" :key="request.id"
                                class="flex items-center justify-between p-3 rounded-lg border bg-card/50">
                                <div class="space-y-1">
                                    <p class="font-medium text-sm ">{{ request.title }}</p>
                                    <p class="font-medium text-xs text-balance">{{ request.employeeRequest.type }}
                                        Request</p>
                                    <p class="text-xs text-muted-foreground">
                                        From: {{ request.employeeRequest.startDate }}
                                    </p>
                                    <p class="text-xs text-muted-foreground">
                                        To: {{ request.employeeRequest.endDate }}
                                    </p>
                                </div>
                                <Badge :class="getLeaveRequestStatusClass(request.status)">
                                    <CheckCircle v-if="request.status === 'approved'" class="h-3 w-3 mr-1" />
                                    {{ request.status }}
                                </Badge>

                            </div>
                        </div>
                        <p v-else class="text-sm text-muted-foreground text-center py-4 ">
                            No requests submitted yet
                        </p>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="text-lg font-semibold leading-none tracking-tight text-balance">Need Help?</h3>
                    </div>
                    <div class="p-6 pt-0 space-y-3 text-sm">
                        <div>
                            <p class="font-medium">HR Department</p>
                            <p class="text-muted-foreground">hr@company.com</p>
                            <p class="text-muted-foreground">Ext. 1234</p>
                        </div>
                        <div>
                            <p class="font-medium">Office Hours</p>
                            <p class="text-muted-foreground ">
                                Monday - Friday<br />
                                9:00 AM - 5:00 PM
                                {{ leaveTypes }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Form Modal -->
    <LeaveFormRequest :is-open="formRequestDialog.isOpen" :type="formRequestDialog.type" :priority="priority"
        @update:open="formRequestDialog.isOpen = $event" />
</template>

<script setup>
import { ref, computed, defineComponent } from 'vue'
import { Calendar, Clock, AlertTriangle, FileText, CheckCircle, User, Building, Users } from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import Badge from '@/components/ui/badge/Badge.vue';
import LeaveFormRequest from '@/components/Employee/LeaveFormRequest.vue';
import { getLeaveRequestTypeClass } from '@/composables/useLeaveRequestTypeClass';
import { getLeaveRequestStatusClass } from '@/composables/useLeaveRequestStatusClass';
const formRequestDialog = ref({
    type: null,
    isOpen: false,
});
const propsData = defineProps({
    employeeRequests: Object,
    requestTypes: Array,
    priority: Array,
});

const toggleFormRequestDialog = (type) => {
    formRequestDialog.value.isOpen = true;
    formRequestDialog.value.type = type.toLowerCase();

}


defineOptions({
    layout: AppLayout,
});
</script>
