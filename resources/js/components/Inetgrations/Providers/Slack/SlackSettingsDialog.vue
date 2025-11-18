<template>
    <DialogHeader>
        <DialogTitle>Notification Settings</DialogTitle>
        <DialogDescription>
            Configure which Slack channel receives notifications from each department.
        </DialogDescription>
    </DialogHeader>
    <div v-if="!isLoading" class="dialog-content space-y-3 mt-3">

        <!-- Slack user info -->
        <div v-if="slackData.user && slackData.team" class="user-info space-y-1">
            <h3 class="text-sm font-semibold ">Slack Account</h3>
            <div class="flex items-center gap-4 p-4 rounded-lg border">
                <div
                    class="h-12 w-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">

                    <img :src="slackData.user.avatar" alt="user-slack-image">

                </div>
                <div class="flex-1 space-y-1">
                    <div class="flex items-center gap-2">
                        <p class="font-medium">{{ slackData.user.name }}</p>
                        <Badge v-if="slackData.user.isConnected"
                            class=" bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400 border border-green-200 dark:border-green-800  pointer-events-none">
                            Connected
                        </Badge>
                    </div>
                    <a :href="slackData.team.url" class="text-xs text-gray-500 dark:text-gray-500 underline">Workspace:
                        {{ slackData.team.name }}</a>
                </div>
            </div>
        </div>

        <Separator />

        <!-- Welcoming section for connecting channels -->
        <div v-if="isNull(slackData.channels) || isArray(slackData.channels) && slackData.channels.length <= 0"
            class=" rounded-lg border-2 border-dashed border-muted-foreground/25 p-8 text-center space-y-4">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary/10">
                <MessagesSquare />
            </div>
            <div class="space-y-2">
                <h3 class="text-lg font-semibold">Set Up Your Slack Channels</h3>
                <p class="text-sm text-muted-foreground max-w-md mx-auto">
                    Connect your Slack channels to receive notifications from different departments. Get real-time
                    updates
                    exactly where you need them.
                </p>
            </div>
            <Button @click.prevent="fetchSlackChannels" size="lg" class="gap-2" :disabled="innerLoading">
                <div v-if="!innerLoading" class="flex justify-center items-center gap-1">
                    <Hash class="h-5 w-5" />
                    <span>Load Slack Channels</span>
                </div>

                <div v-if="innerLoading" class="flex justify-center items-center gap-1 text-xs">
                    <Spinner />
                    <span>Hang on a minute, we are getting the Slack channels..</span>
                </div>
            </Button>

            <div v-if="isArray(slackData.channels) && slackData.channels.length <= 0">
                <Badge class="text bg-destructive pointer-events-none">
                    No Channels were found !
                </Badge>
            </div>
        </div>


        <!-- Assigning department to a channel-->
        <div v-if="slackData?.channels?.length > 0" class="channels-section space-y-3">
            <div class="rounded-lg border bg-muted/50 p-4">
                <div class="flex items-center gap-3">
                    <div :class="[
                        'mt-0.5 flex h-8 w-8 items-center justify-center rounded-full',
                        ' bg-primary text-primary-foreground'
                    ]">
                        <Bell class="h-4 w-4 " />
                    </div>
                    <div class="flex-1 space-y-1">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-medium">Notification Status</p>
                            <Badge v-if="form.assignedDepartmentChannels.length > 0" class="  pointer-events-none"
                                :class="form.assignedDepartmentChannels.length > 0
                                    ? 'bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400 border border-green-200 dark:border-green-800 '
                                    : ''">
                                {{ form.assignedDepartmentChannels.length > 0 ? 'Connected' : 'Not Connected' }}
                            </Badge>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h3 className="text-base font-semibold">Department Channels</h3>
                <p className="text-sm text-muted-foreground mt-1">
                    Assign specific channels for each department (optional)
                </p>
            </div>
            <!-- Departments -->
            <div class="grid grid-cols-3 gap-2 items-end ">
                <div class="space-y-2">
                    <Label class="text-sm font-medium ">Department</Label>
                    <Select v-model="selectedDepartment" name="department">
                        <SelectTrigger id="default-channel">
                            <SelectValue placeholder="Select a default channel" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="dept in departments" :key="dept" :value="dept">
                                <div class="flex items-center gap-2">
                                    {{ dept }}
                                </div>
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="form.errors.assignedDepartmentChannels?.department" />
                </div>

                <!-- Channels -->
                <div class="space-y-3">
                    <Label class="text-sm font-medium">Channel</Label>
                    <Select v-model="selectedChannel" name="channel_id">
                        <SelectTrigger id="default-channel">
                            <SelectValue placeholder="Select a default channel" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="channel in slackData.channels" :key="channel.id" :value="channel.id">
                                <div class="flex items-center gap-2">
                                    <Hash class="w-3 h-3" />
                                    {{ channel.name }}
                                </div>
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <!-- <input type="hidden" name="channel_name" :value="channel.name"> -->
                    <InputError :message="form.errors.assignedDepartmentChannels?.channelId" />
                </div>

                <Button @click.prevent="addDepartmentChannels" :disabled="processing"
                    class="rounded-lg font-medium transition-colors ">
                    Add
                </Button>

            </div>

            <!-- Selected Channels + Departments -->
            <div v-if="form.assignedDepartmentChannels.length >= 1" class="space-y-2 mt-4">
                <Label class="text-sm font-medium text-gray-700 dark:text-gray-300">Assigned Channels</Label>
                <div class="space-y-2">
                    <div v-for="mapping in form.assignedDepartmentChannels" :key="mapping.department"
                        class="flex items-center justify-between p-3 rounded-lg border ">
                        <div class="flex items-center gap-3">
                            <Badge :variant="'secondary'" class="px-2.5 py-1 rounded-md pointer-events-none">
                                {{ mapping.department }}
                            </Badge>
                            <span class="text-gray-400">→</span>
                            <div class="flex items-center gap-1.5 text-sm">
                                <Hash :size="16" class="text-gray-500" />
                                <span class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ mapping.channelName }}
                                </span>
                            </div>
                        </div>
                        <Button variant="outline">
                            <X :size="16" />
                        </Button>
                    </div>
                </div>
            </div>

            <InputError :message="form.errors.assignedDepartmentChannels" />
        </div>


        <DialogFooter v-if="slackData.channels" class="gap-2 ">
            <Button v-if="isConnected" variant="outline" @click="handleDisconnect" class="gap-2">
                <Unplug class="h-4 w-4" />
                Disconnect
            </Button>
            <Button @click.prevent="attachDepartmentChannels" :disabled="form.processing">
                <Check class="mr-2 h-4 w-4" />
                Save Configuration
            </Button>
        </DialogFooter>
    </div>
    <GeneralSkelaton v-if="isLoading" />
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import {
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog'
import { Button } from '@/components/ui/button'
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Bell, Hash, Check, Unplug, X, MessagesSquare } from 'lucide-vue-next'
import { router, useForm } from '@inertiajs/vue3';
import GeneralSkelaton from '@/components/GeneralSkelaton.vue'
import Badge from '@/components/ui/badge/Badge.vue'
import Separator from '@/components/ui/separator/Separator.vue'
import { isArray, isNull } from 'lodash'
import Spinner from '@/components/ui/spinner/Spinner.vue'
import InputError from '@/components/InputError.vue'
const selectedDepartment = ref(null)
const selectedChannel = ref(null)
const isLoading = ref(false);
const innerLoading = ref(false);
const departments = ref([]);
const slackData = ref(
    {
        user: null,
        team: null,
        channels: null,
    }
)
const propsData = defineProps({
    provider: String,
})

const form = useForm({
    assignedDepartmentChannels: []
});


const attachDepartmentChannels = () => {
    form.post(route('slack.channels.store'), {
        preserveState: true,
        preserveUrl: true,
        only: ['flash'],
    });
}

const addDepartmentChannels = () => {
    const channelObj = Object.values(slackData.value.channels);
    const channel = channelObj.find((channel) => {
        return channel.id == selectedChannel.value;
    })
    if (selectedChannel.value && selectedDepartment.value) {

        form.assignedDepartmentChannels.push({
            'department': selectedDepartment.value,
            'channelId': selectedChannel.value,
            'channelName': channel.name,
        });
    }
}


const fetchSlackChannels = () => {
    innerLoading.value = true;
    router.visit(route('slack.channels.index'), {
        only: ['channels'],
        preserveUrl: true,
        preserveState: true,
        onSuccess: (page) => {
            innerLoading.value = false;
            slackData.value.channels = page.props.channels ? page.props.channels.data : [];
        }
    });
}

const fetchSlackSettingsData = () => {
    isLoading.value = true;
    router.visit(route('provider.settings', { provider: propsData.provider }), {
        only: ['slackUserData', 'slackTeamData', 'slackChannelData', 'departmentChannelAssignments', 'departments'],
        preserveScroll: true,
        preserveState: true,
        preserveUrl: true,
        onSuccess: (page) => {
            isLoading.value = false;
            slackData.value.user = page.props.slackUserData.data;
            slackData.value.team = page.props.slackTeamData.data;
            slackData.value.channels = page.props.slackChannelData?.data ?? null;
            form.assignedDepartmentChannels = page.props?.departmentChannelAssignments.data
            departments.value = page.props.departments;

        }
    })
}
onMounted(() => {
    fetchSlackSettingsData();
})

onUnmounted(() => {
})
</script>
