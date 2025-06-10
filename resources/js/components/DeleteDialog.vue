<template>
    <AlertDialog :open="isOpen" @update:open="isOpen = $event">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>

                    {{ title || "Are you absolutely sure ? " }}

                </AlertDialogTitle>
                <AlertDialogDescription>
                    {{ description }}
                </AlertDialogDescription>
            </AlertDialogHeader>

            <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <!-- Submit button -->
                <slot />
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

<script setup>
import AlertDialog from './ui/alert-dialog/AlertDialog.vue';
import AlertDialogCancel from './ui/alert-dialog/AlertDialogCancel.vue';
import AlertDialogContent from './ui/alert-dialog/AlertDialogContent.vue';
import AlertDialogDescription from './ui/alert-dialog/AlertDialogDescription.vue';
import AlertDialogFooter from './ui/alert-dialog/AlertDialogFooter.vue';
import AlertDialogHeader from './ui/alert-dialog/AlertDialogHeader.vue';
import AlertDialogTitle from './ui/alert-dialog/AlertDialogTitle.vue';

const propsData = defineProps({
    isOpen: Boolean,
    title: String,
    description: String,
});

</script>