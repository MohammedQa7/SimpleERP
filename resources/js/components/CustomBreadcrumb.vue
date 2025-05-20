<template>
    <Breadcrumb>
        <BreadcrumbList>
            <BreadcrumbItem v-for="(breadcrumb, index) in breadcrumbs" :key="index">
                <Link :href="breadcrumb.route">
                {{ breadcrumb.name }}
                </Link>

                <BreadcrumbSeparator v-if="index != breadcrumbs.length - 1">
                    <Slash />
                </BreadcrumbSeparator>
            </BreadcrumbItem>

        </BreadcrumbList>
    </Breadcrumb>
</template>

<script setup>
import { Slash } from 'lucide-vue-next'
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb'
const propsData = defineProps({
    breadcrumbs: Array,
});
</script>
