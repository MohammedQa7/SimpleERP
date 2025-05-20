<template>
    <Card>
        <CardContent class="p-6 space-y-6">
            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <Skeleton class="h-8  bg-secondary" />
                    </div>
                </div>

                <!-- List of products -->
                <div class="space-y-2">
                    <Skeleton class="h-52   bg-secondary" />

                </div>


                <div class="space-y-2">
                    <Skeleton class="h-24 bg-secondary" />
                </div>
            </div>
        </CardContent>

    </Card>
    <DialogFooter class="flex items-center justify-end">
        <div class="flex space-x-2 w-1/3">
            <Skeleton class=" h-3 w-full bg-secondary" />
            <Skeleton class="h-3 w-full bg-secondary" />
        </div>
    </DialogFooter>
</template>

<script setup>
import Card from '@/components/ui/card/Card.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import Skeleton from '@/components/ui/skeleton/Skeleton.vue'
</script>