<template>
    <div class="min-h-screen flex items-center justify-center p-4 bg-background">
        <div class="w-full max-w-md space-y-6">
            <div class="text-center space-y-3">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-primary/10 mb-2">
                    <LinkIcon class="w-7 h-7 text-primary" />
                </div>
                <h1 class="text-3xl font-semibold text-balance">Connect Another Account</h1>
                <p class="text-muted-foreground text-balance leading-relaxed">
                    Link your existing account to access it seamlessly. You won't need to re-enter your information
                    again once
                    connected.
                </p>
            </div>

            <Alert v-if="form.errors?.notice" variant="destructive">
                <AlertCircleIcon size="18" />
                <AlertTitle class="mb-0">{{ form.errors.notice }}</AlertTitle>
            </Alert>


            <Card class="border-2">
                <CardHeader>
                    <CardTitle class="text-xl">Sign in to Link Account</CardTitle>
                    <CardDescription>Enter the credentials of the account you want to connect</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="flex flex-col gap-6">
                        <div class="grid gap-6">
                            <div class="grid gap-2">
                                <Label for="email">Email address</Label>
                                <Input id="email" type="email" required autofocus :tabindex="1" autocomplete="email"
                                    v-model="form.email" placeholder="email@example.com" />
                                <InputError :message="form.errors.email" />
                            </div>

                            <div class="grid gap-2">
                                <div class="flex items-center justify-between">
                                    <Label for="password">Password</Label>
                                    <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm"
                                        :tabindex="5">
                                        Forgot password?
                                    </TextLink>
                                </div>
                                <Input id="password" type="password" required :tabindex="2"
                                    autocomplete="current-password" v-model="form.password" placeholder="Password" />
                                <InputError :message="form.errors.password" />
                            </div>

                            <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                Log in
                            </Button>
                        </div>
                    </form>

                </CardContent>
            </Card>

        </div>
    </div>

</template>

<script setup>
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { useForm } from '@inertiajs/vue3';
import { AlertCircleIcon, LinkIcon } from 'lucide-vue-next'
import {
    Alert,
    AlertTitle,
} from '@/components/ui/alert'
const form = useForm({
    email: '',
    password: '',
    remember: false,
});


const submit = () => {
    form.post(route('accounts.switch.authenticate'), {
        onFinish: () => form.reset('password'),
    });
};

</script>