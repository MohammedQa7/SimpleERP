<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Connected apps" />

        <SettingsLayout>
            <div class="space-y-6 ">
                <HeadingSmall title="Connected apps"
                    description="Connect your favorite tools and services to enhance your workflow" />


                <!-- Integration Cards Grid -->
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-2">

                    <div v-for="integration in integrations?.data" :key="integration.id"
                        class="group flex flex-col justify-between  relative overflow-hidden rounded-xl border border-slate-200 bg-white p-6 transition-all hover:shadow-lg"
                        :class="!integration.isAvailable ? 'opacity-75 cursor-not-allowed' : ''">

                        <div>
                            <!-- Provider settings buttin -->
                            <div class="mb-4 flex items-center justify-between ">
                                <div
                                    class="p-2 rounded-lg bg-slate-100 text-slate-700 transition-colors group-hover:bg-indigo-50 group-hover:text-indigo-600">
                                    <img :src="integration.icon" class="h-6 w-6" alt="integration-icon"></img>
                                </div>
                                <Button @click.prevent="toggleDialog(integration.key, integration.folderName)"
                                    class=" px-3 bg-primary-foreground hover:bg-primary/20 shadow-md  dark:bg-secondary-foreground dark:hover:bg-primary ">
                                    <SlidersHorizontal class="text-primary dark:text-black" />
                                </Button>
                            </div>

                            <!-- Content -->
                            <div class="mb-4">
                                <h3 class="mb-2 text-lg font-semibold text-slate-900">{{ integration.name }}</h3>
                                <p class="text-sm text-slate-600">{{ integration.description }}</p>
                            </div>

                        </div>
                        <!-- Connect/Disconnect Buttons -->
                        <div class="">
                            <div v-if="integration.isUserAuthorized" class=" flex items-center justify-between gap-2">
                                <div
                                    class="flex items-center gap-1.5 rounded-md bg-emerald-50 px-3 py-1.5 text-sm font-medium text-emerald-700">
                                    <Check class="h-3.5 w-3.5" />
                                    Connected
                                </div>

                                <Button @click.prevent="disconnectApp(integration)" :disabled="isButtonLoading"
                                    class="bg-transparent text-primary text-xs  hover:bg-destructive hover:text-white ">
                                    <Spinner v-if="isButtonLoading" />
                                    <span v-if="isButtonLoading">Disconnecting</span>
                                    <span v-else>Disconnect</span>
                                </Button>
                            </div>


                            <div v-else-if="integration.isAvailable" class="w-full">
                                <a :href="route('integration.redirect', { provider: integration.key })" class="w-full block text-center rounded-lg
                            bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition-colors
                            hover:bg-slate-800">
                                    Connect
                                </a>
                            </div>
                            <div v-else class="w-full">
                                <a class="w-full block text-center rounded-lg
                            bg-slate-200 px-4 py-2.5 text-sm font-medium text-black opacity-50 transition-colors">
                                    Soon!
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Empty State -->
                <div v-if="integrations?.data.length <= 0" class="py-12 text-center">
                    <p class="text-slate-600">No integrations available at the moment</p>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>

    <!-- <SlackSettingsDialog v-if="isDialogOpen" :is-open="isDialogOpen" :is-loading="isLoading"
        :slack-user="slackUserData?.data" :slack-team="slackTeamData?.data" @update:open="isDialogOpen = $event" /> -->

    <GlobalProviderDialog v-if="isDialogOpen" :is-open="isDialogOpen" :provider-key="triggeredProvider.key"
        :provider-folder-name="triggeredProvider.folderName" @update:open="isDialogOpen = $event" />
</template>


<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { AlertCircle, Check, SlidersHorizontal, X } from 'lucide-vue-next';
import Button from '@/components/ui/button/Button.vue';
import { ref } from 'vue';
import Spinner from '@/components/ui/spinner/Spinner.vue';
import GlobalProviderDialog from '@/components/Inetgrations/globalProviderDialog.vue';
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Connected apps',
        href: '/settings/connected-apps',
    },
];
const isDialogOpen = ref(false);
const isDialogLoading = ref(false);
const isButtonLoading = ref(false);
const triggeredProvider = ref({
    key: String,
    folderName: String,
});

const propsData = defineProps({
    integrations: Array,
});


const disconnectApp = (integration: Object) => {
    isButtonLoading.value = true;
    router.delete(route('integration.disconnect', { provider: integration.key }), {
        onSuccess: () => {
            isDialogLoading.value = false;
        }
    });
}
const toggleDialog = (providerKey: string, providerFolderName: string) => {
    isDialogOpen.value = true;
    isDialogLoading.value = true;
    triggeredProvider.value.key = providerKey;
    triggeredProvider.value.folderName = providerFolderName;

}


</script>