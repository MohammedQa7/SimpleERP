<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button @click.prevent="loadInvoices">
                <Plus class="mr-2 h-4 w-4" />
                Record payment transaction
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[625px] max-h-[80%] overflow-x-auto">
            <DialogHeader>
                <DialogTitle>New Payment Transaction</DialogTitle>
            </DialogHeader>

            <!-- Skelaton -->
            <InvoiceSkelaton v-if="isLoading" />

            <!--  -->
            <div v-else class="space-y-6 ">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-1">
                        <div class="flex flex-col space-y-2 w">
                            <Label for="invoices">Invoices</Label>

                            <!-- Invoices selections Component -->
                            <InvoiceSelect :invoices="invoices" @bindSelectedInvoice="onBindSelectedInvoice" />

                            <InputError :message="form.errors.invoiceNumber" />
                        </div>

                    </div>
                    <div>
                        <form @submit.prevent="handleSubmit" class="space-y-4">
                            <!-- Payment method -->
                            <div class="space-y-2">
                                <Label
                                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Payment Method
                                </Label>
                                <div class="grid grid-cols-3 gap-3">
                                    <div v-for="method in paymentMethods" :key="method.id"
                                        @click="form.paymentMethod = method.name"
                                        class="relative flex cursor-pointer flex-col items-center justify-between rounded-md border-2 bg-popover p-4 hover:bg-accent hover:text-accent-foreground"
                                        :class="form.paymentMethod === method.name ? 'border-primary' : 'border-muted'">
                                        <component :is="method.icon" class="mb-3 h-6 w-6" />
                                        <span class="text-sm">{{ method.name }}</span>
                                        <input type="radio" :name="method.id" :value="method.name"
                                            v-model="form.paymentMethod" class="sr-only" />
                                    </div>
                                    <InputError :message="form.errors.method" />
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <!-- FilePond -->
                                <Label for="security-level">Attachments</Label>
                                <file-pond name="attachments" ref="filepond" class-name="my-pond" allow-multiple="true"
                                    label-idle="Drop Or Click to Upload All attachments" v-bind:files="myFiles"
                                    v-on:init="handleFilePondInit" :server="{
                                        url: '',
                                        process: {
                                            url: route('upload'),
                                            method: 'post',
                                            onload: handleMultipleFilePondLoad,
                                        },
                                        revert: handleMultipleFilePondRevert,
                                        headers: {
                                            'X-CSRF-TOKEN': page.props.csrf
                                        }
                                    }" />
                                <InputError v-if="page.props.errors.attachments" class="mt-2"
                                    :errorMessage="page.props.errors.attachments" />
                                <InputError :message="form.errors.attachments" />

                            </div>

                            <!-- Notes -->
                            <div class="space-y-2">
                                <Label for="notes"
                                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Notes (Optional)
                                </Label>
                                <Textarea id="notes" v-model="form.notes"
                                    placeholder="Add any additional information about this payment"></Textarea>
                                <InputError :message="form.errors.notes" />
                            </div>

                            <!-- Action buttons -->
                            <DialogFooter class="flex items-center justify-between">
                                <div class="flex space-x-2 ">
                                    <DialogClose>
                                        <Button variant="outline">Cancel</Button>
                                    </DialogClose>
                                    <Button @click.prevent="submit">Create
                                        Record payment</Button>
                                </div>
                            </DialogFooter>
                        </form>
                    </div>

                </div>
            </div>
        </DialogContent>
    </Dialog>

</template>

<script setup>
import { ref, computed } from 'vue'
import {
    Building2,
    CreditCard,
    Plus,
    Wallet,
} from 'lucide-vue-next'
import vueFilePond from 'vue-filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import Button from '@/components/ui/button/Button.vue'
import Dialog from '../ui/dialog/Dialog.vue'
import DialogTrigger from '../ui/dialog/DialogTrigger.vue'
import DialogContent from '../ui/dialog/DialogContent.vue'
import DialogHeader from '../ui/dialog/DialogHeader.vue'
import DialogTitle from '../ui/dialog/DialogTitle.vue'
import { router, useForm, usePage } from '@inertiajs/vue3'
import InputError from '../InputError.vue'
import { toast } from '@/components/ui/toast'
import DialogClose from '../ui/dialog/DialogClose.vue'
import InvoiceSkelaton from './InvoiceSkelaton.vue'
import Label from '../ui/label/Label.vue'
import Textarea from '../ui/textarea/Textarea.vue'
import DialogFooter from '../ui/dialog/DialogFooter.vue'
import InvoiceSelect from '../InvoiceSelect.vue'
const isLoading = ref(false);
const FilePond = vueFilePond(FilePondPluginImagePreview);
const filepond = ref();
const myFiles = ref([]);
const invoices = ref(null);
const page = usePage();
const form = useForm({
    invoiceNumber: null,
    paymentMethod: null,
    notes: '',
    attachments: [],
});
// Payment methods
const paymentMethods = [
    { id: 'credit-card', name: 'Credit Card', icon: CreditCard },
    { id: 'bank-transfer', name: 'Bank Transfer', icon: Building2 },
    { id: 'PayPal', name: 'PayPal', icon: Wallet }
];


// Handling multi Image load/store Filepone
function handleMultipleFilePondLoad(response) {
    form.attachments.push(response);
    return response;
}

// Handling multi Image Revert Filepone
function handleMultipleFilePondRevert(attachmentID, load, error) {
    form.attachments = form.attachments.filter((attachment) => attachment !== attachmentID);
    router.post(route('revert'), { attachment_path: attachmentID }, {
        preserveScroll: true,
    });
}



const loadInvoices = () => {
    isLoading.value = true;
    router.visit(route('payments.create'), {
        only: ['invoices'],
        preserveScroll: true,
        preserveState: true,
        preserveUrl: true,
        onSuccess: (page) => {
            isLoading.value = false;
            invoices.value = page.props.invoices;
        },
        onError: () => {
            isLoading.value = false;
        }
    })
}


const onBindSelectedInvoice = (invoice) => {
    form.invoiceNumber = invoice.invoiceNumber
}


const submit = () => {
    form.post(route('payments.store'), {
        onSuccess: () => {
            form.reset();
            toast({
                title: 'The order has been successfully placed.',
            })
        },
        onError: () => {
            toast({
                title: 'Something went wrong while trying to create the transaction.',
            })
        }
    });
}




</script>
