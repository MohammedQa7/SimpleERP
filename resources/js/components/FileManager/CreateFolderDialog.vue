<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button variant="outline" size="icon" class="rounded-full">
                <FolderPlus class="h-4 w-4" />
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[525px] max-h-[80%] overflow-x-auto">
            <DialogHeader>
                <DialogTitle>Create New Folder</DialogTitle>
            </DialogHeader>
            <div class="space-y-6">
                <form class="space-y-6">
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-medium">Folder name</label>
                        <Input placeholder="john doe" v-model="form.name" />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2">
                            <Checkbox v-model:checked="form.visibility" />
                            <label for="terms"
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                Anyone can see this folder
                            </label>
                        </div>
                        <InputError :message="form.errors.visibility" />
                    </div>

                    <div class="flex justify-end space-x-2">
                        <Button @click.prevent="submit" type="submit" :disabled="form.processing">
                            <svg v-if="form.processing" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-loader-2 animate-spin mr-2">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                            </svg>
                            Create Folder
                        </Button>
                    </div>
                </form>
            </div>
        </DialogContent>
    </Dialog>

</template>

<script setup>
import {
    FolderPlus,
} from 'lucide-vue-next'

import Button from '@/components/ui/button/Button.vue'
import Input from '@/components/ui/input/Input.vue'
import Dialog from '../ui/dialog/Dialog.vue'
import DialogTrigger from '../ui/dialog/DialogTrigger.vue'
import DialogContent from '../ui/dialog/DialogContent.vue'
import DialogHeader from '../ui/dialog/DialogHeader.vue'
import DialogTitle from '../ui/dialog/DialogTitle.vue'
import { router, useForm } from '@inertiajs/vue3'
import { toast } from '@/components/ui/toast'
import InputError from '../InputError.vue'
import { ref } from 'vue'
import Checkbox from '../ui/checkbox/Checkbox.vue'
const emit = defineEmits();
const form = useForm({
    name: '',
    visibility: true,
});

const submit = () => {
    form.post(route('folders.store'), {
        onSuccess: () => {
            form.reset();
            toast({
                title: 'Folder has been created successfully',
            })
        }
    });
}


</script>
