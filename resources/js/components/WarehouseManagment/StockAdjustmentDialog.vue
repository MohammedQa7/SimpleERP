<template>
    <Dialog :open="isDialogOpened" @update:open="isDialogOpened = $event">

        <DialogContent class="sm:max-w-[500px]">
            <DialogHeader>
                <DialogTitle>Adjust Stock</DialogTitle>
                <DialogDescription>
                    Update inventory levels for {{ product.name || 'selected products' }}
                </DialogDescription>
            </DialogHeader>

            <div class="grid gap-4 py-4">
                <div class="space-y-2">
                    <Label for="adjustment-type">Adjustment Type</Label>
                    <Select v-model="form.type">
                        <SelectTrigger id="adjustment-type">
                            <SelectValue placeholder="Select type" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="add">Add Stock</SelectItem>
                            <SelectItem value="remove">Remove Stock</SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="form.errors.type" />
                </div>
                <div class="space-y-2">
                    <Label for="adjustment-quantity">Quantity</Label>
                    <Input id="adjustment-quantity" v-model="form.quantity" type="number" min="0" placeholder="0" />
                    <InputError :message="form.errors.quantity" />
                </div>
                <div class="space-y-2">
                    <Label for="adjustment-reason">Reason</Label>
                    <Select v-model="form.reason">
                        <SelectTrigger id="adjustment-reason">
                            <SelectValue placeholder="Select reason" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="purchase">Purchase</SelectItem>
                            <SelectItem value="sale">Sale</SelectItem>
                            <SelectItem value="return">Return</SelectItem>
                            <SelectItem value="damage">Damage/Loss</SelectItem>
                            <SelectItem value="correction">Inventory Correction</SelectItem>
                            <SelectItem value="other">Other</SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="form.errors.reason" />
                </div>
                <div class="space-y-2">
                    <Label for="adjustment-notes">Notes</Label>
                    <Textarea id="adjustment-notes" v-model="form.notes" placeholder="Additional notes" rows="2" />
                    <InputError :message="form.errors.notes" />
                </div>

                <DialogFooter>
                    <DialogClose>
                        <Button variant="outline">Cancel</Button>
                    </DialogClose>

                    <Button @click="submit">Confirm</Button>
                </DialogFooter>
            </div>

        </DialogContent>
    </Dialog>
</template>

<script setup>
import Input from "@/components/ui/input/Input.vue"
import Label from "@/components/ui/label/Label.vue"
import Dialog from "@/components/ui/dialog/Dialog.vue"
import DialogContent from "@/components/ui/dialog/DialogContent.vue"
import DialogDescription from "@/components/ui/dialog/DialogDescription.vue"
import DialogFooter from "@/components/ui/dialog/DialogFooter.vue"
import DialogHeader from "@/components/ui/dialog/DialogHeader.vue"
import DialogTitle from "@/components/ui/dialog/DialogTitle.vue"
import Textarea from "@/components/ui/textarea/Textarea.vue"
import Button from '@/components/ui/button/Button.vue'
import { computed } from "vue"
import GeneralSkelaton from "../GeneralSkelaton.vue"
import Select from "../ui/select/Select.vue"
import SelectTrigger from "../ui/select/SelectTrigger.vue"
import SelectValue from "../ui/select/SelectValue.vue"
import SelectContent from "../ui/select/SelectContent.vue"
import SelectItem from "../ui/select/SelectItem.vue"
import { useForm } from "@inertiajs/vue3"
import InputError from "../InputError.vue"
import { toast } from "../ui/toast"
import DialogClose from "../ui/dialog/DialogClose.vue"
const propsData = defineProps({
    product: Object,
    isOpen: Boolean,
    isLoading: Boolean,
});
const form = useForm({
    type: '',
    quantity: 0,
    reason: '',
    notes: ''
})


const isDialogOpened = computed(() => {
    return propsData.isOpen;
})

const submit = () => {
    form.post(route('stock.adjust', { product: propsData.product.sku }), {
        onSuccess: () => {
            toast({
                title: 'Stock have been adjusted'
            })
        },
        onError: () => {
            toast({
                title: 'Something went wrong, try again'
            })
        }
    })
}
</script>