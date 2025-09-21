<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button :disabled="isDisabled" variant="outline" size="sm">
                <Download class="mr-2 h-4 w-4" />
                Export
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent class="w-56">
            <DropdownMenuLabel>Export Options</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuGroup>
                <DropdownMenuItem @click.prevent="exportRecords(ExportModules.ATTENDANCE_LOGS, ExportTypes.CSV)">
                    <FileText />
                    <span>Export as CSV</span>
                </DropdownMenuItem>
                <DropdownMenuItem @click.prevent="exportRecords(ExportModules.ATTENDANCE_LOGS, ExportTypes.PDF)">
                    <File />
                    <span>Export as PDF</span>
                </DropdownMenuItem>
            </DropdownMenuGroup>
        </DropdownMenuContent>
    </DropdownMenu>

</template>


<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue'
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue'
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue'
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue'
import DropdownMenuLabel from '@/components/ui/dropdown-menu/DropdownMenuLabel.vue'
import DropdownMenuSeparator from '@/components/ui/dropdown-menu/DropdownMenuSeparator.vue'
import DropdownMenuGroup from '@/components/ui/dropdown-menu/DropdownMenuGroup.vue'
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue'
import { Download, File, FileText } from 'lucide-vue-next'
import { ExportModules } from '@/enums/ExportModules'
import { ExportTypes } from '@/enums/ExportTypes'
import { toast, useToast } from './ui/toast'
import axios from 'axios'
const propsData = defineProps({
    isDisabled: Boolean,
});

const exportRecords = (module: ExportModules, type: ExportTypes) => {
    const { id } = toast({
        duration: Infinity,
        title: 'Exporting...',
        loader: true,
        description: 'Preparing your file for download.',
    });

    axios.get(route('export', { module, type, _query: route().params }), {
        responseType: 'blob'
    })
        .then((response) => {
            const fileName = response.headers['content-disposition'];
            const fileNameMatch = fileName.match(/filename\*?=(?:UTF-8'')?"?([^"]+)"?/);
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.download = fileNameMatch[1];
            link.click();

            toast({
                id: id,
                title: 'Success!',
                description: 'Your file has been exported.',
                variant: 'default',
                duration: 3000,
            });
        })
        .catch((error) => {
            console.log(error);

            toast({
                id: id,
                title: 'Error',
                description: 'Export failed. Please try again.',
                variant: 'destructive',
                duration: 5000,
            });
        });
}
</script>