<template>
    <Dialog :open="isOpen" @update:open="isOpen = $event">
        <DialogContent>
            <Card>
                <CardHeader>
                    <CardTitle>
                        {{ request?.title }} - {{ request?.employee.name }}
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <Label class="text-sm font-medium">Request Type</Label>
                                <p class="text-sm text-muted-foreground">{{ request.employeeRequest.type }}</p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm font-medium">Priority</p>
                                <Badge :class="getLeaveRequestStatusClass(request.status)">
                                    {{ request.status }}
                                </Badge>
                            </div>

                            <div>
                                <Label class="text-sm font-medium">Submitted Date</Label>
                                <p class="text-sm text-muted-foreground">{{ request.createdAt }}</p>
                            </div>
                            <div v-if="request.startDate">
                                <Label class="text-sm font-medium">Request Date(s)</Label>
                                <p v-if="request.employeeRequest.startDate" class="text-sm text-muted-foreground">
                                    {{ request.employeeRequest.startDate }}

                                    {{
                                        request.employeeRequest.endDate
                                            ? `- ${request.employeeRequest.endDate}`
                                            : ''
                                    }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <Label class="text-sm font-medium">Reason</Label>
                            <p class="text-sm text-muted-foreground text-pretty mt-1">{{ request.reason }}</p>
                        </div>

                        <div v-if="request.note">
                            <Label class="text-sm font-medium">Employee Notes</Label>
                            <p class="text-sm text-muted-foreground text-pretty mt-1">{{ request.notes }}</p>
                        </div>

                        <div class="space-y-3">
                            <Label for="hr-notes" class="text-sm font-medium">HR Rejections Reason</Label>
                            <Textarea id="hr-rejection-reason" v-model="form.rejectionReason"
                                placeholder="Add whatever you want for this request..."></textarea>

                            <InputError :message="form.errors?.rejectionReason" />
                        </div>


                    </div>

                </CardContent>
                <DialogFooter class=" pe-6 pb-6">
                    <div v-if="request.status.toLowerCase() == 'pending'" class="flex justify-end gap-2 ">
                        <DialogClose>
                            <Button variant="outline">
                                Cancel
                            </Button>
                        </DialogClose>
                        <Button @click.prevent="handleReject" class=" bg-red-600 hover:bg-red-700 text-white"
                            :disabled="form.processing">
                            <XCircle class="h-4 w-4 mr-1" />
                            Reject
                        </Button>
                        <Button @click.prevent="handleApprove" class=" bg-green-600 hover:bg-green-700 text-white"
                            :disabled="form.processing">
                            <CheckCircle class="h-4 w-4 mr-1" />
                            Approve
                        </Button>
                    </div>
                </DialogFooter>
            </Card>

        </DialogContent>

    </Dialog>
</template>

<script setup>
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Dialog from '@/components/ui/dialog/Dialog.vue';
import DialogClose from '@/components/ui/dialog/DialogClose.vue';
import DialogContent from '@/components/ui/dialog/DialogContent.vue';
import DialogFooter from '@/components/ui/dialog/DialogFooter.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { getLeaveRequestStatusClass } from '@/composables/useLeaveRequestStatusClass';
import { CheckCircle, XCircle } from 'lucide-vue-next';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { toast } from '@/components/ui/toast';
const form = useForm({
    rejectionReason: ''
});
const propsData = defineProps({
    isOpen: Boolean,
    request: Object,
})


const handleApprove = () => {
    form.put(route('leave.request.approve', propsData.request.id), {
        onSuccess: () => {
            toast({
                title: 'Request has been approved.',
                variant: 'success',
            })
        },
        onError: () => {
            toast({
                title: 'Something went wrong while trying to reject the request',
                variant: 'destructive',
            })
        }
    })
}
const handleReject = () => {
    form.put(route('leave.request.reject', propsData.request.id))
}

</script>