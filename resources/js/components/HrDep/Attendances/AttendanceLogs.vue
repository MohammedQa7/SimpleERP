<template>
    <Card>
        <CardHeader>
            <CardTitle>Recent Activity</CardTitle>
        </CardHeader>

        <CardContent>
            <div class="space-y-4">
                <div v-for="log in attendanceLogs.data" :key="log.id"
                    class="flex items-center justify-between p-4 border rounded-lg hover:bg-primary/10 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="p-2 rounded-full " :class="log.action === 'check-in'
                            ? 'bg-green-100 text-green-600'
                            : 'bg-red-100 text-red-600'
                            ">
                            <LogIn v-if="log.action === 'check-in'" class="h-4 w-4" />
                            <LogOut v-else class="h-4 w-4" />
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <span class="font-medium">{{ log.employee.name }}</span>
                                <Badge variant="secondary" class="text-xs">{{ log.employee.accountCode }}</Badge>
                            </div>
                            <div class="flex items-center  text-sm text-muted-foreground">
                                <span>{{ log.employee.email }}</span>
                                <span>
                                    <Dot />
                                </span>
                                <span>{{ log.employee.jobTitle }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right space-y-1">
                        <div class="flex items-center space-x-2">
                            <Badge
                                :class="log.action === 'check-in' ? 'bg-green-900 text-green-100' : 'bg-red-900 text-red-100'">
                                {{ log.action === 'check-in' ? 'Check In' : 'Check Out' }}
                            </Badge>
                        </div>
                        <div class="text-sm text-muted-foreground">
                            <div>{{ log.checkInDate }}</div>
                            <div class="font-medium">{{ log.checkInTime }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </CardContent>

        <CustomPagination :item="attendanceLogs" />
    </Card>
</template>

<script setup>
import CustomPagination from '@/components/CustomPagination.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import { Dot, LogIn, LogOut } from 'lucide-vue-next';
import { computed, ref } from 'vue';
const isLoading = ref(true);
const propsData = defineProps({
    attendanceLogs: Array,
});



</script>