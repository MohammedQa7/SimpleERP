<template>
    <Dialog :open="isOpen">
        <DialogContent :hide-close-button="true" class="sm:max-w-[525px] max-h-[80%] overflow-x-auto">
            <DialogHeader>
                <DialogTitle>New Order</DialogTitle>
            </DialogHeader>

            <UseresSkelaton v-if="isLoading" />

            <form v-else class="space-y-6">
                <div class="flex flex-col items-center mb-6">
                    <div
                        class="relative h-24 w-24 rounded-full bg-muted flex items-center justify-center overflow-hidden border border-border">
                        <img v-if="uploadedImage" :src="uploadedImage" alt="Avatar preview"
                            class="h-full w-full object-cover" />

                        <span v-else class="text-muted-foreground text-xl font-medium">{{
                            getUserInitials(form.name || 'User') }}
                        </span>
                        <button type="button" @click="openAvatarUpload"
                            class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 flex items-center justify-center text-white transition-opacity">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-camera">
                                <path
                                    d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                <circle cx="12" cy="13" r="3" />
                            </svg>
                        </button>
                        <input ref="avatarInput" type="file" accept="image/*" class="hidden"
                            @change="handleAvatarChange" />
                    </div>
                    <p class="text-sm text-muted-foreground mt-2">Upload a profile picture</p>
                </div>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <Label for="edit-name" class="text-sm font-medium">Full Name</Label>
                        <Input v-model="form.name" />
                        <InputError :message="form.errors?.name" />
                    </div>

                    <div class="space-y-2">
                        <Label for="edit-email" class="text-sm font-medium">Email</Label>
                        <Input v-model="form.email" />
                        <InputError :message="form.errors?.email" />
                    </div>

                    <div class="space-y-2">
                        <NumberField id="salary" v-model="form.salary" :format-options="{
                            style: 'currency',
                            currency: 'USD',
                            currencyDisplay: 'code',
                            currencySign: 'accounting',
                        }">
                            <Label for="salary">Salary</Label>
                            <NumberFieldContent>
                                <NumberFieldDecrement />
                                <NumberFieldInput />
                                <NumberFieldIncrement />
                            </NumberFieldContent>
                        </NumberField>
                    </div>
                    <div class="space-y-2">
                        <label for="role" class="text-sm font-medium">Role</label>
                        <!-- Roles mutli select -->
                        <MultiSelect @bindSelectedItems="bindSelectedRoles" :items="filteredRoles" />
                        <InputError :message="form.errors?.roles" />
                    </div>

                    <div class="space-y-2">
                        <label for="job-title" class="text-sm font-medium">Job title</label>
                        <Select v-model="form.jobTitle">
                            <SelectTrigger>
                                <SelectValue placeholder="Select a product" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem v-for="(title, index) in jobTitles" :key="index" :value="title.value"
                                        class="hover:bg-secondary cursor-pointer">
                                        {{ title.label }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors?.jobTitle" />
                    </div>

                    <div class="space-y-2">
                        <label for="address" class="text-sm font-medium">Address</label>
                        <Input placeholder="..." v-model="form.address" />
                        <InputError :message="form.errors?.address" />
                    </div>

                </div>

                <div class="flex space-x-2">
                    <Button @click.prevent="CloseDialog" variant="outline">Cancel</Button>
                    <Button @click.prevent="submit" :disabled="form.processing">
                        {{ form.processing ? 'Updating ...' : 'Update Order' }}
                    </Button>
                </div>

            </form>

            <DialogClose @click.prevent="CloseDialog"
                class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-accent data-[state=open]:text-muted-foreground">
                <X class="w-4 h-4" />
                <span class="sr-only">Close</span>
            </DialogClose>
        </DialogContent>
    </Dialog>

</template>

<script setup>
import { ref, onMounted, onUnmounted, watch, computed } from 'vue'
import Dialog from '../ui/dialog/Dialog.vue'
import DialogContent from '../ui/dialog/DialogContent.vue'
import DialogHeader from '../ui/dialog/DialogHeader.vue'
import DialogTitle from '../ui/dialog/DialogTitle.vue'
import { router, useForm } from '@inertiajs/vue3'
import { closeDialog } from '@/composables/closeDialog'
import DialogClose from '../ui/dialog/DialogClose.vue'
import { X } from 'lucide-vue-next'
import Label from '../ui/label/Label.vue'
import Input from '../ui/input/Input.vue'
import NumberField from '../ui/number-field/NumberField.vue'
import NumberFieldContent from '../ui/number-field/NumberFieldContent.vue'
import NumberFieldDecrement from '../ui/number-field/NumberFieldDecrement.vue'
import NumberFieldInput from '../ui/number-field/NumberFieldInput.vue'
import NumberFieldIncrement from '../ui/number-field/NumberFieldIncrement.vue'
import MultiSelect from './MultiSelect.vue'
import InputError from '../InputError.vue'
import Select from '../ui/select/Select.vue'
import SelectTrigger from '../ui/select/SelectTrigger.vue'
import SelectValue from '../ui/select/SelectValue.vue'
import SelectContent from '../ui/select/SelectContent.vue'
import SelectGroup from '../ui/select/SelectGroup.vue'
import SelectItem from '../ui/select/SelectItem.vue'
import UseresSkelaton from './UseresSkelaton.vue'
import Button from '../ui/button/Button.vue';
import { cloneDeep } from 'lodash';
import { toast } from '../ui/toast'
const emit = defineEmits();
const hasFetchedData = ref(false);
const avatarInput = ref(null);
const uploadedImage = ref(null);

const form = useForm({
    name: '',
    email: '',
    password: null,
    password_confirmation: null,
    phoneNumber: '',
    roles: [],
    profilePhotoUrl: null,
    jobTitle: null,
    address: '',
    salary: '',
});
const propsData = defineProps({
    user: Object,
    jobTitles: Array,
    roles: Array,
    isOpen: Boolean,
    isLoading: Boolean,
});
let filteredRoles = ref(cloneDeep(propsData.roles));


const openAvatarUpload = () => {
    avatarInput.value.click()
}

const handleAvatarChange = (event) => {
    const file = event.target.files[0]
    if (file) {
        const reader = new FileReader()
        reader.onload = (e) => {
            uploadedImage.value = e.target.result

        }
        reader.readAsDataURL(file)
    }
}
const getUserInitials = (name) => {
    if (!name) return ''
    return name
        .split(' ')
        .map(part => part.charAt(0))
        .join('')
        .toUpperCase()
        .substring(0, 2)
}


const bindSelectedRoles = (roles) => {
    form.roles = roles;
}

const CloseDialog = () => {
    form.reset();
    closeDialog(emit);

}
const closeOnEscape = (e) => {
    if (e.key === 'Escape') {
        closeDialog(emit);
    }
};


const submit = () => {
    !form.password
        ? (delete form.password, delete form.password_confirmation)
        : '';

    form.put(route('users.update', { user: propsData.user.employeeCode }), {
        onSuccess: () => {
            closeDialog(emit)
            toast({
                title: 'Changes have been saved.',
            })
        }
    });
}



watch(propsData, (newValue) => {
    if (!hasFetchedData.value) {
        Object.assign(form, newValue.user);

        const formRolesSet = new Set(form.roles.map(role => role.id));
        filteredRoles = propsData.roles.filter(role => !formRolesSet.has(role.id));

        console.log(form.jobTitle);


        hasFetchedData.value = true;
    }
}, { deep: true });

watch(uploadedImage, (value) => {
    form.profilePhotoUrl = value;
}, { deep: true });


onMounted(() => {
    document.addEventListener('keydown', closeOnEscape);
});

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
})

</script>
