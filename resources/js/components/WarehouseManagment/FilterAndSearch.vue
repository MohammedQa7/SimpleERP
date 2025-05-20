<template>
    <div class="mb-6 grid gap-4 md:grid-cols-4">
        <div class="space-y-2">
            <Label for="search">Search Products</Label>
            <Input v-model="filters.search" id="search" placeholder="Search by name, SKU..." />
        </div>
        <div class="space-y-2">
            <Label for="category">Category</Label>
            <Select v-model="filters.category">
                <SelectTrigger id="product-category">
                    <SelectValue placeholder="Select Category" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem @select="filters.category = null">
                        All categories
                    </SelectItem>
                    <SelectItem v-for="category in categories.data" :key="category.slug" :value="category.slug">
                        {{ category.name }}
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>
        <div class="space-y-2">
            <Label for="stock-status">Stock Status</Label>
            <Select v-model="filters.stockStatus">
                <SelectTrigger id="stock-status">
                    <SelectValue placeholder="All Status" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="all">All Status</SelectItem>
                    <SelectItem value="in-stock">In Stock</SelectItem>
                    <SelectItem value="low-stock">Low Stock</SelectItem>
                    <SelectItem value="out-of-stock">Out of Stock</SelectItem>
                </SelectContent>
            </Select>
        </div>
        <div class="space-y-2">
            <Label for="sort-by">Sort By</Label>
            <Select v-model="filters.sortBy">
                <SelectTrigger id="sort-by">
                    <SelectValue placeholder="Sort By" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="name-asc">Name (A-Z)</SelectItem>
                    <SelectItem value="name-desc">Name (Z-A)</SelectItem>
                    <SelectItem value="stock-asc">Stock (Low to High)</SelectItem>
                    <SelectItem value="stock-desc">Stock (High to Low)</SelectItem>
                    <SelectItem value="price-asc">Price (Low to High)</SelectItem>
                    <SelectItem value="price-desc">Price (High to Low)</SelectItem>
                </SelectContent>
            </Select>
        </div>
    </div>
</template>

<script setup>
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import { onMounted, ref, watch } from 'vue';
import { debounce } from 'lodash';
import { router } from '@inertiajs/vue3';
const propsData = defineProps({
    categories: Object,
    filters: Object,
});
const filters = ref({
    search: '',
    category: '',
    stockStatus: null,
    sortBy: null,
});

const submitFilter = debounce(() => {
    router.get(route('products.index', filters.value), {}, {
        preserveScroll: true,
        preserveState: true
    });

}, 500)

watch(filters, () => {
    submitFilter();
}, { deep: true })


onMounted(() => {
    filters.value = { ...propsData.filters };
    console.log(filters.value);

})

</script>