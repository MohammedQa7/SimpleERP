<template>
    <SlideUpAnimation :delay="500">
        <div class="w-full border-b border-website-secondary/12 flex flex-col justify-center items-center">
            <!-- Comparison Table -->
            <div class="self-stretch flex justify-center items-start">
                <!-- Left side decoration -->
                <CrossedLinesDecoration />

                <div class="relative flex-1  border-l border-r border-website-secondary/10">
                    <!-- Table Header -->
                    <div v-if="plans"
                        class="sticky top-0 z-10 grid border-b border-website-secondary/10 bg-website-background"
                        :class="plans.length + 1 < 12 ? 'grid-cols-' + (plans.length + 1) : 'grid-cols-5'">

                        <div class="p-4 md:p-6 border-r border-website-secondary/10">
                            <div class="text-website-secondary text-3xl md:text-3xl font-semibold font-sans">
                                Plans</div>
                        </div>
                        <div v-for="(plan, index) in plans" :key="index"
                            class="p-4 md:p-6 border-r border-website-secondary/10 text-center w-full"
                            :class="{ 'bg-website-primary': plan.highlight }">
                            <div v-if="plan.prices[period]">
                                <!-- Name -->
                                <div class="text-website-secondary text-sm md:text-base font-semibold font-sans"
                                    :class="plan.highlight ? 'text-white' : 'text-website-secondary'">
                                    {{ plan.name }}
                                </div>

                                <!-- Price -->
                                <div class=" text-3xl font-medium leading-9 font-serif mt-2"
                                    :class="plan.highlight ? 'text-website-background' : 'text-website-secondary'">

                                    ${{ plan.prices[period]?.price / 100 }}
                                </div>

                                <!-- Period -->
                                <div class=" text-sm font-medium font-sans z-40 "
                                    :class="plan.highlight ? 'text-website-secondary-foreground' : 'text-website-secondary/60'">
                                    per {{ period }}
                                </div>

                                <!-- CTA -->
                                <div class="w-full text-center mx-auto mt-5">
                                    <Button @click.prevent="isDialogOpned = true" class="text-xs w-full px-4 py-2"
                                        :class="plan.highlight ? ' bg-blue-600  hover:bg-blue-700 border border-blue-900 ' : 'text-website-primary bg-white border hover:bg-white/30'">
                                        Start with {{ plan.name }}
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Feature Categories -->
                    <div v-if="plans" v-for="(category, categoryIndex) in featuresAndCategories.data"
                        :key="categoryIndex">
                        <!-- Category Header -->
                        <div
                            class="sticky top-48  grid grid-cols-4 border-b border-website-secondary/10 bg-website-secondary-foreground-light">
                            <div class=" col-span-4 p-4 md:p-6">
                                <div class="text-website-secondary text-sm md:text-base font-semibold font-sans">
                                    {{ category.name }}
                                </div>
                            </div>
                        </div>

                        <!-- Category Features -->
                        <div v-if="category.features.length > 0">
                            <div v-for="(feature, featureIndex) in category.features" :key="featureIndex"
                                class="grid border-b border-website-secondary/5 "
                                :class="'grid-cols-' + (plans.length + 1)">
                                <div class="p-4 md:p-6 border-r border-website-secondary/12">
                                    <div class="text-website-secondary text-sm font-normal font-sans">{{
                                        feature.name }}
                                    </div>
                                </div>
                                <div v-for="(plan) in plans" :key="index"
                                    class="p-4 md:p-6 border-r border-website-secondary/12 text-center flex justify-center items-center"
                                    :class="{ 'bg-website-primary': plan.highlight }">

                                    <!-- Check Icon -->
                                    <Check
                                        v-if="feature.planFeatures[plan.id] && !feature.planFeatures[plan.id]?.description"
                                        :class="plan.highlight ? 'text-white' : ' text-website-primary/70'" />

                                    <!-- Description Text -->
                                    <div v-else-if="feature.planFeatures[plan.id]?.description"
                                        class="text-sm font-normal font-sans"
                                        :class="plan.highlight ? 'text-website-background' : 'text-website-secondary'">
                                        {{ feature.planFeatures[plan.id]?.description }}</div>


                                    <!-- X Icon -->

                                    <Minus v-else class="text-gray-400" />
                                </div>

                            </div>
                        </div>

                        <div v-else>
                            <div class="grid grid-cols-1 border-b  border-website-secondary-foreground/20 ">
                                <div class="p-4 md:p-6 border-r border-website-secondary/10">
                                    <div class="text-website-secondary text-sm font-normal font-sans"> Oops! It looks
                                        like
                                        we don’t have any
                                        features available for {{ category.name }}.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side decoration -->
                <CrossedLinesDecoration />
            </div>
        </div>
    </SlideUpAnimation>

    <CreateCompanyDialog :is-open="isDialogOpned" @update:open="isDialogOpned = $event" />
</template>

<script setup>
import { ref, watch } from 'vue';
import CrossedLinesDecoration from '../CrossedLinesDecoration.vue';
import { Check, Minus } from 'lucide-vue-next';
import Button from '@/components/ui/button/Button.vue';
import CreateCompanyDialog from '../CreateCompanyDialog.vue';
import SlideUpAnimation from '../SlideUpAnimation.vue';
const isDialogOpned = ref(false);
const propsData = defineProps({
    plans: Array,
    period: String,
    featuresAndCategories: Array,
});



</script>