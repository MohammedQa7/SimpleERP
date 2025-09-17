<template>
    <div class="flex min-h-screen items-center justify-center bg-background p-4">
        <div class="w-full max-w-lg space-y-8 text-center">
            <div class="flex justify-center">
                <div class="rounded-full bg-primary/10 p-6">
                    <Link2 class="h-16 w-16 text-primary" />
                </div>
            </div>

            <div class="space-y-3">
                <h1 class="text-balance text-4xl font-bold tracking-tight text-foreground">You're Already Connected
                </h1>
                <p class="text-pretty text-lg text-muted-foreground">
                    You're currently signed in and don't need to authenticate again.
                </p>
            </div>

            <div class="rounded-lg border border-border bg-card p-4 text-left">
                <div class="flex items-center gap-3">
                    <div class="rounded-full bg-primary/10 p-2">
                        <Clock class="h-5 w-5 text-primary" />
                    </div>
                    <div>
                        <p class="text-xs text-muted-foreground">Last Login</p>
                        <p class="font-semibold text-card-foreground">{{ lastLogin }}</p>
                    </div>
                </div>
            </div>


            <div class="flex flex-col gap-3 pt-4 sm:flex-row sm:justify-center">
                <Button asChild size="lg" class="gap-2">
                    <Link :href="route('dashboard')">
                    <Home class="h-4 w-4" />
                    Go to Home
                    </Link>
                </Button>
                <Button asChild size="lg" variant="outline" class="gap-2 bg-transparent">
                    <Link :href="route('integrations.index')">
                    Continue to App
                    <ArrowRight class="h-4 w-4" />
                    </Link>
                </Button>
            </div>

            <p class="text-sm text-muted-foreground">
                If you'd like to sign in with a different account, please log out first.
            </p>
        </div>
    </div>
</template>

<script setup>
import Button from '@/components/ui/button/Button.vue';
import { ArrowRight, Clock, Home, Link2 } from 'lucide-vue-next';
const propsData = defineProps({
    lastLogin: String,
})
</script>