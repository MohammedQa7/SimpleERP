<template>
    <div class="group fixed w-full h-1 bg-black dark:bg-white z-20">
        <HoverCard open-delay="0" close-delay="0" class="relative">
            <div
                class="absolute top-0 left-1/2 -translate-x-1/2 transition-all ease-in-out duration-150 cursor-pointer ">
                <HoverCardTrigger>

                    <svg class=" fill-black dark:fill-white" width="365" height="38" viewBox="0 0 365 41" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g filter="url(#filter)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M364.844 2.40625C364.844 1.30168 363.948 0.40625 362.844 0.40625H2.73437C1.62981 0.40625 0.734375 1.30168 0.734375 2.40625V2.40625C0.734375 3.51082 1.6298 4.40625 2.73437 4.40625H35.5798C42.8938 4.40625 49.8086 7.74141 54.3619 13.4653L68.5859 31.3461C73.1392 37.0699 80.054 40.4051 87.368 40.4051H278.134C285.495 40.4051 292.449 37.0274 296.999 31.2416L310.897 13.5697C315.448 7.78398 322.401 4.40625 329.762 4.40625H362.844C363.948 4.40625 364.844 3.51082 364.844 2.40625V2.40625Z">
                                #b2aea9</path>
                        </g>
                        <defs>
                            <filter id="filter" x="2.734375" y="0.40625" width="364.109" height="40"
                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape">
                                </feBlend>
                                <feMorphology radius="0.5" operator="erode" in="SourceAlpha"
                                    result="effect1_innerShadow_760_657234"></feMorphology>
                                <feOffset></feOffset>
                                <feGaussianBlur stdDeviation="0.75"></feGaussianBlur>
                                <feComposite in2="hardAlpha" operator="arithmetic" k2="-1" k3="1"></feComposite>
                                <feBlend mode="normal" in2="shape" result="effect1_innerShadow_760_657234"></feBlend>
                            </filter>
                        </defs>
                    </svg>

                    <div
                        class="notch-work-session flex justify-center items-center absolute top-0 left-1/2 -translate-x-1/2 p-2 pointer-events-none ">
                        <div class="absolute inset-x-1/2 -top-16 h-24 w-[125%] -translate-x-1/2 opacity-50 mix-blend-hard-light z-0"
                            style="background-image: radial-gradient(47.64% 47.64% at 50% 50%, #7622ff 0%, rgba(184, 34, 255, 0) 100%)">
                        </div>
                        <div
                            class="flex justify-center items-center gap-1  font-sans text-primary-foreground font-medium text-sm">
                            <svg :class="isEmployeeCheckedIn ? 'fill-green-700' : 'fill-indigo-600'" width="25"
                                height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21.8071 9.1761C22.959 8.36113 23.711 7.01839 23.711 5.5C23.711 3.01472 21.6963 1 19.211 1C17.8127 1 16.5634 1.63776 15.738 2.63826C14.6412 2.22473 13.4525 1.99848 12.2109 1.99848C6.68809 1.99848 2.21094 6.47563 2.21094 11.9985C2.21094 17.5213 6.68809 21.9985 12.2109 21.9985C17.7338 21.9985 22.2109 17.5213 22.2109 11.9985C22.2109 11.0184 22.0699 10.0712 21.8071 9.1761Z">
                                </path>
                                <path
                                    d="M17.8411 2.70703C17.4269 2.70703 17.0911 3.04282 17.0911 3.45703C17.0911 3.87124 17.4269 4.20703 17.8411 4.20703V2.70703ZM20.7578 3.45703L21.3498 3.91749C21.5257 3.69138 21.5574 3.38484 21.4315 3.12752C21.3057 2.8702 21.0443 2.70703 20.7578 2.70703V3.45703ZM17.8411 7.20703L17.2491 6.74658C17.0733 6.97269 17.0416 7.27922 17.1674 7.53654C17.2933 7.79387 17.5547 7.95703 17.8411 7.95703V7.20703ZM20.7578 7.95703C21.172 7.95703 21.5078 7.62124 21.5078 7.20703C21.5078 6.79282 21.172 6.45703 20.7578 6.45703V7.95703ZM12.9661 8.45703C12.9661 8.04282 12.6304 7.70703 12.2161 7.70703C11.8019 7.70703 11.4661 8.04282 11.4661 8.45703H12.9661ZM12.2161 11.9987H11.4661C11.4661 12.1976 11.5452 12.3884 11.6858 12.529L12.2161 11.9987ZM13.7691 14.6124C14.062 14.9053 14.5369 14.9053 14.8298 14.6124C15.1227 14.3195 15.1227 13.8446 14.8298 13.5517L13.7691 14.6124ZM14.8489 5.55544C15.2322 5.71227 15.6701 5.52862 15.827 5.14524C15.9838 4.76186 15.8002 4.32394 15.4168 4.16711L14.8489 5.55544ZM20.3619 9.7131C20.2502 9.31423 19.8363 9.08145 19.4374 9.19315C19.0385 9.30486 18.8057 9.71876 18.9174 10.1176L20.3619 9.7131ZM17.8411 4.20703H20.7578V2.70703H17.8411V4.20703ZM20.1658 2.99658L17.2491 6.74658L18.4332 7.66749L21.3498 3.91749L20.1658 2.99658ZM17.8411 7.95703H20.7578V6.45703H17.8411V7.95703ZM11.4661 8.45703V11.9987H12.9661V8.45703H11.4661ZM11.6858 12.529L13.7691 14.6124L14.8298 13.5517L12.7465 11.4684L11.6858 12.529ZM19.1745 11.9987C19.1745 15.8417 16.0591 18.957 12.2161 18.957V20.457C16.8876 20.457 20.6745 16.6701 20.6745 11.9987H19.1745ZM12.2161 18.957C8.37316 18.957 5.25781 15.8417 5.25781 11.9987H3.75781C3.75781 16.6701 7.54474 20.457 12.2161 20.457V18.957ZM5.25781 11.9987C5.25781 8.15572 8.37316 5.04036 12.2161 5.04036V3.54036C7.54474 3.54036 3.75781 7.32729 3.75781 11.9987H5.25781ZM12.2161 5.04036C13.1493 5.04036 14.0377 5.22363 14.8489 5.55544L15.4168 4.16711C14.4285 3.76284 13.3474 3.54036 12.2161 3.54036V5.04036ZM18.9174 10.1176C19.0848 10.7151 19.1745 11.3458 19.1745 11.9987H20.6745C20.6745 11.2077 20.5657 10.441 20.3619 9.7131L18.9174 10.1176Z"
                                    fill="white"></path>
                                <defs>
                                    <linearGradient id="paint0_linear_760_657223" x1="12.961" y1="1" x2="12.961"
                                        y2="21.9985" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#8322FF"></stop>
                                        <stop offset="1" stop-color="#3422FF"></stop>
                                    </linearGradient>
                                </defs>
                            </svg>
                            <h1 class="text-white dark:text-black ">Work Session</h1>

                        </div>
                    </div>
                </HoverCardTrigger>
            </div>

            <HoverCardContent class="rounded-xl">
                <div v-if="isEmployeeCheckedIn" class=" flex items-start justify-between gap-3">
                    <div class=" space-y-2">
                        <div class="flex justify-between items-center gap-2 text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <User class="h-4 w-4 text-muted-foreground" />
                                <span class="font-medium">{{ employeeCheckedData.data.employee.name }}</span>
                            </div>
                        </div>

                        <div class="space-y-1 text-xs text-muted-foreground">
                            <div class="flex items-center gap-2">
                                <span>Checked in:</span>
                                <span class="font-mono">
                                    {{ employeeCheckedData.data.checkInTime }} • {{ employeeCheckedData.data.checkInDate
                                    }}
                                </span>
                            </div>
                        </div>
                        <Button @click.prevent="confimrationDialog = true" size="sm" class="w-full text-xs">
                            <LogOut class="h-3 w-3 mr-2" />
                            Check Out
                        </Button>

                    </div>
                </div>
                <div v-else class="space-y-4">
                    <div class="flex items-center gap-2">
                        <h1 class="text-sm">
                            Not checked in - Please check in to start your session
                        </h1>
                    </div>
                    <Button @click.prevent="toggleWorkSession" size="sm" class=" text-white text-xs "
                        :disabled="isLoading">
                        <Loader2 v-if="isLoading" class=" animate-spin" />
                        <LogIn v-else class="h-3 w-3 mr-2" />
                        Check In
                    </Button>
                </div>
            </HoverCardContent>
        </HoverCard>

        <DeleteDialog :open="confimrationDialog"
            :description="'Your checkout time will be recorded immediately. If you leave earlier than your scheduled shift, this may reduce your total working hours and affect your salary.'"
            @update:open="confimrationDialog = $event">
            <Button @click.prevent="toggleWorkSession" variant="destructive"
                :class="'bg-destructive/90 hover:bg-destructive'" class="w-full text-xs" :disabled="isLoading">
                <Loader2 v-if="isLoading" class=" animate-spin" />
                Yes, I am sure
            </Button>
        </DeleteDialog>
    </div>
</template>
<script setup>
import { router, usePage } from '@inertiajs/vue3';
import HoverCard from './ui/hover-card/HoverCard.vue';
import HoverCardTrigger from './ui/hover-card/HoverCardTrigger.vue';
import HoverCardContent from './ui/hover-card/HoverCardContent.vue';
import { onMounted, ref } from 'vue';
import Button from './ui/button/Button.vue';
import { Loader2, LogIn, LogOut, User } from 'lucide-vue-next';
const page = usePage();
const isLoading = ref(false);
const confimrationDialog = ref(false);
const isEmployeeCheckedIn = ref();
const employeeCheckedData = ref();
import { useToast } from '@/components/ui/toast/use-toast'
import DeleteDialog from './DeleteDialog.vue';
const { toast } = useToast();

const toggleWorkSession = () => {
    isLoading.value = true;
    router.post(route('attendances.logs.store'), {}, {
        preserveScroll: true,
        onSuccess: () => {
            isLoading.value = false;
            confimrationDialog.value = false;
            isEmployeeCheckedIn.value = !isEmployeeCheckedIn.value;
            employeeCheckedData.value = page.props.isEmployeeCheckedIn.data;
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