<template>
    <div ref="containerRef"
        class="relative flex w-full h-[500px] items-center justify-center overflow-hidden rounded-lg">
        <div class="flex size-full max-h-[200px] max-w-lg flex-col items-stretch justify-between gap-10">
            <div class="flex flex-row items-center justify-between">
                <div ref="div1Ref"
                    class="z-10 flex size-12 items-center justify-center rounded-full border-2 bg-white p-2 shadow-[0_0_20px_-12px_rgba(0,0,0,0.8)] dark:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100"
                        viewBox="0 0 48 48">
                        <path fill="#169154" d="M29,6H15.744C14.781,6,14,6.781,14,7.744v7.259h15V6z"></path>
                        <path fill="#18482a" d="M14,33.054v7.202C14,41.219,14.781,42,15.743,42H29v-8.946H14z"></path>
                        <path fill="#0c8045" d="M14 15.003H29V24.005000000000003H14z"></path>
                        <path fill="#17472a" d="M14 24.005H29V33.055H14z"></path>
                        <g>
                            <path fill="#29c27f" d="M42.256,6H29v9.003h15V7.744C44,6.781,43.219,6,42.256,6z"></path>
                            <path fill="#27663f" d="M29,33.054V42h13.257C43.219,42,44,41.219,44,40.257v-7.202H29z">
                            </path>
                            <path fill="#19ac65" d="M29 15.003H44V24.005000000000003H29z"></path>
                            <path fill="#129652" d="M29 24.005H44V33.055H29z"></path>
                        </g>
                        <path fill="#0c7238"
                            d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638 C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z">
                        </path>
                        <path fill="#fff"
                            d="M9.807 19L12.193 19 14.129 22.754 16.175 19 18.404 19 15.333 24 18.474 29 16.123 29 14.013 25.07 11.912 29 9.526 29 12.719 23.982z">
                        </path>
                    </svg>
                </div>
                <div ref="div5Ref"
                    class="z-10 flex size-12 items-center justify-center rounded-full border-2 bg-white p-2 shadow-[0_0_20px_-12px_rgba(0,0,0,0.8)]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 49.4 512 399.42">
                        <g fill="none" fill-rule="evenodd">
                            <g fill-rule="nonzero">
                                <path fill="#4285f4"
                                    d="M34.91 448.818h81.454V251L0 163.727V413.91c0 19.287 15.622 34.91 34.91 34.91z" />
                                <path fill="#34a853"
                                    d="M395.636 448.818h81.455c19.287 0 34.909-15.622 34.909-34.909V163.727L395.636 251z" />
                                <path fill="#fbbc04"
                                    d="M395.636 99.727V251L512 163.727v-46.545c0-43.142-49.25-67.782-83.782-41.891z" />
                            </g>
                            <path fill="#ea4335" d="M116.364 251V99.727L256 204.455 395.636 99.727V251L256 355.727z" />
                            <path fill="#c5221f" fill-rule="nonzero"
                                d="M0 117.182v46.545L116.364 251V99.727L83.782 75.291C49.25 49.4 0 74.04 0 117.18z" />
                        </g>
                    </svg>
                </div>
            </div>
            <div class="flex flex-row items-center justify-between">
                <div ref="div2Ref"
                    class="z-10 flex size-12 items-center justify-center rounded-full border-2 bg-white p-2 shadow-[0_0_20px_-12px_rgba(0,0,0,0.8)] dark:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100"
                        viewBox="0 0 48 48">
                        <path fill="#2d92d4"
                            d="M42.256,6H15.744C14.781,6,14,6.781,14,7.744v7.259h30V7.744C44,6.781,43.219,6,42.256,6z">
                        </path>
                        <path fill="#2150a9"
                            d="M14,33.054v7.202C14,41.219,14.781,42,15.743,42h26.513C43.219,42,44,41.219,44,40.256v-7.202H14z">
                        </path>
                        <path fill="#2d83d4" d="M14 15.003H44V24.005000000000003H14z"></path>
                        <path fill="#2e70c9" d="M14 24.005H44V33.055H14z"></path>
                        <path fill="#00488d"
                            d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638 C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z">
                        </path>
                        <path fill="#fff"
                            d="M18.403 19L16.857 26.264 15.144 19 12.957 19 11.19 26.489 9.597 19 7.641 19 9.985 29 12.337 29 14.05 21.311 15.764 29 18.015 29 20.359 19z">
                        </path>
                    </svg>
                </div>
                <div ref="div4Ref"
                    class="z-10 flex size-16 items-center justify-center rounded-full border-2 bg-website-background border-none p-2 text-black shadow-[0_0_20px_-12px_rgba(0,0,0,0.8)]">
                    <AppLogoIcon class="w-full" />
                </div>
                <div ref="div6Ref"
                    class="z-10 flex size-12 items-center justify-center rounded-full border-2 bg-white p-2 shadow-[0_0_20px_-12px_rgba(0,0,0,0.8)]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 87.3 78">
                        <path fill="#0066da"
                            d="m6.6 66.85 3.85 6.65c.8 1.4 1.95 2.5 3.3 3.3L27.5 53H0c0 1.55.4 3.1 1.2 4.5z" />
                        <path fill="#00ac47"
                            d="M43.65 25 29.9 1.2c-1.35.8-2.5 1.9-3.3 3.3l-25.4 44A9.06 9.06 0 0 0 0 53h27.5z" />
                        <path fill="#ea4335"
                            d="M73.55 76.8c1.35-.8 2.5-1.9 3.3-3.3l1.6-2.75L86.1 57.5c.8-1.4 1.2-2.95 1.2-4.5H59.798l5.852 11.5z" />
                        <path fill="#00832d"
                            d="M43.65 25 57.4 1.2C56.05.4 54.5 0 52.9 0H34.4c-1.6 0-3.15.45-4.5 1.2z" />
                        <path fill="#2684fc"
                            d="M59.8 53H27.5L13.75 76.8c1.35.8 2.9 1.2 4.5 1.2h50.8c1.6 0 3.15-.45 4.5-1.2z" />
                        <path fill="#ffba00"
                            d="m73.4 26.5-12.7-22c-.8-1.4-1.95-2.5-3.3-3.3L43.65 25 59.8 53h27.45c0-1.55-.4-3.1-1.2-4.5z" />
                    </svg>
                </div>
            </div>
            <div class="flex flex-row items-center justify-between">
                <div ref="div3Ref"
                    class="z-10 flex size-12 items-center justify-center rounded-full border-2 bg-white p-2 shadow-[0_0_20px_-12px_rgba(0,0,0,0.8)] dark:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="76.57" height="32" viewBox="0 0 512 214">
                        <path fill="#635BFF"
                            d="M512 110.08c0-36.409-17.636-65.138-51.342-65.138c-33.85 0-54.33 28.73-54.33 64.854c0 42.808 24.179 64.426 58.88 64.426c16.925 0 29.725-3.84 39.396-9.244v-28.445c-9.67 4.836-20.764 7.823-34.844 7.823c-13.796 0-26.027-4.836-27.591-21.618h69.547c0-1.85.284-9.245.284-12.658m-70.258-13.511c0-16.071 9.814-22.756 18.774-22.756c8.675 0 17.92 6.685 17.92 22.756zm-90.31-51.627c-13.939 0-22.899 6.542-27.876 11.094l-1.85-8.818h-31.288v165.83l35.555-7.537l.143-40.249c5.12 3.698 12.657 8.96 25.173 8.96c25.458 0 48.64-20.48 48.64-65.564c-.142-41.245-23.609-63.716-48.498-63.716m-8.534 97.991c-8.391 0-13.37-2.986-16.782-6.684l-.143-52.765c3.698-4.124 8.818-6.968 16.925-6.968c12.942 0 21.902 14.506 21.902 33.137c0 19.058-8.818 33.28-21.902 33.28M241.493 36.551l35.698-7.68V0l-35.698 7.538zm0 10.809h35.698v124.444h-35.698zm-38.257 10.524L200.96 47.36h-30.72v124.444h35.556V87.467c8.39-10.951 22.613-8.96 27.022-7.396V47.36c-4.551-1.707-21.191-4.836-29.582 10.524m-71.112-41.386l-34.702 7.395l-.142 113.92c0 21.05 15.787 36.551 36.836 36.551c11.662 0 20.195-2.133 24.888-4.693V140.8c-4.55 1.849-27.022 8.391-27.022-12.658V77.653h27.022V47.36h-27.022zM35.982 83.484c0-5.546 4.551-7.68 12.09-7.68c10.808 0 24.461 3.272 35.27 9.103V51.484c-11.804-4.693-23.466-6.542-35.27-6.542C19.2 44.942 0 60.018 0 85.192c0 39.252 54.044 32.995 54.044 49.92c0 6.541-5.688 8.675-13.653 8.675c-11.804 0-26.88-4.836-38.827-11.378v33.849c13.227 5.689 26.596 8.106 38.827 8.106c29.582 0 49.92-14.648 49.92-40.106c-.142-42.382-54.329-34.845-54.329-50.774" />
                    </svg>
                </div>
                <div ref="div7Ref"
                    class="z-10 flex size-12 items-center justify-center rounded-full border-2 bg-white p-2 shadow-[0_0_20px_-12px_rgba(0,0,0,0.8)]">

                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100"
                        viewBox="0 0 48 48">
                        <path fill="#1565C0"
                            d="M18.7,13.767l0.005,0.002C18.809,13.326,19.187,13,19.66,13h13.472c0.017,0,0.034-0.007,0.051-0.006C32.896,8.215,28.887,6,25.35,6H11.878c-0.474,0-0.852,0.335-0.955,0.777l-0.005-0.002L5.029,33.813l0.013,0.001c-0.014,0.064-0.039,0.125-0.039,0.194c0,0.553,0.447,0.991,1,0.991h8.071L18.7,13.767z">
                        </path>
                        <path fill="#039BE5"
                            d="M33.183,12.994c0.053,0.876-0.005,1.829-0.229,2.882c-1.281,5.995-5.912,9.115-11.635,9.115c0,0-3.47,0-4.313,0c-0.521,0-0.767,0.306-0.88,0.54l-1.74,8.049l-0.305,1.429h-0.006l-1.263,5.796l0.013,0.001c-0.014,0.064-0.039,0.125-0.039,0.194c0,0.553,0.447,1,1,1h7.333l0.013-0.01c0.472-0.007,0.847-0.344,0.945-0.788l0.018-0.015l1.812-8.416c0,0,0.126-0.803,0.97-0.803s4.178,0,4.178,0c5.723,0,10.401-3.106,11.683-9.102C42.18,16.106,37.358,13.019,33.183,12.994z">
                        </path>
                        <path fill="#283593"
                            d="M19.66,13c-0.474,0-0.852,0.326-0.955,0.769L18.7,13.767l-2.575,11.765c0.113-0.234,0.359-0.54,0.88-0.54c0.844,0,4.235,0,4.235,0c5.723,0,10.432-3.12,11.713-9.115c0.225-1.053,0.282-2.006,0.229-2.882C33.166,12.993,33.148,13,33.132,13H19.66z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <AnimatedBeam :container-ref="containerRef" :from-ref="div1Ref" :to-ref="div4Ref" :curvature="-75"
            :end-y-offset="-10" />
        <AnimatedBeam :container-ref="containerRef" :from-ref="div2Ref" :to-ref="div4Ref" />
        <AnimatedBeam :container-ref="containerRef" :from-ref="div3Ref" :to-ref="div4Ref" :curvature="75"
            :end-y-offset="10" />
        <AnimatedBeam :container-ref="containerRef" :from-ref="div5Ref" :to-ref="div4Ref" :curvature="-75"
            :end-y-offset="-10" />
        <AnimatedBeam :container-ref="containerRef" :from-ref="div6Ref" :to-ref="div4Ref" />
        <AnimatedBeam :container-ref="containerRef" :from-ref="div7Ref" :to-ref="div4Ref" :curvature="75"
            :end-y-offset="10" />
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import AnimatedBeam from "../AnimatedBeam.vue";
import AppLogoIcon from "../AppLogoIcon.vue";

const containerRef = ref(null);
const div1Ref = ref(null);
const div2Ref = ref(null);
const div3Ref = ref(null);
const div4Ref = ref(null);
const div5Ref = ref(null);
const div6Ref = ref(null);
const div7Ref = ref(null);
</script>