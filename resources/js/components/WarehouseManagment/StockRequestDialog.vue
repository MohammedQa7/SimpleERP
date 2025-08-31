<template>

    <!-- Stock Request Details Dialog -->
    <Dialog :open="isOpen" @update:open="isOpen = $event">
        <DialogContent class="sm:max-w-[500px]">
            <DialogHeader>
                <DialogTitle>Stock Request Details</DialogTitle>
                <DialogDescription>
                    Review the stock request from <span class=" italic">{{ stockRequest.user.name }}</span>
                </DialogDescription>
            </DialogHeader>
            <div v-if="true" class="py-4">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 p-3 border rounded-md bg-muted/20">
                        <div class="h-10 w-10 rounded-md bg-muted flex items-center justify-center">
                            <PackageIcon class="h-5 w-5 text-muted-foreground" />
                        </div>
                        <div>
                            <p class="font-medium">{{ stockRequest.product.name }}</p>
                            <p class="text-xs text-muted-foreground">SKU: {{ stockRequest.product.sku }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium">Department</p>
                            <p class="text-sm">{{ stockRequest.department }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Requested By</p>
                            <p class="text-sm">{{ stockRequest.user.name }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium">Quantity Requested</p>
                            <p class="text-sm">{{ stockRequest.requestedQuantity }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Current Stock</p>
                            <p class="text-sm">{{ stockRequest.product.stock }}</p>
                        </div>
                    </div>


                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium">Reason</p>
                            <p class="text-sm">{{ stockRequest.reason }}
                                <span v-if="!stockRequest.reasons" class="text-muted-foreground italic">No reason was
                                    provided</span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Note</p>
                            <p class="text-sm">{{ stockRequest.notes }}
                                <span v-if="!stockRequest.notes" class="text-muted-foreground italic">No note was
                                    provided</span>
                            </p>
                        </div>
                    </div>



                    <div class="space-y-2">
                        <p class="text-sm font-medium">Priority</p>
                        <Badge :variant="stockRequest.priority === 'High' ? 'destructive' : 'default'">
                            {{ stockRequest.priority }}
                        </Badge>
                    </div>

                    <div v-if="stockRequest.status == 'Pending'">
                        <Label>Approval Notes</Label>
                        <Textarea v-model="approvalNotes" placeholder="Add notes for approval or rejection" rows="2"
                            class="mt-1" />
                    </div>
                </div>
            </div>
            <DialogFooter>
                <div v-if="stockRequest.status == 'Pending'" class="flex gap-2 w-full">
                    <Button @click.prevent="emit('rejectRequest', stockRequest)" variant="outline" class="flex-1">
                        Reject
                    </Button>
                    <Button @click.prevent="emit('acceptRequest', stockRequest)" class="flex-1">
                        Approve
                    </Button>
                </div>
            </DialogFooter>
        </DialogContent>
    </Dialog>

</template>

<script setup>
import { PackageIcon } from 'lucide-vue-next';
import Badge from '../ui/badge/Badge.vue';
import Button from '../ui/button/Button.vue';
import Dialog from '../ui/dialog/Dialog.vue';
import DialogContent from '../ui/dialog/DialogContent.vue';
import DialogDescription from '../ui/dialog/DialogDescription.vue';
import DialogHeader from '../ui/dialog/DialogHeader.vue';
import DialogTitle from '../ui/dialog/DialogTitle.vue';
import Label from '../ui/label/Label.vue';
import Textarea from '../ui/textarea/Textarea.vue';
const emit = defineEmits();
const propsData = defineProps({
    isOpen: Boolean,
    stockRequest: Object,
});

</script>