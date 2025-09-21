<script setup lang="ts">
import { isVNode } from 'vue'
import { Toast, ToastClose, ToastDescription, ToastProvider, ToastTitle, ToastViewport } from '.'
import { useToast } from './use-toast'
import { CheckCircle, Loader } from 'lucide-vue-next'

const { toasts } = useToast()
</script>

<template>
  <ToastProvider>
    <Toast v-for="toast in toasts" :key="toast.id" v-bind="toast">
      <div class="flex items-center gap-2">
        <Loader v-if="toast.loader" class="animate-spin" />
        <CheckCircle v-if="toast.variant == 'success'" />
        <div class="grid">
          <ToastTitle v-if="toast.title">
            {{ toast.title }}
          </ToastTitle>
          <template v-if="toast.description">
            <ToastDescription v-if="isVNode(toast.description)">
              <component :is="toast.description" />
            </ToastDescription>
            <ToastDescription v-else>
              {{ toast.description }}
            </ToastDescription>
          </template>
          <ToastClose />
        </div>
      </div>

      <component :is="toast.action" />
    </Toast>
    <ToastViewport />
  </ToastProvider>
</template>
