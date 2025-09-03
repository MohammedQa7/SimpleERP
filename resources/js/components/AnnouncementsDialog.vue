<template>
    <Dialog :open="isOpen" @update:open="isOpen = $event">
        <DialogContent class="max-w-[600px] max-h-[650px] overflow-y-auto">
            <Card class="p-6">
                <CardTitle>
                    Latest Updates
                </CardTitle>
                <CardDescription>
                    What's new in our platform
                </CardDescription>
                <CardContent class="pt-6 px-0 space-y-6">
                    <div v-for="(announcement, index) in announcements" :key="announcement.uuid"
                        class="animate-in fade-in slide-in-from-left-2 duration-300 border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                        <!-- Image -->
                        <div v-if="announcement.image" class="mb-4">
                            <img :src="announcement.image" alt="Image preview"
                                class="w-full max-h-52 object-cover  rounded-lg border  bg-gray-100 animate-in fade-in duration-300" />
                        </div>

                        <div>
                            <!-- Version + Type + Date-->
                            <div class="flex items-center gap-3 mb-3">
                                <div class="announcement-version flex items-center gap-2 mb-2">
                                    <Badge v-if="announcement.version"
                                        class="text-xs font-medium bg-primary text-white">
                                        v{{ announcement.version }}
                                    </Badge>
                                    <Badge variant='secondary'>{{ announcement.type }}</Badge>
                                    <span class="text-xs text-muted-foreground">{{ announcement.createdAt }}</span>
                                </div>

                            </div>

                            <!-- Title -->
                            <h3
                                class="announcement-title text-xl font-extrabold text-balance mb-3 dark:text-white text-accent-foreground">
                                {{ announcement.title }}</h3>

                            <!-- Content -->
                            <div class="announcement-content space-y-2">
                                <p class="animate-in fade-in duration-200">
                                    <span class="prose prose-ul:text-muted-foreground prose-li:text-muted-foreground"
                                        v-html="announcement.content">
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import Badge from './ui/badge/Badge.vue';
import Dialog from './ui/dialog/Dialog.vue';
import DialogContent from './ui/dialog/DialogContent.vue';
import Card from './ui/card/Card.vue';
import CardContent from './ui/card/CardContent.vue';
import CardTitle from './ui/card/CardTitle.vue';
import CardDescription from './ui/card/CardDescription.vue';
const page = usePage();
const announcements = page.props.announcements.data;
const propsData = defineProps({
    isOpen: Boolean,
});
// Updates data
const updates = [
    {
        version: "2.1.0",
        date: "December 15, 2024",
        title: "Enhanced User Experience",
        type: "minor",
        image: "/modern-analytics-dashboard.png",
        features: [
            "New dashboard with improved analytics",
            "Dark mode support across all pages",
            "Enhanced mobile responsiveness",
            "Performance optimizations",
        ],
    },
    {
        version: "2.0.5",
        date: "November 28, 2024",
        title: "Bug Fixes & Improvements",
        type: "patch",
        image: "/bug-fixing-tools-and-security-shield-icons.png",
        features: [
            "Fixed login authentication issues",
            "Improved page loading speeds",
            "Updated security protocols",
            "Minor UI adjustments",
        ],
    },
    {
        version: "2.0.0",
        date: "November 10, 2024",
        title: "Major Platform Redesign",
        type: "major",
        image: "/modern-ui-design-elements-and-user-interface-compo.png",
        features: [
            "Complete UI/UX overhaul",
            "New user onboarding flow",
            "Advanced search functionality",
            "Integration with third-party services",
            "Real-time notifications system",
        ],
    },
]
</script>