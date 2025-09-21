<template>
    <div class="container mx-auto px-4 py-8">
        <div class="space-y-6 lg:space-y-8">
            <!-- Header Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-4 sm:p-6 pb-3">
                        <h3 class="text-xs sm:text-sm font-medium text-muted-foreground">Total Requests</h3>
                        <!-- <div class="text-xl sm:text-2xl font-bold">{{ requests.length }}</div> -->
                    </div>
                </div>
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-4 sm:p-6 pb-3">
                        <h3 class="text-xs sm:text-sm font-medium text-muted-foreground">Pending</h3>
                        <div class="text-xl sm:text-2xl font-bold text-yellow-600">{{ pendingCount }}</div>
                    </div>
                </div>
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-4 sm:p-6 pb-3">
                        <h3 class="text-xs sm:text-sm font-medium text-muted-foreground">Pending</h3>
                        <div class="text-xl sm:text-2xl font-bold text-green-600">{{ approvedCount }}</div>
                    </div>
                </div>
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-4 sm:p-6 pb-3">
                        <h3 class="text-xs sm:text-sm font-medium text-muted-foreground">Rejected</h3>
                        <div class="text-xl sm:text-2xl font-bold text-red-600">{{ rejectedCount }}</div>
                    </div>
                </div>
            </div>


            <!-- Recently Approved Employees -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Recently Approved Employees - Compact Version -->
                <div class="lg:col-span-1">
                    <Card>
                        <CardContent class="p-0">
                            <div class="flex flex-col space-y-1.5 p-4">
                                <div class="flex items-center justify-between">
                                    <h3
                                        class="flex items-center gap-2 text-sm font-semibold leading-none tracking-tight">
                                        <CheckCircle class="h-4 w-4 text-green-600" />
                                        Recently Approved
                                    </h3>
                                    <Button variant="ghost" size="sm" class="p-1 h-6 w-6">
                                        <Eye class="h-3 w-3" />
                                    </Button>
                                </div>
                            </div>
                            <div class="p-4 pt-0">
                                <div class="space-y-2">
                                    <div v-for="(recentlyApproved, index) in recentlyApprovedRequests.data" :key="index"
                                        class="flex items-center gap-2 p-2 rounded-md bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-800">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                                <User class="h-3 w-3 text-green-600" />
                                            </div>
                                        </div>
                                        <div class="w-full flex justify-between gap-1">
                                            <p class="text-green-900 dark:text-green-100 p-0">
                                                {{ recentlyApproved.employee.name }}
                                            </p>
                                            <Badge
                                                :class="getLeaveRequestTypeClass(recentlyApproved.employeeRequest.type)">
                                                {{ recentlyApproved.employeeRequest.type }}
                                            </Badge>
                                        </div>
                                    </div>
                                    <div v-if="recentlyApprovedRequests.data.length <= 0" class="text-center py-4">
                                        <CheckCircle class="h-6 w-6 text-muted-foreground mx-auto mb-2" />
                                        <p class="text-muted-foreground text-xs">No recent approvals</p>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <Card>
                        <CardContent class="p-0">
                            <div class="flex flex-col space-y-1.5 p-4 sm:p-6">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div>
                                        <h3
                                            class="flex items-center gap-2 text-xl sm:text-2xl font-semibold leading-none tracking-tight text-balance">
                                            <Users class="h-5 w-5" />
                                            Employee Requests
                                        </h3>
                                        <p class="text-sm text-muted-foreground mt-1">Review and manage all employee
                                            requests</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 sm:p-6 pt-0">
                                <div class="space-y-3 sm:space-y-4">
                                    <div v-if="requests.data.length > 0" class="space-y-3 sm:space-y-4">
                                        <div v-for="request in requests.data" :key="request.id"
                                            class="rounded-lg border bg-card text-card-foreground shadow-sm border-l-4 border-l-primary/20">
                                            <div class="p-4 sm:p-6">
                                                <div class="space-y-4">
                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                                        <div class="flex items-start gap-3 min-w-0 flex-1">
                                                            <component
                                                                :is="getRequestIcon(request.employeeRequest.type)"
                                                                class="h-5 w-5 mt-1 text-muted-foreground flex-shrink-0" />
                                                            <div class="space-y-2 min-w-0 flex-1">
                                                                <div
                                                                    class="flex flex-col sm:flex-row sm:items-center gap-2">
                                                                    <h3
                                                                        class="font-semibold text-balance text-sm sm:text-base">
                                                                        {{ request.title }}</h3>
                                                                    <div class="flex items-center gap-2 flex-wrap">
                                                                        <Badge
                                                                            :class="[getLeaveRequestStatusClass(request.status)]">
                                                                            {{ request.status }}
                                                                        </Badge>
                                                                        <span
                                                                            v-if="request.priority.toLowerCase() == 'high'"
                                                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                                                            High Priority
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <p class="text-xs sm:text-sm text-muted-foreground">
                                                                    <span class="font-medium">{{
                                                                        request.employee.name
                                                                        }}</span> •
                                                                    {{ request.employeeRequest.type }} •
                                                                    <span class="hidden sm:inline">{{
                                                                        request.createdAt
                                                                        }}</span>
                                                                    <span class="sm:hidden">{{
                                                                        request.createdAt.split('')[0] }}</span>
                                                                </p>
                                                                <p v-if="request.employeeRequest.startDate"
                                                                    class="text-xs sm:text-sm text-muted-foreground">
                                                                    <span class="italic">From: </span>{{
                                                                        request.employeeRequest.startDate }}
                                                                    <span class="italic ml-2">To: </span>{{
                                                                        request.employeeRequest.endDate
                                                                            ? `${request.employeeRequest.endDate}`
                                                                            : ''
                                                                    }}
                                                                </p>
                                                                <p
                                                                    class="text-xs sm:text-sm text-pretty line-clamp-2 sm:line-clamp-none">
                                                                    {{ request.reason }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center gap-2 flex-shrink-0">
                                                            <div class="flex items-center gap-1 sm:gap-2">
                                                                <Tooltip>
                                                                    <TooltipTrigger>
                                                                        <Button @click="handleQuickApprove(request)"
                                                                            variant="outline" size="sm"
                                                                            class="text-green-600 hover:text-green-700 hover:bg-green-50 p-2">
                                                                            <CheckCircle class="h-4 w-4" />
                                                                            <span class="sr-only">Approve</span>
                                                                        </Button>
                                                                    </TooltipTrigger>

                                                                    <TooltipContent>
                                                                        Quick Approve
                                                                    </TooltipContent>
                                                                </Tooltip>
                                                                <Button @click="handleViewDetails(request)"
                                                                    variant="outline" size="sm"
                                                                    class="text-red-600 hover:text-red-700 hover:bg-red-50 p-2">
                                                                    <XCircle class="h-4 w-4" />
                                                                    <span class="sr-only">Reject</span>
                                                                </Button>
                                                            </div>
                                                            <Button @click="handleViewDetails(request)"
                                                                variant="outline" size="sm" class="hidden sm:flex">
                                                                <Eye class="h-4 w-4 mr-2" />
                                                                View Details
                                                            </Button>
                                                            <Button @click="handleViewDetails(request)"
                                                                variant="outline" size="sm" class="sm:hidden p-2">
                                                                <Eye class="h-4 w-4" />
                                                                <span class="sr-only">View Details</span>
                                                            </Button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-else class="text-center py-12 sm:py-16">
                                        <Users class="h-12 w-12 text-muted-foreground mx-auto mb-4" />
                                        <p class="text-muted-foreground text-pretty">No requests found for the
                                            selected
                                            filter</p>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>

        <!-- Request Detail Modal -->
        <RequestDetailsDialog :is-open="requestDialogDetails.isOpen" @update:open="requestDialogDetails.isOpen = $event"
            :request="requestDialogDetails.data" />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Calendar, Clock, AlertTriangle, CheckCircle, XCircle, Eye, Users, Filter } from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import { getLeaveRequestStatusClass } from '@/composables/useLeaveRequestStatusClass'
import Badge from '@/components/ui/badge/Badge.vue'
import Button from '@/components/ui/button/Button.vue'
import RequestDetailsDialog from '@/components/Employee/LeaveReqeusts/LeaveRequestDetailsDialog.vue'
import Tooltip from '@/components/ui/tooltip/Tooltip.vue'
import TooltipTrigger from '@/components/ui/tooltip/TooltipTrigger.vue'
import TooltipContent from '@/components/ui/tooltip/TooltipContent.vue'
import Card from '@/components/ui/card/Card.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import { getLeaveRequestTypeClass } from '@/composables/useLeaveRequestTypeClass'
const requestDialogDetails = ref({
    isOpen: false,
    data: null
});
const props = defineProps({
    requests: Array,
    recentlyApprovedRequests: Array,
})

const handleViewDetails = (request) => {
    requestDialogDetails.value.isOpen = true;
    requestDialogDetails.value.data = request
}

const getRequestIcon = (type) => {
    switch (type.toLowerCase()) {
        case 'vacation':
            return Calendar
        case 'day off':
            return Clock
        case 'urgent':
            return AlertTriangle
        default:
            return Calendar
    }
}

defineOptions({
    layout: AppLayout,
})
</script>