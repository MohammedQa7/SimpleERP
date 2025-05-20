<template>
    <Card>
        <CardHeader>
            <CardTitle>Recent Activities</CardTitle>
            <CardDescription>Latest HR activities and updates</CardDescription>
        </CardHeader>
        <CardContent>
            <div class="space-y-4">
                <div v-for="(activity, index) in recentActivities" :key="index" class="flex gap-4">
                    <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                        <component :is="activity.icon" class="h-5 w-5 text-primary" />
                    </div>
                    <div>
                        <p class="font-medium">{{ activity.title }}</p>
                        <p class="text-sm text-muted-foreground">{{ activity.description }}</p>
                        <p class="text-xs text-muted-foreground mt-1">{{ activity.time }}</p>
                    </div>
                </div>
            </div>
        </CardContent>
        <CardFooter>
            <Button variant="ghost" class="w-full">View All Activities</Button>
        </CardFooter>
    </Card>

</template>
<script setup>
import Button from '../ui/button/Button.vue';
import Card from '../ui/card/Card.vue';
import CardContent from '../ui/card/CardContent.vue';
import CardDescription from '../ui/card/CardDescription.vue';
import CardFooter from '../ui/card/CardFooter.vue';
import CardHeader from '../ui/card/CardHeader.vue';
import CardTitle from '../ui/card/CardTitle.vue';

</script>