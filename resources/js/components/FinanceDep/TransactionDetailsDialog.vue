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
                    <div class="border rounded-md ">
                        <div v-if="transaction.attachments.length > 0">
                            <div v-for="(attachment, index) in transaction.attachments" :key="index"
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-2 px-2 sm:px-0 group rounded-lg sm:rounded-none hover:bg-primary/50 sm:hover:bg-transparent transition-all">
                                <!-- File info section -->
                                <div class="flex items-center gap-3 min-w-0 flex-1">
                                    <div
                                        class="h-9 w-9 rounded-md bg-muted flex items-center justify-center flex-shrink-0">
                                        <FileText v-if="attachment.type === 'application/pdf'"
                                            class="h-5 w-5 text-gray-600" />
                                        <Image v-else-if="attachment.type === 'image/png'"
                                            class="h-5 w-5 text-gray-600" />
                                        <File v-else class="h-5 w-5 text-gray-600" />
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-medium break-words text-sm sm:text-base leading-tight">
                                            {{ attachment.name }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ attachment.size }}</p>
                                    </div>
                                </div>

                                <!-- Action buttons -->
                                <div
                                    class="flex gap-2 mt-2 sm:mt-0 sm:ml-4 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity self-end sm:self-center">
                                    <Button @click.prevent="download(attachment.id)" variant="ghost" size="icon">
                                        <Download class="h-4 w-4" />
                                    </Button>
                                    <!-- v-if="attachment.type == 'image/png'" -->
                                    <Button @click.prevent="previewAttachment(attachment)" variant="ghost" size="icon">
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
                    <Button class="w-full mb-2" variant="outline">Close</Button>
                </DialogClose>

                <Button @click.prevent="downloadReceipt(transaction.receiptFile.id)" class="mb-2 md:mb-0">Download
                    Receipt</Button>
            </DialogFooter>
        </DialogContent>

        <!-- Image Preview Modal -->
        <Dialog v-if="previewOpen" :open="previewOpen" @update:open="previewOpen = $event">
            <DialogContent class="sm:max-w-[800px]  overflow-hidden">
                <DialogHeader>
                    <DialogTitle>{{ currentPreview ? currentPreview.name : 'Image Preview' }}
                    </DialogTitle>
                    <DialogDescription v-if="currentPreview">
                        {{ currentPreview.size }}
                    </DialogDescription>
                </DialogHeader>

                <div class="flex items-center justify-center p-2 overflow-auto">

                    <!-- IMAGES -->
                    <img v-if="currentPreview.type == 'image/png' && currentPreview.path" :src="currentPreview.path"
                        :alt="currentPreview.name" class="max-w-full max-h-[65vh] object-contain rounded-md"
                        loading="lazy" />

                    <!-- PDF's -->
                    <iframe v-else-if="currentPreview.type == 'application/pdf'" :src="currentPreview.path"
                        class="w-full h-[65vh]  rounded-b" frameborder="0"></iframe>

                    <div v-else class="text-center py-12 text-muted-foreground space-y-5">
                        <ImageOff class="h-16 w-16 mx-auto mb-4" />
                        <p>Unable to preview </p>
                    </div>
                </div>



                <DialogFooter>
                    <DialogClose>
                        <Button variant="outline">Close</Button>
                    </DialogClose>
                    <Button v-if="currentPreview && currentPreview.path" @click="download(currentPreview.id)">
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
    currentPreview.value = attachment
    previewOpen.value = true
    // Only allow preview for image types
    // if (attachment.type == 'image/png') {
    //  
    // }
}
const downloadReceipt = (mediaFile) => {
    const url = route('download', { media: mediaFile });
    window.location.href = url
}

const download = (mediaFile) => {
    const url = route('download', { media: mediaFile });
    window.location.href = url
}

</script>