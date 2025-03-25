<template>
  <div class="w-full  p-6 space-y-8 bg-card rounded-lg border shadow-sm">
    <!-- Invoice Header Skeleton -->
    <div class="flex flex-col md:flex-row justify-between gap-6">
      <!-- Company Info -->
      <div class="space-y-3">
        <Skeleton class="h-8 w-[180px]" />
        <div class="space-y-2">
          <Skeleton class="h-4 w-[250px]" />
        </div>
      </div>

      <!-- Invoice Details -->
      <div class="space-y-3">
        <Skeleton class="h-10 w-[150px] ml-auto" />
        <div class="space-y-2">
          <div class="flex items-center justify-between gap-3">
            <Skeleton class="h-4 w-[100px]" />
            <Skeleton class="h-4 w-[120px]" />
          </div>
        </div>
      </div>
    </div>

    <!-- Client Info Skeleton -->
    <div class="space-y-3">
      <Skeleton class="h-5 w-[100px]" />
      <div class="space-y-2">
        <Skeleton class="h-4 w-[180px]" />
      </div>
    </div>

    <!-- Invoice Items Table Skeleton -->
    <div class="space-y-3">
      <Skeleton class="h-5 w-[120px]" />
      <div class="border rounded-md overflow-hidden">
        <!-- Table Header -->
        <div class="grid grid-cols-12 gap-2 p-4 bg-muted text-xs font-medium text-muted-foreground uppercase">
          <div class="col-span-6">
            <Skeleton class="h-4 w-[80px]" />
          </div>

        </div>

        <!-- Table Rows -->
        <div v-for="i in 4" :key="i" class="grid grid-cols-12 gap-2 p-4 border-t">
          <div class="col-span-6 space-y-2">
            <Skeleton class="h-4 w-full" />
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Skeleton } from '@/components/ui/skeleton'

</script>