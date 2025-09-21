<template>
    <Dialog :open="isOpen" @update:open="isOpen = $event; form.errors = [];">
        <DialogContent class="grid-rows-[auto_minmax(0,1fr)_auto] p-0 max-h-[90dvh]">
            <div class="p-6 overflow-y-auto">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Request Title -->
                    <div class="space-y-2">
                        <Label>
                            Request Title
                        </Label>
                        <Input v-model="form.title" />
                        <InputError :message="form.errors?.title" />
                    </div>

                    <!-- Date Range -->
                    <div class="space-y-2">
                        <div class="space-y-2">
                            <Label>
                                {{ type == 'day off' ? 'Start Date' : 'Date (From - To)' }}
                            </Label>
                        </div>
                        <div class="flex flex-col space-y-2">
                            <RangeDatePicker v-if="type != 'day off'" @bindDate="onBindCalendarDate" />
                            <Calendar v-else @bindCalendarDate="onBindCalendarDate" />
                            <InputError :message="form.errors.startDate" />
                            <InputError :message="form.errors.endDate" />
                        </div>

                    </div>

                    <!-- Priority (for urgent requests) -->
                    <div class="space-y-2" v-if="type === 'urgent'">
                        <Label>Select Priority</Label>
                        <Select v-model="form.priority">
                            <SelectTrigger>
                                <SelectValue placeholder=" Select a priority" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem v-for="(priority, index) in priority" :key="index" :value="priority"
                                        class="hover:bg-secondary cursor-pointer">
                                        {{ priority }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors?.priority" />
                    </div>

                    <!-- Reason -->
                    <div>
                        <Label>
                            Reason for Request
                        </Label>
                        <textarea v-model="form.reason" :placeholder="getReasonPlaceholder()" required rows="3"
                            class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1"></textarea>
                        <p class="text-xs text-muted-foreground mt-1">{{ form.reason.length }}/500 characters</p>
                    </div>

                    <!-- Additional Notes -->
                    <div>
                        <Label>
                            Additional Notes (Optional)
                        </Label>
                        <textarea v-model="form.notes"
                            placeholder="Any additional information or special circumstances..." rows="3"
                            class="flex min-h-[80px] w-full  rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1"></textarea>
                        <p class="text-xs text-muted-foreground mt-1">{{ form.notes.length }}/300 characters</p>
                        <InputError :message="form.errors?.notes" />
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-3 ">
                        <DialogClose>
                            <Button type="button" variant="outline">
                                Cancel
                            </Button>
                        </DialogClose>

                        <Button type="submit" :disabled="form.processing">
                            Submit Request
                        </Button>
                    </div>
                </form>
            </div>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Clock, AlertTriangle } from 'lucide-vue-next'
import Input from '../ui/input/Input.vue'
import Label from '../ui/label/Label.vue'
import Dialog from '../ui/dialog/Dialog.vue';
import DialogContent from '../ui/dialog/DialogContent.vue';
import Select from '../ui/select/Select.vue';
import SelectTrigger from '../ui/select/SelectTrigger.vue';
import SelectValue from '../ui/select/SelectValue.vue';
import SelectContent from '../ui/select/SelectContent.vue';
import SelectGroup from '../ui/select/SelectGroup.vue';
import SelectItem from '../ui/select/SelectItem.vue';
import RangeDatePicker from '../RangeDatePicker.vue';
import { useForm } from '@inertiajs/vue3';
import Calendar from '../Calendar.vue';
import Button from '../ui/button/Button.vue';
import DialogClose from '../ui/dialog/DialogClose.vue';
import InputError from '../InputError.vue';
import { isObject } from '@vueuse/core';
import { toast } from '../ui/toast';
const propsData = defineProps({
    type: String,
    isOpen: Boolean,
    priority: Array,
});
const form = useForm({
    title: '',
    startDate: null,
    endDate: null,
    priority: null,
    reason: '',
    notes: '',
    type: null,
})

const onBindCalendarDate = (date) => {
    // When the Calendar limits the user to chose only on date.
    if (isObject(date)) {
        form.startDate = date
    }

    // if the calendar is a range calendar
    form.startDate = date.startDate;
    form.endDate = date.endDate;
}

// toast({
//     title: 'test',
//     variant: 'success'
// })

const getReasonPlaceholder = () => {
    switch (propsData.type.toLowerCase()) {
        case 'vacation':
            return 'e.g., Family vacation, wedding, personal travel...'
        case 'day-off':
            return 'e.g., Medical appointment, personal matters, family event...'
        case 'urgent':
            return 'e.g., Family emergency, medical emergency, urgent personal matter...'
        default:
            return 'Please provide a reason for your request...'
    }
}

const submit = () => {
    // bind the chosen type to the form.
    form.type = propsData?.type.charAt(0).toUpperCase() + propsData.type.slice(1);

    form.post(route('employee.requests.store'));
}

</script>