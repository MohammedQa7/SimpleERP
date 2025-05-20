<template>
    <div class="flex items-center gap-2">
        <div class="flex items-center  text-sm">
            <h1 class="text-xl font-semibold"> Change History -> {{ product.data.name }} </h1>
        </div>
    </div>

    <!-- Filters -->
    <Filters :users="users" :product="product" :queryString="filters" @bindLoadingStatus="bindLoadingStatus" />


    <div class="relative">
        <!-- Product changes -->
        <div v-for="(history, index) in productHistory.data" :key="index" class="group">
            <Collapsible class="w-full">
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-muted/50 transition-colors">
                    <!-- Icon with status indicator -->
                    <div class="relative mt-0.5">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-background border border-border">
                            <CircleDotDashed />
                        </div>
                        <div
                            class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-2 border-background bg-emerald-500">
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <h3 class="font-medium text-sm">{{ history.product.name }}</h3>
                                <span class="text-xs text-muted-foreground">{{ history.createdAt }}</span>
                                <Badge variant="outline" class="text-xs px-1.5 h-5">
                                    {{ Object.keys(history.changes).length }} {{ Object.keys(history.changes).length ===
                                        1 ? 'change' :
                                        'changes' }}
                                </Badge>
                            </div>
                            <div class="flex items-center gap-1">
                                <CollapsibleTrigger asChild>
                                    <Button variant="ghost" size="icon" class="h-7 w-7">
                                        <ChevronDown
                                            class="h-3.5 w-3.5 transition-transform duration-200 ui-expanded:rotate-180" />
                                    </Button>
                                </CollapsibleTrigger>
                            </div>
                        </div>

                        <!-- <p class="text-sm text-muted-foreground">{{ change.description }}</p> -->

                        <div class="mt-1 flex items-center gap-2 text-xs text-muted-foreground">
                            <div class="flex items-center gap-1">
                                <User class="h-3 w-3" />
                                <span>{{ history.user.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <CollapsibleContent>
                    <div class="ml-11 mr-3 mb-3 border-l border-border/60 pl-4 space-y-3">
                        <div v-for="(value, field) in history.changes" class="pt-2">
                            <div class="flex items-start gap-2">
                                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-muted">
                                    <component :is="getChangeIcon(field)" class="h-3 w-3 text-muted-foreground" />
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <h4 class="text-xs font-medium">{{ field }}</h4>
                                    </div>

                                    <!-- Different display based on change type -->
                                    <div class="mt-1">
                                        <!-- Default display for other types -->
                                        <div class="flex items-center gap-1.5 text-xs">
                                            <span class="text-muted-foreground line-through">
                                                {{ field.toLowerCase() == 'cost price' ? '$' : '' }}
                                                {{ value.oldValue }}</span>
                                            <ArrowRight class="h-3 w-3 text-muted-foreground" />
                                            <span class="font-medium">
                                                {{ field.toLowerCase() == 'cost price' ? '$' : '' }}
                                                {{ value.newValue }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </CollapsibleContent>
            </Collapsible>
        </div>

        <!-- Loading overlay -->
        <Transition name="fade">
            <div v-if="isLoading"
                class="absolute inset-0 bg-background/70 backdrop-blur-[1px] flex items-center justify-center z-10 rounded-lg">
                <div class="flex flex-col items-center gap-2">
                    <Loader2 class="h-8 w-8 animate-spin text-primary" />
                    <!-- <span v-if="loadingText" class="text-sm font-medium">{{ loadingText }}</span> -->
                </div>
            </div>
        </Transition>
    </div>


</template>


<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, computed, onMounted } from 'vue'
import { Image as ImageIcon, Tag, Eye, GitCompare, ArrowRight, User, ChevronDown, CircleDotDashed, DollarSign, Package, FileText, Settings, ChevronRight, Menu, Loader2 } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible'
import Filters from '@/components/WarehouseManagment/ProductHistory/Filters.vue';
const isLoading = ref(false);
const propsData = defineProps({
    product: Object,
    productHistory: Array,
    users: Array,
    filters: Array,
});


const getChangeIcon = (type) => {
    switch (type.toLowerCase()) {
        case 'cost price': return DollarSign
        case 'selling price': return Package
        case 'name': return FileText
        case 'category': return Tag
        default: return Settings
    }
}

const bindLoadingStatus = (loadingStatus) => {
    isLoading.value = loadingStatus;
}



defineOptions({
    layout: AppLayout,
})
</script>