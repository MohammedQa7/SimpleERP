<template>
    <Dialog :open="isOpen">
        <DialogContent :hide-close-button="true" class="sm:max-w-[925px] max-h-[80%] overflow-x-auto">
            <DialogHeader>
                <DialogTitle>New Order</DialogTitle>
            </DialogHeader>

            <!-- Skelaton -->
            <SalesSkelaton v-if="isLoading" />

            <!-- Edit Section -->
            <div v-else class="space-y-6 ">
                <Card class="w-full">
                    <CardContent class="p-6 space-y-6">
                        <div class="space-y-4">
                            <div class="flex flex-col space-y-2">
                                <Label for="order-status">Order status</Label>
                                <!-- Order Status selection -->
                                <Select v-model="form.orderStatus" :disabled="!canUpdate">
                                    <SelectTrigger>
                                        <SelectValue placeholder=" Select a product" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem v-for="(status, index) in orderStatus" :key="index"
                                                :value="status" class="hover:bg-secondary cursor-pointer">
                                                {{ status }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>

                                <InputError :message="form.errors.customerId" />
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="flex flex-col space-y-2">
                                    <Label for="customer">Customer</Label>

                                    <!-- Customer selections Component -->
                                    <CustomerSelect :customers="customers" :pre-selected-customer="preSelectedCustomer"
                                        @bindSelectedCustomer="onBindSelectedCustomer" :disabled="!canUpdate" />

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
                                                                    <Select v-model="item.productId"
                                                                        @update:model-value="updateProduct(item)"
                                                                        :disabled="!canUpdate">
                                                                        <SelectTrigger>
                                                                            <SelectValue
                                                                                placeholder="Select a product" />
                                                                        </SelectTrigger>
                                                                        <SelectContent>
                                                                            <SelectGroup>
                                                                                <SelectItem
                                                                                    v-for="(product, index) in products.data"
                                                                                    :key="index" :value="product.id"
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
                                                                    class="w-20" :disabled="!canUpdate" />

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
                                                                    variant="outline" size="icon"
                                                                    :disabled="!canUpdate">
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
                                                        <Select v-model="item.productId"
                                                            @update:model-value="updateProduct(item)"
                                                            :disabled="!canUpdate">
                                                            <SelectTrigger>
                                                                <SelectValue placeholder="Select a product" />
                                                            </SelectTrigger>
                                                            <SelectContent>
                                                                <SelectGroup>
                                                                    <SelectItem
                                                                        v-for="(product, index) in products.data"
                                                                        :key="index" :value="product.id"
                                                                        class="hover:bg-secondary cursor-pointer">
                                                                        {{ product.name }}
                                                                    </SelectItem>
                                                                </SelectGroup>
                                                            </SelectContent>
                                                        </Select>
                                                    </div>

                                                    <div class="space-y-2">
                                                        <div class="text-sm font-medium text-muted-foreground">
                                                            Product unit price</div>
                                                        ${{ item.product.sellingPrice ?? 0 }}
                                                    </div>

                                                    <div class="space-y-2">
                                                        <div class="text-sm font-medium text-muted-foreground">Quantity
                                                        </div>
                                                        <Input type="number" min="0" v-model.number="item.quantity"
                                                            placeholder="1" class="w-full" :disabled="!canUpdate" />
                                                    </div>

                                                    <div class="space-y-2">
                                                        <div class="text-sm font-medium text-muted-foreground">
                                                            Availability
                                                        </div>
                                                        <Badge v-if="Object.keys(item.product).length > 0" :variant="!checkProductStock(item.product)
                                                            ? 'default' : 'destructive'">

                                                            {{ !checkProductStock(item.product)
                                                                ? 'In stock' : 'Out of stock' }}
                                                        </Badge>
                                                    </div>

                                                    <div class="space-y-2">
                                                        <div class="text-sm font-medium text-muted-foreground">Total
                                                        </div>
                                                        ${{ item.product.sellingPrice ?
                                                            item.product.sellingPrice
                                                            * item.quantity : 0 }}
                                                    </div>

                                                    <div class="pt-2 flex justify-end">
                                                        <Button @click="removeOrderItem(index)" variant="outline"
                                                            :disabled="!canUpdate" size="sm"
                                                            class="flex items-center gap-1">
                                                            <Trash class="h-4 w-4" />
                                                            <span>Remove</span>
                                                        </Button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </CardContent>
                                </Card>
                                <Button @click="addOrderItem" variant="outline" :disabled="!canUpdate">
                                    <Plus class="mr-2 h-4 w-4" />
                                    Add Product
                                </Button>

                            </div>

                            <!-- Order Notes -->
                            <div class="space-y-2">
                                <Label for="notes">Notes</Label>
                                <Textarea v-model="form.notes" placeholder="Add any additional notes here..."
                                    :disabled="!canUpdate" />
                            </div>
                        </div>
                    </CardContent>
                </Card>


                <DialogFooter class="flex items-center justify-between">
                    <div class="text-lg font-semibold">
                        Total: ${{ calculateOrderTotal() }}
                    </div>
                    <div class="flex space-x-2 ">
                        <Button @click.prevent="CloseDialog" variant="outline">Cancel</Button>
                        <div v-if="canUpdate">
                            <Button v-if="!form.isAnyProductOutOfStock" @click.prevent="submit"
                                :disabled="form.processing">
                                {{ form.processing ? 'Updating ...' : 'Update Order' }}
                            </Button>
                            <AlertDialog v-else>
                                <AlertDialogTrigger as-child>
                                    <Button>Update order</Button>
                                </AlertDialogTrigger>
                                <AlertDialogContent>
                                    <AlertDialogHeader>
                                        <AlertDialogTitle><span class="text-destructive"> Product out of stock!</span>,
                                            Are
                                            you absolutely sure?
                                        </AlertDialogTitle>
                                        <AlertDialogDescription>
                                            There is a product that is out of stock, the <b>warehouse</b> will be
                                            notified
                                            to
                                            restock it, and
                                            the order will be placed on <b>hold</b> in the meantime.
                                        </AlertDialogDescription>
                                    </AlertDialogHeader>
                                    <AlertDialogFooter>
                                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                                        <AlertDialogAction @click.prevent="submit" :disabled="form.processing">
                                            {{ form.processing ? 'Updating ...' : 'Yes, I am sure' }}
                                        </AlertDialogAction>
                                    </AlertDialogFooter>
                                </AlertDialogContent>
                            </AlertDialog>
                        </div>
                        <Button v-else disabled>Invoiced</Button>
                    </div>
                </DialogFooter>
            </div>

            <DialogClose @click.prevent="CloseDialog"
                class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-accent data-[state=open]:text-muted-foreground">
                <X class="w-4 h-4" />
                <span class="sr-only">Close</span>
            </DialogClose>

        </DialogContent>
    </Dialog>

</template>

<script setup>
import { ref, onMounted, onUnmounted, watch, computed } from 'vue'
import { Plus, Trash, X } from 'lucide-vue-next'
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
import { closeDialog } from '@/composables/closeDialog'
import DialogClose from '../ui/dialog/DialogClose.vue'
const emit = defineEmits();
const preSelectedCustomer = ref(null);
const hasFetchedData = ref(false); // Track if data was fetched
const form = useForm({
    customerId: null,
    orderDate: null,
    orderItems: [],
    notes: null,
    orderStatus: null,
    isAnyProductOutOfStock: false
});

const propsData = defineProps({
    customers: Object,
    products: Object,
    order: Object,
    orderStatus: Object,
    isOpen: Boolean,
    isLoading: Boolean,
});

// Add a new order item
const addOrderItem = () => {
    form.orderItems.push({
        orderItemId: null,
        productId: null,
        product: {},
        quantity: 1
    })
}

const updateProduct = (item) => {
    item.product = propsData.products.data.find((product) => product.id == item.productId);
    
}

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
        return total;
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


const onBindSelectedCustomer = (customer) => {
    form.customerId = customer.id
}

const onBindCalendarDate = (date) => {
    form.orderDate = date;
}

const canUpdate = computed(() => {
    return propsData.order.data.status == propsData.orderStatus.APPROVED || propsData.order.data.status.replace(/_/g, " ") == propsData.orderStatus.WAITING_FOR_RESTOCK
})


const submit = () => {
    form.put(route('orders.update', { order: propsData.order.data.orderNumber }), {
        onSuccess: () => {
            toast({
                title: 'Changes has been saved',
            })
        },
        onError: () => {
            toast({
                title: 'Something went wrong while updating the order',
            })
        }
    });
}


const CloseDialog = () => {
    form.reset();
    hasFetchedData.value = false;
    closeDialog(emit);

}
const closeOnEscape = (e) => {
    if (e.key === 'Escape') {
        form.reset();
        hasFetchedData.value = false;
        closeDialog(emit);
    }
};


watch(propsData, (newValue) => {
    if (!hasFetchedData.value) {
        preSelectedCustomer.value = newValue.order.data.customer
        form.customerId = newValue.order.data.customer.id;

        form.orderItems = newValue.order.data.orderItems.map(orderItem => ({
            orderItemId: orderItem.id,
            productId: orderItem.product?.id, // Extract the product ID
            ...orderItem,
        }));

        form.notes = newValue.order.data.notes;
        form.orderStatus = newValue.order.data.status;

        hasFetchedData.value = true;
    }
}, { deep: true })

onMounted(() => {
    document.addEventListener('keydown', closeOnEscape);
});

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
})

</script>
