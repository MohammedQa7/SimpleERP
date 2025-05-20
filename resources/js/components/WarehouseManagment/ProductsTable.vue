<template>
    <Card class="mb-6">
        <CardHeader>
            <CardTitle>Products Inventory</CardTitle>
            <CardDescription>
                Manage your product inventory, stock levels, and pricing.
            </CardDescription>
        </CardHeader>
        <CardContent>
            <div v-if="products.data.length > 0" class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b bg-muted/50">
                            <!-- <th class="w-[50px] px-4 py-3 text-left font-medium text-muted-foreground">
                            <Checkbox v-model="selectAll" @update:model-value="toggleSelectAll" />
                        </th> -->
                            <th class="px-4 py-3 text-left font-medium text-muted-foreground">Product</th>
                            <th class="px-4 py-3 text-left font-medium text-muted-foreground">SKU</th>
                            <th class="px-4 py-3 text-left font-medium text-muted-foreground">Category</th>
                            <th class="px-4 py-3 text-right font-medium text-muted-foreground">Stock</th>
                            <th class="px-4 py-3 text-right font-medium text-muted-foreground">Cost Price</th>
                            <th class="px-4 py-3 text-right font-medium text-muted-foreground">Selling Price</th>
                            <th class="px-4 py-3 text-center font-medium text-muted-foreground">Status</th>
                            <th class="px-4 py-3 text-right font-medium text-muted-foreground">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products.data" :key="product.id" class="border-b hover:bg-muted/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-md bg-muted flex items-center justify-center">
                                        <img v-if="product.image" :src="product.image" :alt="product.name"
                                            class="h-10 w-10 rounded-md object-cover" />
                                        <PackageIcon v-else class="h-5 w-5 text-muted-foreground" />
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ product.name }}</p>
                                        <p class="text-xs text-muted-foreground">PROD-ID: {{ product.id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ product.sku }}</td>
                            <td class="px-4 py-3">{{ product.category.name }}</td>
                            <td class="px-4 py-3 text-right">{{ product.stock }}</td>
                            <td class="px-4 py-3 text-right">${{ product.costPrice }}</td>
                            <td class="px-4 py-3 text-right">${{ product.sellingPrice }}</td>
                            <td class="px-4 py-3 text-center">
                                <Badge :variant="getStockStatusVariant(product.stock, 5)">
                                    {{ getStockStatus(product.stock, 5) }}
                                </Badge>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                        <Button variant="ghost" size="icon">
                                            <MoreHorizontalIcon class="h-4 w-4" />
                                            <span class="sr-only">Open menu</span>
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem @click.prevent="toggleEditProductDialog(product.sku)">
                                            <PencilIcon class="mr-2 h-4 w-4" />
                                            Edit
                                        </DropdownMenuItem>
                                        <DropdownMenuItem @click.prevent="editProductStock(product)">
                                            <PackageIcon class="mr-2 h-4 w-4" />
                                            Adjust Stock
                                        </DropdownMenuItem>
                                        <DropdownMenuItem @click.prevent="getProductHistory(product)">
                                            <HistoryIcon class="mr-2 h-4 w-4" />
                                            View History
                                        </DropdownMenuItem>
                                        <DropdownMenuSeparator />
                                        <DropdownMenuItem class=" text-red-500 focus:text-red-500">
                                            <TrashIcon class="mr-2 h-4 w-4" />
                                            Delete
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </td>
                        </tr>
                        <tr v-if="products.length === 0">
                            <td colspan="8" class="h-24 text-center px-4 py-3 text-muted-foreground">
                                No products found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div v-else
                class="mt-8 flex flex-col items-center justify-center rounded-lg border-2 border-dashed  border-muted-foreground bg-muted p-12 text-center">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-50">
                    <Package class="h-10 w-10 text-primary-foreground" />
                </div>
                <h3 class="mt-4 text-lg font-medium text-primary">No products found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating your first product.</p>
            </div>
        </CardContent>

        <CustomPagination :item="products" />
    </Card>

    <EditProductDialog v-if="showEditDialog" :product="editableProduct" :categories="categories.data"
        :is-loading="isLoading" :is-open="showEditDialog" @update:open="showEditDialog = $event" />

    <StockAdjustmentDialog v-if="showStockAdjustment" :product="editableProduct" :is-open="showStockAdjustment"
        @update:open="showStockAdjustment = $event" />
</template>


<script setup>
import { HistoryIcon, MoreHorizontalIcon, Package, PackageIcon, PencilIcon, TrashIcon } from 'lucide-vue-next';
import Card from '../ui/card/Card.vue';
import CardContent from '../ui/card/CardContent.vue';
import CardDescription from '../ui/card/CardDescription.vue';
import CardHeader from '../ui/card/CardHeader.vue';
import CardTitle from '../ui/card/CardTitle.vue';
import Button from '../ui/button/Button.vue';
import Badge from '../ui/badge/Badge.vue';
import DropdownMenu from '../ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '../ui/dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '../ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '../ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuSeparator from '../ui/dropdown-menu/DropdownMenuSeparator.vue';
import CustomPagination from '../CustomPagination.vue';
import StockAdjustmentDialog from './StockAdjustmentDialog.vue';
import { ref } from 'vue';
import EditProductDialog from './EditProductDialog.vue';
import { router } from '@inertiajs/vue3';
import { toast } from '../ui/toast';
const showStockAdjustment = ref(false);
const showEditDialog = ref(false);
const editableProduct = ref(null);
const isLoading = ref(false);
const propsData = defineProps({
    products: Array,
    categories: Array,
});


const toggleEditProductDialog = (productSku) => {
    isLoading.value = true;
    showEditDialog.value = true;
    router.visit(route('products.edit', { product: productSku }), {
        only: ['product'],
        preserveScroll: true,
        preserveState: true,
        preserveUrl: true,
        onSuccess: (page) => {
            editableProduct.value = page.props.product.data;
            isLoading.value = false;
        },
        onError: () => {
            showEditDialog.value = false;
            isLoading.value = false;
        }
    })
}

const editProductStock = (product) => {
    showStockAdjustment.value = true;
    editableProduct.value = product
}
const getStockStatusVariant = (stock, threshold) => {
    if (stock === 0) return 'destructive'
    if (stock <= threshold) return 'default'
    return 'outline'
}

const getStockStatus = (stock, threshold) => {
    if (stock === 0) return 'Out of Stock'
    if (stock <= threshold) return 'Low Stock'
    return 'In Stock'
}

const getProductHistory = (product) => {
    router.get(route('product.history', { product: product.sku }), {}, {
        onError: () => {
            toast({
                title: 'Something went wrong.'
            })
        }
    });
}

</script>