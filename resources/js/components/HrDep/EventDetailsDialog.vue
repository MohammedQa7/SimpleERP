<template>
    <Dialog v-model:open="isDialogOpened" @update:open="isDialogOpened = $event">
        <DialogContent class="sm:max-w-md">
            <DialogHeader>
                <div class="flex items-start gap-3">
                    <DialogTitle>{{ event.title }}</DialogTitle>
                </div>
            </DialogHeader>

            <div class="space-y-4">
                <Card>
                    <CardContent class="p-3 flex items-center gap-3">
                        <Clock class="text-muted-foreground size-5" />
                        <div>
                            <div class="text-sm text-muted-foreground">Time</div>
                            <div class="font-medium">{{ event.startsAt }} - {{ event.endsAt }}</div>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardContent class="p-3 flex items-center gap-3">
                        <UserCog class="text-muted-foreground size-5" />
                        <div>
                            <div class="text-sm text-muted-foreground">Organizer</div>
                            <div class="font-medium">{{ event.user.name }} </div>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardContent class="p-3 flex items-start gap-3">
                        <FileText class="text-muted-foreground size-5" />
                        <div>
                            <div class="text-sm text-muted-foreground">Description</div>
                            <div class="font-medium">{{ event.description }}</div>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardContent class="p-3 flex items-center gap-3">
                        <User class="text-muted-foreground size-5" />
                        <div>
                            <div class="text-sm text-muted-foreground">Participants To</div>
                            <Collapsible v-model:open="isCollapsed" class="w-[350px] overflow-y-auto py-2 space-y-2"
                                :class="{ 'h-[170px]': isCollapsed }">
                                <div class="flex items-center justify-between space-x-4 px-4">
                                    <h4 class="text-sm font-semibold">
                                        {{ event.invitedUsers.length }} users
                                    </h4>
                                    <CollapsibleTrigger as-child>
                                        <Button variant="ghost" size="sm" class="w-9 p-0">
                                            <ChevronsUpDown class="h-4 w-4" />
                                            <span class="sr-only">Toggle</span>
                                        </Button>
                                    </CollapsibleTrigger>
                                </div>
                                <div class="rounded-md border px-4 py-3 font-mono text-sm">
                                    <h1>{{ event.invitedUsers[0].name }}</h1>
                                    <h4 class="text-muted-foreground text-sm">{{ event.invitedUsers[0].email }}</h4>
                                </div>
                                <CollapsibleContent class="space-y-2 overflow-hidden"
                                    v-for="(user, index) in event.invitedUsers" :key="index">
                                    <div v-if="index != 0" class="rounded-md border px-4 py-3 font-mono text-sm">
                                        <div>
                                            <h1>{{ user.name }}</h1>
                                            <h4 class="text-muted-foreground text-sm">{{ user.email }}</h4>
                                        </div>
                                    </div>

                                </CollapsibleContent>
                            </Collapsible>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardContent class="p-3 flex items-center gap-3">
                        <Flag class="text-muted-foreground size-5" />
                        <div>
                            <div class="text-sm text-muted-foreground">Priority</div>
                            <div class="font-medium capitalize">{{ event.priority }}</div>
                        </div>
                    </CardContent>
                </Card>

                <div class="pt-4 flex justify-end gap-2">
                    <Button variant="outline">Edit</Button>
                    <Button>Complete</Button>
                </div>
            </div>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import { computed, ref } from 'vue';
import Card from '../ui/card/Card.vue';
import CardContent from '../ui/card/CardContent.vue';
import Dialog from '../ui/dialog/Dialog.vue';
import DialogContent from '../ui/dialog/DialogContent.vue';
import DialogHeader from '../ui/dialog/DialogHeader.vue';
import DialogTitle from '../ui/dialog/DialogTitle.vue';
import Button from '../ui/button/Button.vue';
import { ChevronsUpDown, Clock, FileArchive, FileText, Flag, User, UserCog } from 'lucide-vue-next';
import Collapsible from '../ui/collapsible/Collapsible.vue';
import CollapsibleTrigger from '../ui/collapsible/CollapsibleTrigger.vue';
import CollapsibleContent from '../ui/collapsible/CollapsibleContent.vue';
const isCollapsed = ref(false);
const propsData = defineProps({
    event: Object,
    isOpen: Boolean,
    isLoading: Boolean,
});

const isDialogOpened = computed(() => {
    return propsData.isOpen;
})



</script>