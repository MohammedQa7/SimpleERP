<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button>
                <Plus class="mr-2 h-4 w-4" />
                New User
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[925px] max-h-[80%] overflow-x-auto">
            <DialogHeader>
                <DialogTitle>Create New User</DialogTitle>
                <DialogDescription>Add a new user to your organization.</DialogDescription>
            </DialogHeader>
            <div class="space-y-6">
                <form class="space-y-6">
                    <div class="flex flex-col items-center mb-6">
                        <div
                            class="relative h-24 w-24 rounded-full bg-muted flex items-center justify-center overflow-hidden border border-border">
                            <img v-if="form.avatar" :src="form.avatar" alt="Avatar preview"
                                class="h-full w-full object-cover" />
                            <button type="button" @click="openAvatarUpload"
                                class="absolute  inset-0 bg-black/40 opacity-0 hover:opacity-100 flex items-center justify-center text-white transition-opacity">
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="space-y-2">
                            <label for="name" class="text-sm font-medium">Full Name</label>
                            <Input placeholder="john doe" v-model="form.name" />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium">Email</label>
                            <Input placeholder="john@gmail.com" v-model="form.email" />
                            <InputError :message="form.errors.email" />
                        </div>

                        <div class="space-y-2">
                            <label for="phone-number" class="text-sm font-medium">Phone number</label>
                            <Input placeholder="+2213123123" v-model="form.phoneNumber" />
                            <InputError :message="form.errors.phoneNumber" />
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="text-sm font-medium">Password</label>
                            <div class="relative">
                                <Input id="password" v-model="form.password" :type="showPassword ? 'text' : 'password'"
                                    required
                                    class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 pr-10" />
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground">
                                    <svg v-if="showPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off">
                                        <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24" />
                                        <path
                                            d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68" />
                                        <path
                                            d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61" />
                                        <line x1="2" x2="22" y1="2" y2="22" />
                                    </svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                                <InputError :message="form.errors.password" />
                            </div>

                            <div class="text-xs text-muted-foreground mt-1">
                                Password must be at least 8 characters long with a mix of letters, numbers,
                                and symbols.
                            </div>

                        </div>


                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-sm font-medium">Confirm
                                Password</label>
                            <div class="relative">
                                <Input id="password_confirmation" v-model="form.password_confirmation"
                                    :type="showConfirmPassword ? 'text' : 'password'" required
                                    class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 pr-10" />
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground">
                                    <svg v-if="showConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-eye-off">
                                        <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24" />
                                        <path
                                            d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68" />
                                        <path
                                            d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61" />
                                        <line x1="2" x2="22" y1="2" y2="22" />
                                    </svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                                <InputError :message="form.errors.password_confirmation" />
                            </div>
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
                            <MultiSelect @bindSelectedItems="bindSelectedRoles"  :items="roles" />
                            <InputError :message="form.errors.roles" />
                        </div>

                        <div class="space-y-2">
                            <label for="job-title" class="text-sm font-medium">Job title</label>
                            <Select v-model="form.jobTitle">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a product" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem v-for="(title, index) in jobTitles" :key="index"
                                            :value="title.value" class="hover:bg-secondary cursor-pointer">
                                            {{ title.label }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.jobTitle" />
                        </div>

                        <div class="space-y-2">
                            <label for="address" class="text-sm font-medium">Address</label>
                            <Input placeholder="..." v-model="form.address" />
                            <InputError :message="form.errors.address" />
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">

                        <Button @click.prevent="submit" type="submit" :disabled="form.processing">
                            <svg v-if="form.processing" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-loader-2 animate-spin mr-2">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                            </svg>
                            Create User
                        </Button>
                    </div>
                </form>
            </div>
        </DialogContent>
    </Dialog>

</template>

<script setup>
import { ref, computed } from 'vue'
import {
    Plus,
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
import MultiSelect from './MultiSelect.vue'
import Select from '../ui/select/Select.vue'
import SelectTrigger from '../ui/select/SelectTrigger.vue'
import SelectValue from '../ui/select/SelectValue.vue'
import SelectContent from '../ui/select/SelectContent.vue'
import SelectGroup from '../ui/select/SelectGroup.vue'
import SelectItem from '../ui/select/SelectItem.vue'
import InputError from '../InputError.vue'
import NumberField from '../ui/number-field/NumberField.vue'
import Label from '../ui/label/Label.vue'
import NumberFieldContent from '../ui/number-field/NumberFieldContent.vue'
import NumberFieldDecrement from '../ui/number-field/NumberFieldDecrement.vue'
import NumberFieldInput from '../ui/number-field/NumberFieldInput.vue'
import NumberFieldIncrement from '../ui/number-field/NumberFieldIncrement.vue'
const selectedCustomer = ref(null);
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const avatarInput = ref(null)
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    phoneNumber: '',
    roles: [],
    avatar: null,
    jobTitle: '',
    address: '',
    salary: '1500',
});

const propsData = defineProps({
    roles: Array,
    jobTitles: Array,
});



const openAvatarUpload = () => {
    avatarInput.value.click()
}

const handleAvatarChange = (event) => {
    const file = event.target.files[0]
    if (file) {
        const reader = new FileReader()
        reader.onload = (e) => {
            form.avatar = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

const bindSelectedRoles = (roles) => {
    form.roles = roles;
}


const submit = () => {


    form.post(route('users.store'), {
        onSuccess: () => {
            form.reset();
            toast({
                title: 'User has been created successfully',
            })
        }
    });
}


</script>
