<template>



    <div class="w-full border-b border-website-secondary/12 flex flex-col justify-center items-center">
        <!-- Comparison Table -->
        <div class="self-stretch flex justify-center items-start">
            <!-- Left side decoration -->
            <CrossedLinesDecoration />

            <div class="flex-1 border-l border-r border-website-secondary/10">
                <!-- Table Header -->
                <div v-if="plans" class="grid  border-b border-website-secondary/10"
                    :class="'grid-cols-' + (plans.length + 1)">
                    <div class="p-4 md:p-6 border-r border-website-secondary/10">
                        <div class="text-website-secondary text-sm md:text-base font-semibold font-sans">
                            Features</div>
                    </div>
                    <div v-for="(plan, index) in plans" :key="index"
                        class="p-4 md:p-6 border-r border-website-secondary/10 text-center  "
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
                        </div>
                    </div>

                </div>



                <!-- Feature Categories -->
                <div v-if="plans" v-for="(category, categoryIndex) in featuresAndCategories.data" :key="categoryIndex">
                    <!-- Category Header -->
                    <div
                        class="grid grid-cols-4 border-b border-website-secondary/10 bg-website-secondary-foreground/5">
                        <div class="col-span-4 p-4 md:p-6">
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
                                class="p-4 md:p-6 border-r border-website-secondary/12 text-center"
                                :class="{ 'bg-website-primary': plan.highlight }">

                                <!-- Check Icon -->
                                <svg v-if="feature.planFeatures[plan.id] && !feature.planFeatures[plan.id]?.description"
                                    width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="mx-auto">
                                    <path d="M13.5 4.5L6 12L2.5 8.5" stroke="#10B981" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                <!-- Description Text -->
                                <div v-else-if="feature.planFeatures[plan.id]?.description"
                                    class="text-sm font-normal font-sans"
                                    :class="plan.highlight ? 'text-website-background' : 'text-website-secondary'">
                                    {{ feature.planFeatures[plan.id]?.description }}</div>


                                <!-- X Icon -->
                                <svg v-else width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="mx-auto">
                                    <path d="M12 4L4 12M4 4l8 8" stroke="#EF4444" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>

                        </div>
                    </div>

                    <div v-else>
                        <div class="grid grid-cols-1 border-b  border-website-secondary-foreground/20 ">
                            <div class="p-4 md:p-6 border-r border-website-secondary/10">
                                <div class="text-website-secondary text-sm font-normal font-sans"> Oops! It looks like
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
</template>

<script setup>
import { watch } from 'vue';
import CrossedLinesDecoration from '../CrossedLinesDecoration.vue';

const propsData = defineProps({
    plans: Array,
    period: String,
    featuresAndCategories: Array,
});



</script>