<template>
    <div @click.prevent="switchAccount(account.uuid)"
        v-for="(account, index) in page.props?.currentSignedInAccounts?.data" :key="index" :user="account.user"
        class="w-full flex items-center gap-2 p-1  rounded-lg hover:bg-muted cursor-pointer">
        <UserInfo :user="account.user" :show-email="true" />
    </div>

</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';
import UserInfo from './UserInfo.vue';
const page = usePage();

const switchAccount = (accountUuid) => {
    router.post(route('accounts.switch', { uuid: accountUuid }), {}, {
        onFinish: () => {
            window.location.reload();
        }
    })
}
</script>