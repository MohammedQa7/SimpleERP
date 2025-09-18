<template>
    <Dialog :open="isOpen" @update:open="isDialogOpened = $event">
        <DialogContent class="max-h-[650px] overflow-hidden overflow-y-auto ">

            <!-- Providers / Connected Apps content -->
            <component v-if="providerKey && providerFolderName" :is="componentToRender" :provider="providerKey" />

            <Empty v-if="!componentToRender">
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <CandyOff />
                    </EmptyMedia>
                    <EmptyTitle>Something went wrong!</EmptyTitle>
                    <EmptyDescription>
                        We couldn't process your request. Please try again later.
                    </EmptyDescription>
                </EmptyHeader>
            </Empty>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import { ref, computed } from 'vue'
import {
    Dialog,
    DialogContent,
} from '@/components/ui/dialog'
import { getProviderDialog, resolveProviderDialog } from '.';
import EmptyHeader from '../ui/empty/EmptyHeader.vue';
import EmptyTitle from '../ui/empty/EmptyTitle.vue';
import EmptyDescription from '../ui/empty/EmptyDescription.vue';
import Empty from '../ui/empty/Empty.vue';
import { CandyOff } from 'lucide-vue-next';
const propsData = defineProps({
    isOpen: Boolean,
    isLoading: Boolean,
    providerKey: String,
    providerFolderName: String
})
const isDialogOpened = computed(() => {
    return propsData.isOpen;
})

const componentToRender = resolveProviderDialog(propsData.providerFolderName, getProviderDialog[propsData.providerKey]);



</script>
