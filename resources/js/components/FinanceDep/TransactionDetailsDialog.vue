<template>
    <Dialog :open="isDialogOpened" @update:open="isDialogOpened = $event">
        <DialogContent class="sm:max-w-[600px]">
            <DialogHeader>
                <DialogTitle>Payment Transaction Details</DialogTitle>
                <DialogDescription>
                    View and manage transaction information
                </DialogDescription>
            </DialogHeader>

            <GeneralSkelaton v-if="isLoading" />

            <div v-else class="grid gap-6 py-4">
                <!-- Transaction Details -->
                <div class="grid gap-2">
                    <h3 class="text-lg font-medium">Transaction Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-muted-foreground">Transaction ID</p>
                            <p class="font-medium">TX-{{ transaction.paymentNumber }}</p>
                        </div>
                        <div>
                            <p class="text-muted-foreground">Date</p>
                            <p class="font-medium">{{ transaction.createdAt }}</p>
                        </div>
                        <div>
                            <p class="text-muted-foreground">Amount</p>
                            <p class="font-medium text-lg">${{ transaction.invoice.order.totalPrice }}</p>
                        </div>
                    </div>
                </div>

                <Separator />

                <!-- Payment Method -->
                <div class="grid gap-2">
                    <h3 class="text-lg font-medium">Payment Method</h3>
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-10 rounded-md bg-muted flex items-center justify-center">
                            <CreditCard class="h-5 w-5" />
                        </div>
                        <div>
                            <p class="font-medium">{{ transaction.paymentMethod }}</p>
                        </div>
                    </div>
                </div>

                <Separator />

                <!-- Attachments Section -->
                <div class="grid gap-2">
                    <h3 class="text-lg font-medium">Attachments</h3>
                    <div class="border rounded-md p-4">
                        <div v-if="transaction.attachments.length > 0">
                            <div v-for="(attachment, index) in transaction.attachments" :key="index"
                                class="flex items-center justify-between py-2 group">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-md bg-muted flex items-center justify-center">
                                        <FileText v-if="attachment.type === 'application/pdf'" class="h-5 w-5" />
                                        <Image v-else-if="attachment.type === 'image/png'" class="h-5 w-5" />
                                        <File v-else class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <p class="font-medium break-words whitespace-normal">{{ attachment.name }}</p>
                                        <p class="text-xs text-muted-foreground">{{ attachment.size }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <Button @click.prevent="downloadAttachment(attachment.id)" variant="ghost"
                                        size="icon">
                                        <Download class="h-4 w-4" />
                                    </Button>
                                    <Button v-if="attachment.type == 'image/png'"
                                        @click.prevent="previewAttachment(attachment)" variant="ghost" size="icon">
                                        <Eye class="h-4 w-4" />
                                    </Button>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-6">
                            <FileX class="h-10 w-10 mx-auto text-muted-foreground" />
                            <p class="mt-2 text-muted-foreground">No attachments available</p>
                        </div>
                    </div>
                </div>
            </div>

            <DialogFooter>
                <DialogClose>
                    <Button variant="outline">Close</Button>
                </DialogClose>
                <Button @click.prevent="downloadReceipt(transaction.invoice.invoiceNumber)">Download Receipt</Button>
            </DialogFooter>
        </DialogContent>

        <!-- Image Preview Modal -->
        <Dialog v-if="previewOpen" :open="previewOpen" @update:open="previewOpen = $event">
            <DialogContent class="sm:max-w-[800px] max-h-[90vh] overflow-hidden">
                <DialogHeader>
                    <DialogTitle>{{ currentPreview ? currentPreview.name : 'Image Preview' }}
                    </DialogTitle>
                    <DialogDescription v-if="currentPreview">
                        {{ currentPreview.size }}
                    </DialogDescription>
                </DialogHeader>

                <div class="flex items-center justify-center p-2 overflow-auto max-h-[70vh]">
                    <img v-if="currentPreview && currentPreview.path" :src="currentPreview.path"
                        :alt="currentPreview.name" class="max-w-full max-h-[65vh] object-contain rounded-md"
                        loading="lazy" />
                    <div v-else class="text-center py-12 text-muted-foreground">
                        <ImageOff class="h-16 w-16 mx-auto mb-4" />
                        <p>Unable to preview this image</p>
                    </div>
                </div>

                <DialogFooter>
                    <DialogClose>
                        <Button variant="outline">Close</Button>
                    </DialogClose>
                    <Button v-if="currentPreview && currentPreview.path" @click="downloadAttachment(currentPreview.id)">
                        <Download class="h-4 w-4 mr-2" />
                        Download
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </Dialog>



</template>

<script setup>
import { computed, ref } from 'vue';
import Dialog from '../ui/dialog/Dialog.vue';
import DialogContent from '../ui/dialog/DialogContent.vue';
import InvoiceSkelaton from './InvoiceSkelaton.vue';
import DialogTitle from '../ui/dialog/DialogTitle.vue';
import DialogDescription from '../ui/dialog/DialogDescription.vue';
import DialogFooter from '../ui/dialog/DialogFooter.vue';
import Button from '../ui/button/Button.vue';
import Separator from '../ui/separator/Separator.vue';
import DialogClose from '../ui/dialog/DialogClose.vue';
import { CreditCard, Download, Eye, File, FileText, Image } from 'lucide-vue-next';
import GeneralSkelaton from '../GeneralSkelaton.vue';
const previewOpen = ref(false);
const currentPreview = ref(null);
const propsData = defineProps({
    transaction: Object,
    isOpen: Boolean,
    isLoading: Boolean,
})
const isDialogOpened = computed(() => {
    return propsData.isOpen;
})

const previewAttachment = (attachment) => {
    // Only allow preview for image types
    if (attachment.type == 'image/png') {
        currentPreview.value = attachment
        previewOpen.value = true
    }
}
const downloadReceipt = (invoiceNumber) => {
    const url = route('download', { invoice: invoiceNumber });
    window.location.href = url
}
const downloadAttachment = (attachmentId) => {
    const url = route('download-attachments', { attachment: attachmentId });
    window.location.href = url
}


</script>