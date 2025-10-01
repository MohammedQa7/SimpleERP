<template>
    <Dialog :open="isOpen" @update:open="isOpen = $event; resetFileUpload();">
        <DialogContent class="max-w-[600px] bg-gray-100/90 p-1">
            <div class="bg-white shadow-2xl py-8  px-10 sm:px-16 rounded">
                <div class="dialog-custom-header ">
                    <h1 class="text-center text-xl font-medium">New project</h1>
                    <p class="w-full mt-3 space-y-3 text-sm text-center">
                        Set up your new company and get your ERP ready in seconds.
                    </p>
                </div>

                <div class="new-project-form mt-6">
                    <form class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class=" space-y-1">
                                <Label>Company name</Label>
                                <Input v-model="form.companyName" />
                            </div>
                            <div class=" space-y-1">
                                <Label>Site url</Label>
                                <Input :placeholder="siteUrl" disabled />
                            </div>
                        </div>
                        <div class="file-upload ">
                            <Label>Upload your logo (max: 12*12 )</Label>
                            <div class="flex items-center space-y-1 gap-4">
                                <Input id="picture" accept="image/*" type="file" @change="handleFileUpload" />
                                <div class=" w-24 h-12 border rounded-lg overflow-hidden">
                                    <img v-if="imagePreview" class="w-full h-12 " :src="imagePreview"
                                        alt="'company logo'"></img>
                                    <h1 v-else class="text-xs p-1">
                                        Image Placeholder
                                    </h1>
                                </div>
                            </div>

                        </div>
                    </form>
                    <div class="flex justify-end items-center gap-4 mt-8">
                        <DialogClose>
                            <Button variant="outline" class="hover:bg-gray-200">Close</Button>
                        </DialogClose>
                        <Button class=" bg-website-primary hover:bg-website-primary/80  w-40">New
                            project</Button>
                    </div>
                </div>
            </div>
        </DialogContent>
    </Dialog>

    <SetupCompanyTenantLoader />
</template>

<script setup>
import { computed, ref } from 'vue';
import Button from '../ui/button/Button.vue';
import Dialog from '../ui/dialog/Dialog.vue';
import DialogClose from '../ui/dialog/DialogClose.vue';
import DialogContent from '../ui/dialog/DialogContent.vue';
import Input from '../ui/input/Input.vue';
import Label from '../ui/label/Label.vue';
import { useForm } from '@inertiajs/vue3';
import SetupCompanyTenantLoader from './SetupCompanyTenantLoader.vue';
const propsData = defineProps({
    isOpen: Boolean
});
const imagePreview = ref(null);
const form = useForm({
    companyName: 'test',
    companyLogo: null,
});

const siteUrl = computed(() => {
    return 'www.' + form.companyName + '.lomen.com'
})

const handleFileUpload = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile) {
        form.companyLogo = selectedFile;
        imagePreview.value = URL.createObjectURL(selectedFile);
    }
}

const resetFileUpload = () => {
    form.companyLogo = null;
    imagePreview.value = null;
}
</script>