<template>
    <Dialog>
        <DialogTrigger>
            <Button variant="default">
                <PlusIcon class="mr-2 h-4 w-4" />
                Add Product
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[600px]">
            <DialogHeader>
                <DialogTitle>Add New Product</DialogTitle>
                <DialogDescription>
                    Add a new product to your inventory
                </DialogDescription>
            </DialogHeader>
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
                        <Input id="product-selling-price" v-model="form.sellingPrice" type="number" step="0.01" min="0"
                            placeholder="0.00" />
                        <InputError :message="form.errors.sellingPrice" />
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="space-y-2">
                        <Label for="product-stock">Stock Quantity</Label>
                        <Input id="product-stock" v-model="form.stock" type="number" min="0" placeholder="0" />
                        <InputError :message="form.errors.stock" />
                    </div>
                </div>
                <div class="space-y-2">
                    <Label for="product-description">Description</Label>
                    <Textarea id="product-description" v-model="form.description" placeholder="Product description"
                        rows="3" />
                </div>
            </div>
            <DialogFooter>
                <DialogClose>
                    <Button variant="outline">Cancel</Button>
                </DialogClose>
                <Button @click.prevent="submit">Save</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Dialog from '@/components/ui/dialog/Dialog.vue';
import DialogClose from '@/components/ui/dialog/DialogClose.vue';
import DialogContent from '@/components/ui/dialog/DialogContent.vue';
import DialogDescription from '@/components/ui/dialog/DialogDescription.vue';
import DialogFooter from '@/components/ui/dialog/DialogFooter.vue';
import DialogHeader from '@/components/ui/dialog/DialogHeader.vue';
import DialogTrigger from '@/components/ui/dialog/DialogTrigger.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { toast } from '@/components/ui/toast';
import { useForm } from '@inertiajs/vue3';
import { PlusIcon } from 'lucide-vue-next';
const form = useForm({
    name: '',
    category: null,
    costPrice: 0,
    sellingPrice: 0,
    stock: 0,
    description: ''
});
const propsData = defineProps({
    categories: Array,
});
const submit = () => {
    form.post(route('products.store'), {
        onSuccess: () => {
            form.reset();
            toast({
                'title': 'Product has been created.',
            });
        },
        onError: () => {
            toast({
                'title': 'Something went wrong while trying to create a product.',
            });
        }
    })
}

</script>