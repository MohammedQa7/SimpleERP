<template>
    <Dialog v-model:open="isDialogOpened" @update:open="isDialogOpened = $event">

        <DialogContent :hide-close-button="true" class="sm:max-w-[525px] max-h-[80%] overflow-x-auto">

            <DialogHeader>
                <DialogTitle>New Event</DialogTitle>
            </DialogHeader>

            <form class="space-y-6">
                <div class="space-y-4">
                    <div class="space-y-2">
                        <Label for="event-title" class="text-sm font-medium">Event title</Label>
                        <Input v-model="form.title" />
                        <InputError :message="form.errors?.title" />
                    </div>

                    <div class="space-y-2">
                        <Label for="event-description" class="text-sm font-medium">Description</Label>
                        <Input v-model="form.description" />
                        <InputError :message="form.errors?.description" />
                    </div>

                    <div class="space-y-2 flex flex-col">
                        <Label for="start-date" class="text-sm font-medium">Start Date</Label>
                        <Calendar @bindCalendarDate="bindCalendarDate" />
                        <InputError :message="form.errors?.startDate" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="  space-y-2 flex flex-col">
                            <Label for="start-date" class="text-sm font-medium">Start at</Label>
                            <TimePicker with-period with-labels v-model:date="startsAt" />
                            <InputError :message="form.errors?.startsAt" />
                        </div>
                        <div class=" space-y-2 flex flex-col">
                            <Label for="start-date" class="text-sm font-medium">Ends at</Label>
                            <TimePicker with-period with-labels v-model:date="endsAt" />
                            <InputError :message="form.errors?.endsAt" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="event-attendencees" class="text-sm font-medium">Attendences</label>
                        <MultiSelect @bindSelectedItems="bindSelectedUsers" :items="users" />
                        <InputError :message="form.errors?.attendances" />
                    </div>


                    <div class="space-y-2">
                        <label for="event-priority" class="text-sm font-medium">Priority</label>
                        <Select v-model="form.priority">
                            <SelectTrigger>
                                <SelectValue placeholder="Select a priority" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem v-for="(priority, index) in priorities" :key="index" :value="priority"
                                        class="hover:bg-secondary cursor-pointer">
                                        {{ priority }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors?.priority" />
                    </div>

                </div>

                <div class="flex space-x-2">
                    <Button variant="outline">Cancel</Button>
                    <Button @click.prevent="submit" :disabled="form.processing">
                        {{ form.processing ? 'Creating ...' : 'Create Event' }}
                    </Button>
                </div>

            </form>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import { computed, ref } from 'vue';
import Dialog from '../ui/dialog/Dialog.vue';
import DialogContent from '../ui/dialog/DialogContent.vue';
import DialogHeader from '../ui/dialog/DialogHeader.vue';
import DialogTitle from '../ui/dialog/DialogTitle.vue';
import { useForm } from '@inertiajs/vue3';
import Button from '../ui/button/Button.vue';
import Calendar from '../Calendar.vue';
import Label from '../ui/label/Label.vue';
import Input from '../ui/input/Input.vue';
import InputError from '../InputError.vue';
import Select from '../ui/select/Select.vue';
import SelectTrigger from '../ui/select/SelectTrigger.vue';
import SelectValue from '../ui/select/SelectValue.vue';
import SelectContent from '../ui/select/SelectContent.vue';
import SelectGroup from '../ui/select/SelectGroup.vue';
import SelectItem from '../ui/select/SelectItem.vue';
import TimePicker from '../time-picker.vue';
import MultiSelect from '../UserDep/MultiSelect.vue';
import { toast } from '../ui/toast';

const startsAt = ref(new Date());
const endsAt = ref(new Date());

const propsData = defineProps({
    isOpen: Boolean,
    users: Object,
    priorities: Array,
});

const isDialogOpened = computed(() => {
    return propsData.isOpen;
})
const form = useForm({
    title: '',
    description: '',
    startDate: '',
    startsAt: startsAt.value.toISOString().slice(0, 19).replace("T", " "),
    endsAt: endsAt.value.toISOString().slice(0, 19).replace("T", " "),
    attendances: [],
    priority: '',
});

const bindCalendarDate = (date) => {
    const formatedDate = new Date(date.value);
    formatedDate.setTime(startsAt.value.getTime());
    console.log(formatedDate);
    

    form.startDate = formatedDate.toISOString().slice(0, 19).replace("T", " ");
}
const bindSelectedUsers = (user) => {
    form.attendances = user;
}

const submit = () => {
    isDialogOpened.value = false;


    form.post(route('events.store'), {
        onSuccess: () => {
            form.reset();
            toast({
                title: 'Event has been successfully created.'
            });
        },
        onError: () => {
            toast({
                title: 'Something went wrong while trying to create an event. Please try again later',
                variant: 'destructive',
            });
        }
    })
}
</script>