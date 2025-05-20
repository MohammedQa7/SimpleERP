<template>
    <Dialog :open="isDialogOpened" @update:open="isDialogOpened = $event">
        <DialogContent class="sm:max-w-[600px]">
            <DialogHeader>
                <DialogTitle>Edit Product</DialogTitle>
                <DialogDescription>
                    Update product details and inventory information.
                </DialogDescription>
            </DialogHeader>

            <GeneralSkelaton v-if="isLoading" />

            <div v-else>
                <div class="grid gap-4 py-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <Label for="product-name">Product Name</Label>
                            <Input id="product-name" v-model="form.name" placeholder="Product name" />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="space-y-2">
                            <Label for="product-category">Category</Label>
                            <Select v-model="form.category">
                                <SelectTrigger id="product-category">
                                    <SelectValue placeholder="Select category" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.category" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <Label for="product-cost-price">Cost Price ($)</Label>
                            <Input id="product-cost-price" v-model="form.costPrice" type="number" step="0.01" min="0"
                                placeholder="0.00" />
                            <InputError :message="form.errors.costPrice" />
                        </div>

                        <div class="space-y-2">
                            <Label for="product-selling-price">Selling Price ($)</Label>
                            <Input id="product-selling-price" v-model="form.sellingPrice" type="number" step="0.01"
                                min="0" placeholder="0.00" />
                            <InputError :message="form.errors.sellingPrice" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <Label for="product-description">Description</Label>
                        <Textarea id="product-description" v-model="form.description" placeholder="Product description"
                            rows="3" />
                    </div>
                </div>

            </div>
            <DialogFooter v-if="!isLoading" class="flex justify-end gap-4">
                <DialogClose>
                    <Button variant="outline" :disabled="form.processing">Cancel</Button>
                </DialogClose>

                <Button @click="submit" :disabled="form.processing">Confirm</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>

</template>

<script setup>
import { ref, onMounted, onUnmounted, watch, computed } from 'vue'
import Dialog from '@/components/ui/dialog/Dialog.vue'
import DialogContent from '@/components/ui/dialog/DialogContent.vue'
import DialogHeader from '@/components/ui/dialog/DialogHeader.vue'
import DialogTitle from '@/components/ui/dialog/DialogTitle.vue'
import { useForm } from '@inertiajs/vue3'
import DialogClose from '@/components/ui/dialog/DialogClose.vue'
import Label from '@/components/ui/label/Label.vue'
import Input from '@/components/ui/input/Input.vue'
import InputError from '@/components/InputError.vue'
import Select from '@/components/ui/select/Select.vue'
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue'
import SelectValue from '@/components/ui/select/SelectValue.vue'
import SelectContent from '@/components/ui/select/SelectContent.vue'
import SelectGroup from '@/components/ui/select/SelectGroup.vue'
import SelectItem from '@/components/ui/select/SelectItem.vue'
import Button from '@/components/ui/button/Button.vue';
import { toast } from '@/components/ui/toast'
import GeneralSkelaton from '../GeneralSkelaton.vue'
import Textarea from '../ui/textarea/Textarea.vue'
const emit = defineEmits();
const hasFetchedData = ref(false);
const form = useForm({
    name: '',
    category: null,
    costPrice: 0,
    sellingPrice: 0,
    description: ''
});
const propsData = defineProps({
    product: Object,
    isOpen: Boolean,
    isLoading: Boolean,
    categories: Array,
});
const isDialogOpened = computed(() => {
    return propsData.isOpen;
})

watch(propsData, (newValue) => {
    if (!hasFetchedData.value) {
        Object.assign(form, newValue.product);
        form.category = newValue.product.category.id;
    }
}, { deep: true });


const submit = () => {
    form.put(route('products.update', { product: propsData.product.sku }), {
        onSuccess: () => {
            toast({
                title: 'Changes have been saved.'
            });
        },

        onError: () => {
            toast({
                title: 'Something went wrong while updating, please try again or contact the support.'
            });
        }
    })
}


</script>
