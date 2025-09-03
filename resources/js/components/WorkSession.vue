<template>
    <!-- Checking in and out for employees -->
    <Button v-if="!isCheckedIn" @click.prevent="isCheckedIn = !isCheckedIn; isWidgetCollapsed = !isWidgetCollapsed"
        class="fixed top-10 -right-3 -translate-y-1/2 z-40 text-primary-foreground px-5 py-3 rounded-l-lg rounded-r-none shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-ring "
        :class="isEmployeeCheckedIn ? 'bg-green-700 hover:bg-green-600' : 'bg-red-700 hover:bg-red-600'"
        @mouseover="revealText = true" @mouseleave="revealText = false">
        <div class="flex items-center gap-2 transition-all ">
            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"
                :class="isEmployeeCheckedIn ? 'bg-green-400' : 'bg-red-400'" />

            <p class=" transition-all duration-150 ease-in-out"
                :class="revealText ? 'w-32 opacity-100' : 'w-0 opacity-0'">
                Session Details</p>
            <ChevronRight :size="16" />
        </div>
    </Button>
    <Transition enter-active-class="transition-all duration-300 ease-in-out"
        enter-from-class="translate-x-full opacity-0" enter-to-class="translate-x-0 opacity-100"
        leave-active-class="transition-all duration-300 ease-in-out" leave-from-class="translate-x-0 opacity-100"
        leave-to-class="translate-x-full opacity-0">
        <Card v-if="!isWidgetCollapsed"
            class="fixed max-w-80 top-[15%] -translate-y-1/2 right-4 p-4 shadow-lg border backdrop-blur-sm"
            :class="!isEmployeeCheckedIn ? 'bg-red-100/20 border-red-300' : ''">
            <div v-if="isEmployeeCheckedIn" class=" flex items-start justify-between gap-3 min-w-[280px] ">
                <div class="flex-1 space-y-2">
                    <div class="flex justify-between items-center gap-2 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <User class="h-4 w-4 text-muted-foreground" />
                            <span class="font-medium">{{ employeeCheckedData.data.employee.name }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <Button @click.prevent="isWidgetCollapsed = !isWidgetCollapsed; isCheckedIn = !isCheckedIn;"
                                variant="ghost" class="p-3 hover:bg-primary/20">
                                <ChevronRight :size="16" />
                            </Button>
                        </div>
                    </div>

                    <div class="space-y-1 text-xs text-muted-foreground">
                        <div class="flex items-center gap-2">
                            <span>Checked in:</span>
                            <span class="font-mono">
                                {{ employeeCheckedData.data.checkInTime }} • {{ employeeCheckedData.data.checkInDate }}
                            </span>
                        </div>
                    </div>
                    <Button @click.prevent="confimrationDialog = true" variant="destructive" size="sm"
                        class="w-full text-xs">
                        <LogOut class="h-3 w-3 mr-2" />
                        Check Out

                        {{ isEmployeeCheckedIn }}
                    </Button>

                    <DeleteDialog :open="confimrationDialog"
                        :description="'Your checkout time will be recorded immediately. If you leave earlier than your scheduled shift, this may reduce your total working hours and affect your balance.'"
                        @update:open="confimrationDialog = $event">
                        <AlertDialogAction @click.prevent="attendWorkSession" variant="destructive"
                            :class="'bg-destructive/90 hover:bg-destructive'" class="w-full text-xs">
                            Yes, I am sure
                        </AlertDialogAction>
                    </DeleteDialog>
                </div>
            </div>

            <!-- If the employee is not checked in -->
            <div v-else class="space-y-4">
                <div class="flex items-center gap-2">
                    <AlertTriangle class=" text-destructive" />
                    <h1 class="text-sm text-destructive">
                        Not checked in - Please check in to start your session
                    </h1>
                    <Button @click.prevent="isWidgetCollapsed = !isWidgetCollapsed; isCheckedIn = !isCheckedIn;"
                        variant="ghost" class="p-3 hover:bg-primary/20">
                        <ChevronRight :size="16" />
                    </Button>
                </div>
                <Button @click.prevent="attendWorkSession" size="sm"
                    class="w-full text-xs bg-green-700 hover:bg-green-900" :disabled="isLoading">
                    <Loader2 v-if="isLoading" class=" animate-spin" />
                    <LogIn v-else class="h-3 w-3 mr-2" />
                    Check In
                </Button>
            </div>
        </Card>
    </Transition>

</template>
<script setup>
import { onMounted, ref, Transition } from 'vue';
import Card from './ui/card/Card.vue';
import Button from './ui/button/Button.vue';
import { AlertTriangle, ChevronRight, Loader2, LogIn, LogOut, User } from 'lucide-vue-next';
import { router, usePage } from '@inertiajs/vue3';
const page = usePage();
const isCheckedIn = ref(false);
const isWidgetCollapsed = ref(true);
const revealText = ref(false);
const isLoading = ref(false);
const confimrationDialog = ref(false);
const test = ref(page.props.isEmployeeCheckedIn.value);
const isEmployeeCheckedIn = ref();
const employeeCheckedData = ref();
import { useToast } from '@/components/ui/toast/use-toast'
import DeleteDialog from './DeleteDialog.vue';
import AlertDialogAction from './ui/alert-dialog/AlertDialogAction.vue';
const { toast } = useToast()

const attendWorkSession = () => {
    isLoading.value = true;
    router.post(route('attendances.logs.store'), {}, {
        preserveScroll: true,
        onSuccess: () => {
            isLoading.value = false;
            isEmployeeCheckedIn.value = !isEmployeeCheckedIn.value;
        },
        onError: () => {
            toast({
                title: 'Something went wrong while trying to check you into the system. Please try again.',
                variant: 'destructive'
            });
        },
    })
}

onMounted(() => {

    isEmployeeCheckedIn.value = page.props.isEmployeeCheckedIn.value;
    employeeCheckedData.value = page.props.isEmployeeCheckedIn.data;
})

</script>