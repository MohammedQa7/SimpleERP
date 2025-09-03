<template>
    <Card>
        <CardContent class="p-0">
            <!-- Table Header -->
            <div class="grid grid-cols-7 gap-4 border-b p-4 font-medium text-muted-foreground">
                <div>Employee</div>
                <div>Department </div>
                <div>Check In </div>
                <div>Check Out </div>
                <div>Hours </div>
                <div>Status </div>
                <div>Action </div>
            </div>

            <!-- Table Body -->
            <div class="divide-y">
                <div v-for="attendance in attendances.data" :key="attendance.id"
                    class="grid grid-cols-7 gap-4 p-4 items-center hover:bg-muted/50">
                    <div class="employee-info flex items-center space-x-3">
                        <Avatar class="h-8 w-8">
                            <AvatarImage src="" :alt="attendance" />
                            <AvatarFallback>
                                {{attendance.employee.name
                                    .split(" ")
                                    .map((n) => n[0])
                                    .join("")}}
                            </AvatarFallback>
                        </Avatar>
                        <div>
                            <div className="font-medium">{{ attendance.employee.name }}</div>
                            <div className="text-sm text-muted-foreground">{{ attendance.employee.email }}</div>
                        </div>
                    </div>
                    <div>{{ attendance.employee.jobTitle }}</div>
                    <div>{{ attendance.checkIn }}</div>
                    <div>{{ attendance.checkOut }}</div>
                    <div>{{ attendance.hours }}</div>
                    <div>
                        <Badge :class="getAttendancesStatusVariant(attendance.status)">
                            {{ attendance.status }}
                        </Badge>
                    </div>

                    <div>
                        <Button variant="outline" class="px-3">
                            <PenBoxIcon />
                        </Button>
                    </div>
                </div>
            </div>
        </CardContent>

        <!-- Pagination -->
        <CustomPagination :item="attendances" />
    </Card>

    <!-- <DeleteDialog :open="deleteOrderDialogProps.isOpen"
        :description="'Deleting this order will also remove any related stock requests that have not yet been accepted..'"
        @update:open="deleteOrderDialogProps.isOpen = $event">
        <AlertDialogAction @click.prevent="deleteOrder(order)">
            Yes, I am sure
        </AlertDialogAction>
    </DeleteDialog> -->

    <!-- <EditOrderDialog v-if="editOrderDialog" :is-open="editOrderDialog" :is-loading="isLoading" :customers="customers"
        :products="products" :order="order" :order-status="orderStatus" @Close="toggleOrderDialog" /> -->
</template>

<script setup>
import { ref } from 'vue'
import { Trash, Edit, Eye, PenBoxIcon } from 'lucide-vue-next'
import Card from '@/components/ui/card/Card.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import Button from '@/components/ui/button/Button.vue'
import { router, Link } from '@inertiajs/vue3'
import { isNull } from 'lodash';
import axios from 'axios'
import CardFooter from '@/components/ui/card/CardFooter.vue'
import { toast } from '@/components/ui/toast'
import DeleteDialog from '../../DeleteDialog.vue'
import AlertDialogAction from '@/components/ui/alert-dialog/AlertDialogAction.vue'
import Avatar from '@/components/ui/avatar/Avatar.vue'
import AvatarImage from '@/components/ui/avatar/AvatarImage.vue'
import AvatarFallback from '@/components/ui/avatar/AvatarFallback.vue'
import { annotation } from '@unovis/ts/components/annotations/style'
import Badge from '@/components/ui/badge/Badge.vue'
import CustomPagination from '@/components/CustomPagination.vue'
import { getAttendancesStatusVariant } from '@/composables/useAttendancesStatus'
const editOrderDialog = ref(false);
const isLoading = ref(false);
const customers = ref([]);
const products = ref([]);
const order = ref(null);
const propsData = defineProps({
    attendances: Array,
    orderStatus: Object,
});

</script>