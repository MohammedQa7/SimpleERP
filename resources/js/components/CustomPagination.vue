<template>
    <CardFooter class="flex items-center justify-between p-4">
        <div class="text-sm text-muted-foreground">
            Showing <strong>{{ item.meta.from }}</strong> to <strong>{{ item.meta.to }}</strong> of <strong>{{
                item.meta.total
                }}</strong> results
        </div>
        <div class="flex items-center space-x-2">
            <Link :href="item.links.prev" preserve-scroll>
            <Button variant="outline" size="sm" :disabled="isNull(item.links.prev)">Previous</Button>
            </Link>
            <Link :href="item.links.next" preserve-scroll>
            <Button variant="outline" size="sm" :disabled="isNull(item.links.next)">Next</Button>
            </Link>
        </div>
    </CardFooter>
</template>

<script setup>
import Button from './ui/button/Button.vue';
import CardFooter from './ui/card/CardFooter.vue';
import { isNull } from 'lodash';
const propsData = defineProps({
    item: Object
});

</script>