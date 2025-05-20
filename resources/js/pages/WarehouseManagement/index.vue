<template>
    <Toaster />
    <div class="container">
        <!-- Header -->
        <header class="border-b">
            <div class="flex h-16 items-center ">
                <h1 class="text-xl font-semibold">Inventory Management</h1>
                <div class="ml-auto flex items-center gap-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <Button variant="ghost" size="icon" @click="showAllNotifications" class="relative">
                            <BellIcon class="h-5 w-5" />
                            <span
                                class="absolute top-1 right-1 flex h-3 w-3 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                            </span>
                            <span class="sr-only">Notifications</span>
                        </Button>
                    </div>
                    
                    <!-- Create Product Dialog -->
                    <CreateProductDialog :categories="categories.data" />


                    <Button @click="openImportDialog" variant="outline">
                        <UploadIcon class="mr-2 h-4 w-4" />
                        Import
                    </Button>
                    <Button @click="exportData" variant="outline">
                        <DownloadIcon class="mr-2 h-4 w-4" />
                        Export
                    </Button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            <!-- Stock Requests Alert -->
            <RequestAlerts v-if="pendingRequests > 0" :pending-stock-requests="pendingRequests" />

            <!-- Inventory Stats -->
            <InventoryStatus :product-summary="productSummary" />

            <!-- Filters and Search -->
            <FilterAndSearch :categories="categories" :filters="filters" />

            <!-- Products Table -->
            <ProductsTable :products="products" :categories="categories" />

        </main>
    </div>

    <!-- Notificaion dialog -->
    <NotificaionDialog v-if="openNotificaionDialog" :is-open="openNotificaionDialog" :is-loading="isLoading"
        :notificaions="notificaionRequests" @update:open="openNotificaionDialog = $event" />
</template>

<script setup>
import { ref, reactive } from 'vue'
import { UploadIcon, DownloadIcon, BellIcon, } from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import ProductsTable from '@/components/WarehouseManagment/ProductsTable.vue'
import RequestAlerts from '../../components/WarehouseManagment/RequestAlerts.vue'
import InventoryStatus from '../../components/WarehouseManagment/InventoryStatus.vue'
import FilterAndSearch from '../../components/WarehouseManagment/FilterAndSearch.vue'
import CreateProductDialog from '../../components/WarehouseManagment/CreateProductDialog.vue'
import NotificaionDialog from '../../components/WarehouseManagment/NotificationDialog.vue'
import axios from 'axios'
import { toast, Toaster } from '@/components/ui/toast'
const openNotificaionDialog = ref(false);
const notificaionRequests = ref([]);
const isLoading = ref(false);
const propsData = defineProps({
    products: Array,
    categories: Array,
    productSummary: Object,
    pendingRequests: Boolean,
    filters: Array,
});

const showAllNotifications = () => {
    isLoading.value = true;
    openNotificaionDialog.value = true;
    axios.get(route('warehouse.notificaions'))
        .then((response) => {
            isLoading.value = false;
            notificaionRequests.value = response.data.notificaion_requests;
        })
        .catch((error) => {
            openNotificaionDialog.value = false;
            toast({
                title: 'Something went wrong.'
            })
        })
}



defineOptions({
    layout: AppLayout,
});
</script>