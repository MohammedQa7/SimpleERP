<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button @click.prevent="loadCustomerAndProducts">
                <Plus class="mr-2 h-4 w-4" />
                New Order
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[925px] max-h-[80%] overflow-x-auto">
            <DialogHeader>
                <DialogTitle>New Order</DialogTitle>
            </DialogHeader>

            <!-- Skelaton -->
            <SalesSkelaton v-if="isLoading" />

            <!--  -->
            <div v-else class="space-y-6 ">
                <Card class="w-full">
                    <CardContent class="p-6 space-y-6">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="flex flex-col space-y-2">
                                    <Label for="customer">Customer</Label>

                                    <!-- Customer selections Component -->
                                    <CustomerSelect :customers="customers"
                                        @bindSelectedCustomer="onBindSelectedCustomer" />

                                    <InputError :message="form.errors.customerId" />
                                </div>

                                <!-- Calendar -->
                                <div class="flex flex-col space-y-2">
                                    <Label for="date">Order Date</Label>
                                    <!-- Calendar Customm Component -->
                                    <Calendar @bindCalendarDate="onBindCalendarDate" />
                                    <InputError :message="form.errors.orderDate" />
                                </div>
                            </div>

                            <!-- List of products -->
                            <div class="space-y-2  overflow-y-auto">
                                <Label>Products</Label>
                                <Card>
                                    <CardContent class="p-0">
                                        <div class="w-full">
                                            <!-- Desktop Table (hidden on small screens) -->
                                            <div class="hidden md:block overflow-auto">
                                                <table class="w-full border-collapse">
                                                    <thead>
                                                        <tr class="border-b text-sm font-medium text-muted-foreground">
                                                            <th class="p-4 text-left">Product</th>
                                                            <th class="p-4 text-left">Price (Per item)</th>
                                                            <th class="p-4 text-left">Quantity</th>
                                                            <th class="p-4 text-left">Availability</th>
                                                            <th class="p-4 text-left">Total</th>
                                                            <th class="p-4 text-left">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y">
                                                        <!-- Product selection list -->
                                                        <tr v-for="(item, index) in form.orderItems" :key="index"
                                                            class="items-center">
                                                            <td class="p-4">
                                                                <div class="relative">
                                                                    <Select v-model="item.product">
                                                                        <SelectTrigger>
                                                                            <SelectValue
                                                                                placeholder="Select a product" />
                                                                        </SelectTrigger>
                                                                        <SelectContent>
                                                                            <SelectGroup>
                                                                                <SelectItem
                                                                                    v-for="(product, index) in products.data"
                                                                                    :key="index" :value="product"
                                                                                    class="hover:bg-secondary cursor-pointer">
                                                                                    {{ product.name }}
                                                                                </SelectItem>
                                                                            </SelectGroup>
                                                                        </SelectContent>
                                                                    </Select>
                                                                </div>
                                                                <InputError
                                                                    :message="form.errors[`orderItems.${index}.product.sku`]" />
                                                            </td>

                                                            <!-- Product price -->
                                                            <td class="p-4">
                                                                <h1>
                                                                    ${{ item.product.sellingPrice ?? 0 }}
                                                                </h1>

                                                            </td>

                                                            <!-- product qunaitity -->
                                                            <td class="p-4">
                                                                <Input type="number" min="1"
                                                                    v-model.number="item.quantity" placeholder="1"
                                                                    class="w-20" />

                                                                <InputError
                                                                    :message="form.errors[`orderItems.${index}.quantity`]" />
                                                            </td>

                                                            <!-- product stock availability -->
                                                            <td class="p-4">
                                                                <Badge v-if="Object.keys(item.product).length > 0"
                                                                    :variant="!checkProductStock(item.product)
                                                                        ? 'default' : 'destructive'">

                                                                    {{ !checkProductStock(item.product)
                                                                        ? 'In stock' : 'Out of stock' }}
                                                                </Badge>
                                                            </td>

                                                            <!-- Product total price -->
                                                            <td class="p-4">
                                                                ${{ item.product.sellingPrice ?
                                                                    item.product.sellingPrice
                                                                    * item.quantity : 0 }}
                                                            </td>

                                                            <!-- Remove prduct -->
                                                            <td class="p-4">
                                                                <Button @click="removeOrderItem(index)"
                                                                    variant="outline" size="icon">
                                                                    <Trash class="h-4 w-4" />
                                                                    <span class="sr-only">Remove</span>
                                                                </Button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Mobile Card Layout (visible only on small screens) -->
                                            <div class="md:hidden space-y-4">
                                                <div v-for="(item, index) in form.orderItems" :key="index"
                                                    class="border rounded-lg p-4 shadow-sm space-y-3">
                                                    <div class="space-y-2">
                                                        <div class="text-sm font-medium text-muted-foreground">Product
                                                        </div>
                                                        <Select v-model="item.product" class="w-full">
                                                            <SelectTrigger>
                                                                <SelectValue placeholder="Select a product" />
                                                            </SelectTrigger>
                                                            <SelectContent>
                                                                <SelectGroup>
                                                                    <SelectItem value="apple">Apple</SelectItem>
                                                                </SelectGroup>
                                                            </SelectContent>
                                                        </Select>
                                                    </div>

                                                    <div class="space-y-2">
                                                        <div class="text-sm font-medium text-muted-foreground">Price
                                                            (Per
                                                            item)</div>
                                                        <div>Product unit price</div>
                                                        <!-- <div>{{ (item.price).toFixed(2) }}</div> -->
                                                    </div>

                                                    <div class="space-y-2">
                                                        <div class="text-sm font-medium text-muted-foreground">Quantity
                                                        </div>
                                                        <Input type="number" min="0" v-model.number="item.quantity"
                                                            placeholder="1" class="w-full" />
                                                    </div>

                                                    <div class="space-y-2">
                                                        <div class="text-sm font-medium text-muted-foreground">
                                                            Availability
                                                        </div>
                                                        <Badge :variant="'secondary'">In stock</Badge>
                                                    </div>

                                                    <div class="space-y-2">
                                                        <div class="text-sm font-medium text-muted-foreground">Total
                                                        </div>
                                                        <div>total amount</div>
                                                        <!-- <div>{{ (item.price * item.quantity).toFixed(2) }}</div> -->
                                                    </div>

                                                    <div class="pt-2 flex justify-end">
                                                        <Button @click="removeOrderItem(index)" variant="outline"
                                                            size="sm" class="flex items-center gap-1">
                                                            <Trash class="h-4 w-4" />
                                                            <span>Remove</span>
                                                        </Button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </CardContent>
                                </Card>
                                <Button @click="addOrderItem" variant="outline">
                                    <Plus class="mr-2 h-4 w-4" />
                                    Add Product
                                </Button>

                            </div>

                            <!-- Order Notes -->
                            <div class="space-y-2">
                                <Label for="notes">Notes</Label>
                                <Textarea v-model="form.notes" placeholder="Add any additional notes here..." />
                            </div>
                        </div>
                    </CardContent>
                </Card>


                <DialogFooter class="flex items-center justify-between">
                    <div class="text-lg font-semibold">
                        Total: ${{ calculateOrderTotal() }}
                    </div>
                    <div class="flex space-x-2 ">
                        <DialogClose>
                            <Button variant="outline">Cancel</Button>
                        </DialogClose>
                        <Button v-if="!form.isAnyProductOutOfStock" @click.prevent="submit">Create Order</Button>
                        <AlertDialog v-else>
                            <AlertDialogTrigger as-child>
                                <Button>Create Order</Button>
                            </AlertDialogTrigger>
                            <AlertDialogContent>
                                <AlertDialogHeader>
                                    <AlertDialogTitle><span class="text-destructive"> Product out of stock!</span>, Are
                                        you absolutely sure?
                                    </AlertDialogTitle>
                                    <AlertDialogDescription>
                                        There is a product that is out of stock, the <b>warehouse</b> will be notified
                                        to
                                        restock it, and
                                        the order will be placed on <b>hold</b> in the meantime.
                                    </AlertDialogDescription>
                                </AlertDialogHeader>
                                <AlertDialogFooter>
                                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                                    <AlertDialogAction @click.prevent="submit">Yes, I am sure</AlertDialogAction>
                                </AlertDialogFooter>
                            </AlertDialogContent>
                        </AlertDialog>
                    </div>
                </DialogFooter>
            </div>
        </DialogContent>
    </Dialog>

</template>

<script setup>
import { ref, computed } from 'vue'
import {
    Plus,
    Trash,
    CalendarIcon
} from 'lucide-vue-next'

import Card from '@/components/ui/card/Card.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import Button from '@/components/ui/button/Button.vue'
import Textarea from '@/components/ui/textarea/Textarea.vue'
import Select from '@/components/ui/select/Select.vue'
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue'
import SelectValue from '@/components/ui/select/SelectValue.vue'
import SelectContent from '@/components/ui/select/SelectContent.vue'
import SelectGroup from '@/components/ui/select/SelectGroup.vue'
import SelectItem from '@/components/ui/select/SelectItem.vue'
import Input from '@/components/ui/input/Input.vue'
import Dialog from '../ui/dialog/Dialog.vue'
import DialogTrigger from '../ui/dialog/DialogTrigger.vue'
import DialogContent from '../ui/dialog/DialogContent.vue'
import DialogHeader from '../ui/dialog/DialogHeader.vue'
import DialogTitle from '../ui/dialog/DialogTitle.vue'
import Badge from '../ui/badge/Badge.vue'
import { router, useForm } from '@inertiajs/vue3'
import SalesSkelaton from './SalesSkelaton.vue'
import AlertDialog from '../ui/alert-dialog/AlertDialog.vue'
import AlertDialogTrigger from '../ui/alert-dialog/AlertDialogTrigger.vue'
import AlertDialogContent from '../ui/alert-dialog/AlertDialogContent.vue'
import AlertDialogHeader from '../ui/alert-dialog/AlertDialogHeader.vue'
import AlertDialogDescription from '../ui/alert-dialog/AlertDialogDescription.vue'
import AlertDialogFooter from '../ui/alert-dialog/AlertDialogFooter.vue'
import AlertDialogCancel from '../ui/alert-dialog/AlertDialogCancel.vue'
import AlertDialogAction from '../ui/alert-dialog/AlertDialogAction.vue'
import InputError from '../InputError.vue'
import { toast } from '@/components/ui/toast'
import CustomerSelect from '../CustomerSelect.vue'
import Calendar from '../Calendar.vue'
import DialogClose from '../ui/dialog/DialogClose.vue'
const isLoading = ref(false);
const customers = ref([]);
const products = ref([]);
const selectedCustomer = ref(null);
const form = useForm({
    customerId: null,
    orderDate: null,
    orderItems: [
        {
            product: {},
            quantity: 1
        }
    ],
    notes: null,
    isAnyProductOutOfStock: false,
})


// Add a new order item
const addOrderItem = () => {
    form.orderItems.push({
        product: {},
        quantity: 1
    })
}

// Update the product object when selecting a new product because we are storting a product_id directly from the select in order to make it work on the edit page so that the pre-selected item can be binded correctly 

// Remove an order item
const removeOrderItem = (index) => {
    form.orderItems.splice(index, 1)
    if (form.orderItems.length === 0) {
        addOrderItem()
    }
}

// Calculate order total
const calculateOrderTotal = () => {
    return form.orderItems.reduce((total, item) => {
        if (Object.keys(item.product).length > 0) {
            return total + (Number(item.product.sellingPrice) * Number(item.quantity))
        }
        return 0;
    }, 0).toFixed(2)
}

const productStockMap = computed(() => {
    const stockMap = {}; // Store total quantity per product SKU
    form.isAnyProductOutOfStock = false;

    form.orderItems.forEach(item => {
        if (item.product?.sku) {
            stockMap[item.product.sku] = (stockMap[item.product.sku] || 0) + item.quantity;

            // If any product is out of stock, update the flag
            if (stockMap[item.product.sku] > item.product.stock) {
                form.isAnyProductOutOfStock = true;
            }
        }
    });

    return stockMap; // Return the computed map
});

const checkProductStock = (product) => {
    return (productStockMap.value[product.sku] || 0) > product.stock;
}



const loadCustomerAndProducts = () => {
    isLoading.value = true;
    router.visit(route('orders.create'), {
        only: ['customers', 'products'],
        preserveScroll: true,
        preserveState: true,
        preserveUrl: true,
        onSuccess: (page) => {
            isLoading.value = false;
            customers.value = page.props.customers;
            products.value = page.props.products;
        },
        onError: () => {
            isLoading.value = false;
        }
    })
}


const onBindSelectedCustomer = (customer) => {
    form.customerId = customer.id
}

const onBindCalendarDate = (date) => {
    form.orderDate = date;
    console.log(form.orderDate);

}


const submit = () => {
    form.post(route('orders.store'), {
        onSuccess: () => {
            form.reset();
            selectedCustomer.value = null;
            toast({
                title: 'The order has been successfully placed.',
            })
        }
    });
}




</script>
