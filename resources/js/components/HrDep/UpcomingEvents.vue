<template>
    <Card>
        <CardHeader>
            <div class="flex items-center justify-between">
                <div>
                    <CardTitle>Upcoming Events</CardTitle>
                    <CardDescription>Scheduled meetings and events</CardDescription>
                </div>

                <!-- Create Event Dialog -->

                <Button @click.prevent="toggleCreateEventDialog">
                    <Plus class="h-4 w-4 mr-1" />
                    Add Event
                </Button>


                <CreateEventDialog :is-open="isCreateEventDialogOpened"
                    @update:open="isCreateEventDialogOpened = $event" :users="users" :priorities="priorities" />


            </div>
        </CardHeader>
        <CardContent>
            <div class="space-y-4">
                <div v-if="events.data.length > 0" v-for="(event, index) in events.data" :key="index"
                    class="flex gap-4">
                    <div class="text-center shrink-0">
                        <div class="bg-primary/10 rounded-md p-2 w-12">
                            <p class="text-xs text-muted-foreground">{{ event.startDate.month }}</p>
                            <p class="text-lg font-bold">{{ event.startDate.day }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="font-medium">{{ event.title }}</p>
                        <p class="text-sm text-muted-foreground">{{ event.description }}</p>
                        <div class="flex items-center mt-1 text-xs text-muted-foreground">
                            <Clock class="h-3 w-3 mr-1" />
                            <span>{{ event.startsAt + ' - ' + event.endsAt }}</span>
                        </div>
                    </div>
                </div>

                <NoRecordFound v-else :title="'No events yet'" :icon="'X'" />

            </div>
        </CardContent>
        <CardFooter>
            <Link :href="route('events.calendar')" class="w-full">
            <Button type="button" variant="outline" class="w-full">View Calendar</Button>
            </Link>
        </CardFooter>
    </Card>
</template>
<script setup>
import { Clock, Plus, X } from 'lucide-vue-next';
import Button from '../ui/button/Button.vue';
import Card from '../ui/card/Card.vue';
import CardContent from '../ui/card/CardContent.vue';
import CardDescription from '../ui/card/CardDescription.vue';
import CardFooter from '../ui/card/CardFooter.vue';
import CardHeader from '../ui/card/CardHeader.vue';
import CardTitle from '../ui/card/CardTitle.vue';
import CreateEventDialog from './CreateEventDialog.vue';
import axios from 'axios';
import { toast } from '../ui/toast';
import { ref } from 'vue';
import NoRecordFound from '../NoRecordFound.vue';
const isCreateEventDialogOpened = ref(false);
const users = ref({});
const priorities = ref([]);
const propsData = defineProps({
    events: Object,
});

const toggleCreateEventDialog = () => {
    axios.get(route('events.create'))
        .then((response) => {
            users.value = response.data.users;
            priorities.value = response.data.priorities;

            isCreateEventDialogOpened.value = true;
        })
        .catch(() => {
            toast({
                title: 'Something went wrong',
                variant: 'destructive'
            })
        })
}
</script>