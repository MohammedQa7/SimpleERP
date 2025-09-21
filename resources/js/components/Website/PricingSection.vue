<template>
    <div class="w-full flex flex-col justify-center items-center gap-2">
        <!-- Header Section -->
        <div
            class="self-stretch px-6 py-12 md:py-16 border-b border-[rgba(55,50,47,0.12)] flex justify-center items-center gap-6">
            <div
                class="w-full max-w-[586px] px-6 py-5 overflow-hidden rounded-lg flex flex-col justify-start items-center gap-4 shadow-none">
                <!-- Pricing Badge -->

                <CustomBadge :text="'Plans & Pricing'" :icon="'DollarSign'"/>

                <!-- Title -->
                <div
                    class="self-stretch text-center flex justify-center flex-col text-[#49423D] text-3xl md:text-5xl font-semibold leading-tight md:leading-[60px] font-sans tracking-tight">
                    Choose the perfect plan for your business
                </div>

                <!-- Description -->
                <div class="self-stretch text-center text-[#605A57] text-base font-normal leading-7 font-sans">
                    Scale your operations with flexible pricing that grows with your team.
                    <br />
                    Start free, upgrade when you're ready.
                </div>
            </div>
        </div>

        <!-- Billing Toggle Section -->
        <div class="self-stretch px-6 md:px-16 py-9 relative flex justify-center items-center gap-4">
            <!-- Horizontal line -->
            <div
                class="w-full max-w-[1060px] h-0 absolute left-1/2 transform -translate-x-1/2 top-[63px] border-t border-[rgba(55,50,47,0.12)] z-0">
            </div>

            <!-- Toggle Container -->
            <div
                class="p-3 relative bg-[rgba(55,50,47,0.03)] border border-[rgba(55,50,47,0.02)] backdrop-blur-[44px] backdrop-saturate-150 backdrop-brightness-110 flex justify-center items-center rounded-lg z-20 before:absolute before:inset-0 before:bg-white before:opacity-60 before:rounded-lg before:-z-10">
                <div
                    class="p-[2px] bg-[rgba(55,50,47,0.10)] shadow-[0px_1px_0px_white] rounded-[99px] border-[0.5px] border-[rgba(55,50,47,0.08)] flex justify-center items-center gap-[2px] relative">
                    <div class="absolute top-[2px] w-[calc(50%-1px)] h-[calc(100%-4px)] bg-white shadow-[0px_2px_4px_rgba(0,0,0,0.08)] rounded-[99px] transition-all duration-300 ease-in-out"
                        :class="billingPeriod === 'annually' ? 'left-[2px]' : 'right-[2px]'"></div>

                    <button @click="toggleBilling('annually')"
                        class="px-4 py-1 rounded-[99px] flex justify-center items-center gap-2 transition-colors duration-300 relative z-10 flex-1">
                        <div :class="billingPeriod === 'annually' ? 'text-[#37322F]' : 'text-[#6B7280]'"
                            class="text-[13px] font-medium leading-5 font-sans transition-colors duration-300">Annually
                        </div>
                    </button>

                    <button @click="toggleBilling('monthly')"
                        class="px-4 py-1 rounded-[99px] flex justify-center items-center gap-2 transition-colors duration-300 relative z-10 flex-1">
                        <div :class="billingPeriod === 'monthly' ? 'text-[#37322F]' : 'text-[#6B7280]'"
                            class="text-[13px] font-medium leading-5 font-sans transition-colors duration-300">Monthly
                        </div>
                    </button>
                </div>

                <!-- Decorative dots -->
                <div
                    class="w-[3px] h-[3px] absolute left-[5px] top-[5.25px] bg-[rgba(55,50,47,0.10)] shadow-[0px_0px_0.5px_rgba(0,0,0,0.12)] rounded-[99px]">
                </div>
                <div
                    class="w-[3px] h-[3px] absolute right-[5px] top-[5.25px] bg-[rgba(55,50,47,0.10)] shadow-[0px_0px_0.5px_rgba(0,0,0,0.12)] rounded-[99px]">
                </div>
                <div
                    class="w-[3px] h-[3px] absolute left-[5px] bottom-[5.25px] bg-[rgba(55,50,47,0.10)] shadow-[0px_0px_0.5px_rgba(0,0,0,0.12)] rounded-[99px]">
                </div>
                <div
                    class="w-[3px] h-[3px] absolute right-[5px] bottom-[5.25px] bg-[rgba(55,50,47,0.10)] shadow-[0px_0px_0.5px_rgba(0,0,0,0.12)] rounded-[99px]">
                </div>
            </div>
        </div>

        <!-- Pricing Cards Section -->
        <div class="self-stretch border-b border-t border-[rgba(55,50,47,0.12)] flex justify-center items-center">
            <div class="flex justify-center items-start w-full">
                <!-- Left Decorative Pattern -->
                <CrossedLinesDecoration />

                <!-- Pricing Cards Container -->
                <div class="flex-1 flex flex-col md:flex-row justify-center items-center gap-6 py-12 md:py-0">
                    <template v-for="plan in ['starter', 'professional', 'enterprise']" :key="plan">
                        <div :class="[
                            'flex-1 max-w-full md:max-w-none self-stretch px-6 py-5 overflow-hidden flex flex-col justify-start items-start gap-12',
                            plan === 'professional' ? 'bg-website-primary border border-[rgba(55,50,47,0.12)] text-[#F0EFEE]' : 'bg-white border border-[#E0DEDB] text-website-secondary'
                        ]">
                            <!-- Plan Header & Pricing -->
                            <div class="self-stretch flex flex-col justify-start items-center gap-9">
                                <div class="self-stretch flex flex-col justify-start items-start gap-2">
                                    <div class="text-lg font-medium leading-7 font-sans">{{ plan.charAt(0).toUpperCase()
                                        + plan.slice(1) }}</div>
                                    <div class="w-full max-w-[242px] text-sm font-normal leading-5 font-sans"
                                        :class="plan === 'professional' ? 'text-website-secondary-foreground' : plan === 'starter' ? 'text-website-secondary/70' : 'text-website-secondary/70'">
                                        {{
                                            plan === 'starter' ? 'Perfect for individuals and small teams getting started.'
                                                :
                                                plan === 'professional' ? 'Advanced features for growing teams and businesses.'
                                                    :
                                                    'Complete solution for large organizations and enterprises.'
                                        }}
                                    </div>
                                </div>

                                <!-- Pricing -->
                                <div class="self-stretch flex flex-col justify-start items-start gap-2">
                                    <div class="flex flex-col justify-start items-start gap-1">
                                        <div class="relative h-[60px] flex items-center text-5xl font-medium leading-[60px] font-serif"
                                            :class="plan === 'professional' ? 'text-[#F0EFEE]' : ''">
                                            <span class="invisible">${{ pricing[plan][billingPeriod] }}</span>
                                            <span class="absolute inset-0 flex items-center transition-all duration-500"
                                                :style="{
                                                    opacity: billingPeriod === 'annually' ? 1 : 0,
                                                    transform: `scale(${billingPeriod === 'annually' ? 1 : 0.8})`,
                                                    filter: `blur(${billingPeriod === 'annually' ? 0 : 4}px)`,
                                                }">
                                                ${{ pricing[plan].annually }}
                                            </span>
                                            <span class="absolute inset-0 flex items-center transition-all duration-500"
                                                :style="{
                                                    opacity: billingPeriod === 'monthly' ? 1 : 0,
                                                    transform: `scale(${billingPeriod === 'monthly' ? 1 : 0.8})`,
                                                    filter: `blur(${billingPeriod === 'monthly' ? 0 : 4}px)`,
                                                }">
                                                ${{ pricing[plan].monthly }}
                                            </span>
                                        </div>
                                        <div class="text-sm font-medium"
                                            :class="plan === 'professional' ? 'text-[#D2C6BF]' : 'text-[#847971]'">
                                            per {{ billingPeriod === 'monthly' ? 'month' : 'year' }}, per user.
                                        </div>
                                    </div>
                                </div>

                                <!-- CTA Button -->
                                <CtaButton class="w-full"
                                    :class="{ 'bg-white text-website-primary hover:bg-white/80': plan == 'professional' }"
                                    :text="plan === 'starter' ? 'Start for free'
                                        : plan === 'professional'
                                            ? 'Get started' : 'Contact sales'" />
                            </div>

                            <!-- Features -->
                            <div class="self-stretch flex flex-col justify-start items-start gap-2">
                                <div v-for="(feature, i) in features[plan]" :key="i"
                                    class="self-stretch flex justify-start items-center gap-[13px]">
                                    <div class="w-4 h-4 relative flex items-center justify-center">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <path d="M10 3L4.5 8.5L2 6"
                                                :stroke="plan === 'professional' ? '#FF8000' : '#9CA3AF'"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 text-[12.5px] font-normal leading-5 font-sans"
                                        :class="plan === 'professional' ? 'text-[#F0EFEE]' : 'text-[rgba(55,50,47,0.80)]'">
                                        {{ feature }}</div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Right Decorative Pattern -->
                <CrossedLinesDecoration />
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";
import CrossedLinesDecoration from "./CrossedLinesDecoration.vue";
import CtaButton from "./CtaButton.vue";
import CustomBadge from "./CustomBadge.vue";
import { DollarSign } from "lucide-vue-next";

const billingPeriod = ref("annually");

const pricing = {
    starter: { monthly: 0, annually: 0 },
    professional: { monthly: 20, annually: 16 },
    enterprise: { monthly: 200, annually: 160 },
};

const features = {
    starter: [
        "Up to 3 projects",
        "Basic documentation tools",
        "Community support",
        "Standard templates",
        "Basic analytics",
    ],
    professional: [
        "Unlimited projects",
        "Advanced documentation tools",
        "Priority support",
        "Custom templates",
        "Advanced analytics",
        "Team collaboration",
        "API access",
        "Custom integrations",
    ],
    enterprise: [
        "Everything in Professional",
        "Dedicated account manager",
        "24/7 phone support",
        "Custom onboarding",
        "Advanced security features",
        "SSO integration",
        "Custom contracts",
        "White-label options",
    ],
};

const toggleBilling = (period) => {
    billingPeriod.value = period;
};
</script>