<template>
    <div class="w-full border-b border-website-primary/10 flex flex-col justify-center items-center">
        <!-- Header Section -->
        <div
            class="self-stretch px-4 sm:px-6 lg:px-0  py-8 sm:py-12 md:py-16 border-b border-website-primary/10 flex justify-center items-center gap-6">
            <div
                class="w-full max-w-[616px]  px-4 sm:px-6 py-4 sm:py-5 overflow-hidden rounded-lg flex flex-col justify-start items-center gap-3 sm:gap-4 shadow-none">
                <!-- Badge (same border) -->
                <CustomBadge :text="'Bento Grid'" :icon="'LayoutGridIcon'" />

                <div
                    class="w-full max-w-[598.06px] lg:w-[598.06px] text-center flex justify-center flex-col text-[#49423D] text-xl sm:text-2xl md:text-3xl lg:text-5xl font-semibold leading-tight md:leading-[60px] font-sans tracking-tight">
                    Built for absolute clarity and focused work
                </div>
                <div
                    class="self-stretch text-center text-website-secondary/50text-sm sm:text-base font-normal leading-6 sm:leading-7 font-sans">
                    Stay focused with tools that organize, connect
                    <br />
                    and turn information into confident decisions.
                </div>
            </div>
        </div>

        <!-- Bento Grid Content -->
        <div class="self-stretch flex justify-center items-start">
            <!-- Left decorative pattern -->
            <CrossedLinesDecoration />

            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-0 border-l border-r border-website-primary/10">
                <!-- Top Left - Smart. Simple. Brilliant. -->
                <div
                    class="border-b border-r-0 md:border-r border-website-primary/10 p-4 sm:p-6 md:p-8 lg:p-12 flex flex-col justify-start items-start gap-4 sm:gap-6">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-website-secondary text-lg sm:text-xl font-semibold leading-tight font-sans">
                            Smart. Simple. Brilliant.
                        </h3>
                        <p class="text-website-secondary/50 text-sm md:text-base font-normal leading-relaxed font-sans">
                            Your data is beautifully organized so you see everything clearly without the clutter.
                        </p>
                    </div>
                    <div
                        class="w-full h-[200px] sm:h-[250px] md:h-[300px] rounded-lg flex items-center justify-center overflow-hidden">
                        <SmartSimpleBrilliant width="100%" height="100%" theme="light"
                            class="scale-50 sm:scale-65 md:scale-75 lg:scale-90" />
                    </div>
                </div>

                <!-- Top Right - Semless Tracking -->
                <div
                    class="border-b border-website-primary/10 p-4 sm:p-6 md:p-8 lg:p-12 flex flex-col justify-start items-start gap-4 sm:gap-6">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-4">
                            <CalendarClockIcon />
                            <h3 class="text-website-secondary font-semibold leading-tight font-sans text-lg sm:text-xl">
                                Track attendance with ease
                            </h3>
                        </div>
                        <p class="text-website-secondary/50 text-sm md:text-base font-normal leading-relaxed font-sans">
                            Easily track every check-in and check-out, keeping your records accurate and effortless.
                        </p>
                    </div>

                    <!-- Illustration -->
                    <div class="relative -mx-6 -mt-6 w-full box-content h-full overflow-hidden px-6 pt-6"
                        style="--mask-bottom: linear-gradient(to bottom, #000 50%, transparent 100%); mask-image: var(--mask-bottom); mask-composite: intersect">
                        <div
                            class="w-full h-full translate-y-4 p-1 rounded-lg  shadow-[0_0_0_1px_#00000022,0_0_24px_#00000011]">
                            <div class="relative min-h-[65px]  border border-[#db67fe] bg-[#fae7ff]  m-2 py-2  rounded-lg"
                                style="background-image: url('data:image/svg+xml,%3Csvg width=%225%22 height=%225%22 viewBox=%220 0 5 5%22 stroke-width=%220.5%22 stroke=%22%23E9ABFC%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cpath d=%22M-1 5L5 -1M3 6L6 3%22/%3E%3C/svg%3E%0A');">
                                <div
                                    class="group absolute -top-[12px] w-full flex items-center justify-between  bg-white p-2 text-sm border rounded-lg scale-[1.09] transition duration-300 will-change-transform hover:-translate-y-1 hover:shadow-[0_0_0_1px_#00000022,0_8px_16px_#00000011] hover:bg-white  ">
                                    <div class="flex items-center space-x-4">
                                        <div class="p-2 rounded-full bg-green-100 text-green-600">
                                            <LogIn class="h-4 w-4" />
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex items-center space-x-2">
                                                <span class="font-medium">Mohammed</span>
                                                <Badge variant="secondary" class="hidden lg:block">EMP-MH231</Badge>
                                            </div>
                                            <div class="flex items-center   text-muted-foreground">
                                                <span>Software Engineer</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <Badge class="bg-green-900 text-green-100">
                                                Check In
                                            </Badge>
                                        </div>
                                        <div class=" text-muted-foreground">
                                            <div class=" font-medium">8:24 AM</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class=" text-sm flex items-center justify-between m-2 p-2  border rounded-lg  hover:bg-primary/10 transition-colors ">
                                <div class="flex items-center space-x-4">
                                    <div class="p-2 rounded-full bg-red-100 text-red-600">
                                        <LogOut class="h-4 w-4" />
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium">Mohammed</span>
                                            <Badge variant="secondary" class="hidden lg:block">EMP-MH231</Badge>
                                        </div>
                                        <div class="flex items-center   text-muted-foreground">
                                            <span>Software Engineer</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right space-y-1">
                                    <div class="flex items-center space-x-2">
                                        <Badge class="bg-red-900 text-red-100">
                                            Check Out
                                        </Badge>
                                    </div>
                                    <div class=" text-muted-foreground">
                                        <div class=" font-medium">5:12 PM</div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class=" text-sm flex items-center justify-between m-2 p-2  border rounded-lg  hover:bg-primary/10 transition-colors ">
                                <div class="flex items-center space-x-4">
                                    <div class="p-2 rounded-full bg-green-100 text-green-600">
                                        <LogIn class="h-4 w-4" />
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium">Ali</span>
                                            <Badge variant="secondary" class="hidden lg:block">EMP-Al231</Badge>
                                        </div>
                                        <div class="flex items-center   text-muted-foreground">
                                            <span>Graphic Designer</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right space-y-1">
                                    <div class="flex items-center space-x-2">
                                        <Badge class="bg-green-900 text-green-100">
                                            Check In
                                        </Badge>
                                    </div>
                                    <div class=" text-muted-foreground">
                                        <div class=" font-medium">8:24 AM</div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class=" text-sm flex items-center justify-between m-2 p-2  border rounded-lg  hover:bg-primary/10 transition-colors ">
                                <div class="flex items-center space-x-4">
                                    <div class="p-2 rounded-full bg-green-100 text-green-600">
                                        <LogIn class="h-4 w-4" />
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium">Danny</span>
                                            <Badge variant="secondary" class="hidden lg:block">EMP-DN231</Badge>
                                        </div>
                                        <div class="flex items-center  text-muted-foreground">
                                            <span>HR</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right space-y-1">
                                    <div class="flex items-center space-x-2">
                                        <Badge class="bg-green-900 text-green-100">
                                            Check In
                                        </Badge>
                                    </div>
                                    <div class=" text-muted-foreground">
                                        <div class=" font-medium">8:24 AM</div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class=" text-sm flex items-center justify-between m-2 p-2  border rounded-lg  hover:bg-primary/10 transition-colors ">
                                <div class="flex items-center space-x-4">
                                    <div class="p-2 rounded-full bg-rd-100 text-red-600">
                                        <LogOut class="h-4 w-4" />
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium">Mohammed</span>
                                            <Badge variant="secondary" class="hidden lg:block">EMP-MH231</Badge>
                                        </div>
                                        <div class="flex items-center   text-muted-foreground">
                                            <span>Software Engineer</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right space-y-1">
                                    <div class="flex items-center space-x-2">
                                        <Badge class="bg-red-900 text-red-100">
                                            Check Out
                                        </Badge>
                                    </div>
                                    <div class=" text-muted-foreground">
                                        <div class=" font-medium">8:24 AM</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Bottom Left - Effortless integration -->
                <div
                    class="border-r-0 md:border-r border-website-primary/10 p-4 sm:p-6 md:p-8 lg:p-12 flex flex-col justify-start items-start gap-4 sm:gap-6 bg-transparent">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-website-secondary text-lg sm:text-xl font-semibold leading-tight font-sans">
                            Effortless integration
                        </h3>
                        <p class="text-website-secondary/40 text-sm md:text-base font-normal leading-relaxed font-sans">
                            All your favorite tools connect in one place and work together seamlessly by design.
                        </p>
                    </div>
                    <div
                        class="w-full h-[200px] sm:h-[250px] md:h-[300px] rounded-lg flex overflow-hidden justify-center items-center relative bg-transparent">
                        <div class="w-full h-full flex items-center justify-center bg-transparent">
                            <IntegratedSystemsBeam class="max-w-full max-h-full" />
                        </div>

                    </div>
                </div>

                <!-- Bottom Right - Your Work Sync -->
                <div
                    class="p-4 sm:p-6 md:p-8 lg:p-12 flex flex-col justify-start items-start gap-4 sm:gap-6 overflow-hidden">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-4">
                            <Container />
                            <h3 class="text-website-secondary text-lg sm:text-xl font-semibold leading-tight font-sans">
                                Your Work, In Sync
                            </h3>
                        </div>
                        <p class="text-website-secondary/40 text-sm md:text-base font-normal leading-relaxed font-sans">

                            Seamlessly create, edit, and delete files all in perfect sync with your Drive account.
                        </p>
                    </div>
                    <div class="relative  cursor-default font-sans text-sm tracking-normal">
                        <div class="w-full overflow-hidden">
                            <div class="-mt-8 -ml-8 size-full pt-8 pl-8" style=" --mask-bottom: linear-gradient(to bottom, #000 70%, transparent 100%);
                            --mask-right: linear-gradient(to right, #000 80%, transparent 100%);
                            mask-image: var(--mask-bottom), var(--mask-right);
                            mask-composite: intersect;
                        ">
                                <div
                                    class=" origin-top-left translate-y-12 px-2 rotate-[-5deg] skew-x-[10deg] text-[13px]">
                                    <div
                                        class="w-[520px]  space-y-10 rounded-lg p-6 shadow-[0_0_0_1px_#00000022,0_0_24px_#00000011]">
                                        <div class="space-y-1">
                                            <p class="font-medium text-strong">Your Drive, Integrated</p>
                                            <p>
                                                Manage files effortlessly inside the system, with every change in
                                                perfect sync with Google Drive.
                                            </p>


                                        </div>

                                        <!-- Files and Folders (Grid Layout) -->
                                        <div
                                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-2 gap-4">
                                            <div class="relative ">
                                                <div class="w-full min-h-[100px] space-x-2 border border-[#ff9a24] bg-[#ffe6c8] py-2 pr-1 pl-3 rounded-lg"
                                                    style="background-image: url('data:image/svg+xml,%3Csvg width=%225%22 height=%225%22 viewBox=%220 0 5 5%22 stroke-width=%220.5%22 stroke=%22%23ff9a24%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cpath d=%22M-1 5L5 -1M3 6L6 3%22/%3E%3C/svg%3E%0A');">
                                                </div>

                                                <div
                                                    class="group absolute top-[-24px] left-[12px] z-20 flex w-full  rounded-md bg-card py-2 pr-1 pl-3 shadow-[0_0_0_1px_#00000022,0_8px_16px_#00000022] transition duration-300 will-change-transform hover:translate-x-1 hover:-translate-y-1 hover:shadow-[0_0_0_1px_#00000022,0_8px_16px_#00000011]">
                                                    <div class="p-4">
                                                        <div class="flex items-center gap-3 mb-2">
                                                            <Folder class="h-10 w-10 text-muted-foreground" />
                                                            <div class="flex-1 min-w-0">
                                                                <h3 class="font-medium text-sm truncate">Contracts</h3>
                                                                <p class="text-xs text-muted-foreground">15 items</p>
                                                            </div>
                                                        </div>
                                                        <div class="text-xs text-muted-foreground">
                                                            Modified May 15, 2025
                                                        </div>
                                                    </div>
                                                    <div class="absolute top-2 right-2  transition-opacity">
                                                        <DropdownMenu>
                                                            <DropdownMenuTrigger asChild>
                                                                <Button variant="ghost" size="icon"
                                                                    class="h-8 w-8 rounded-full">
                                                                    <MoreVertical class="h-4 w-4" />
                                                                </Button>
                                                            </DropdownMenuTrigger>
                                                        </DropdownMenu>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- PDF File Item -->
                                            <div class="relative bg-card rounded-lg border shadow-sm ">
                                                <div class="p-4">
                                                    <div class="flex items-center gap-3 mb-2">
                                                        <FileText class="h-10 w-10 text-muted-foreground" />
                                                        <div class="flex-1 min-w-0">
                                                            <h3 class="font-medium text-sm truncate">Q1 Report.pdf</h3>
                                                            <p class="text-xs text-muted-foreground">2.4 MB</p>
                                                        </div>
                                                    </div>
                                                    <div class="text-xs text-muted-foreground">
                                                        Modified May 12, 2025
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Excel File Item -->
                                            <div class=" relative bg-card rounded-lg border shadow-sm">
                                                <div class="p-4">
                                                    <div class="flex items-center gap-3 mb-2">
                                                        <FileSpreadsheet class="h-10 w-10 text-muted-foreground" />
                                                        <div class="flex-1 min-w-0">
                                                            <h3 class="font-medium text-sm truncate">Financial
                                                                Projections.xlsx</h3>
                                                            <p class="text-xs text-muted-foreground">1.8 MB</p>
                                                        </div>
                                                    </div>
                                                    <div class="text-xs text-muted-foreground">
                                                        Modified May 10, 2025
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Right decorative pattern -->
            <CrossedLinesDecoration />
        </div>
    </div>

</template>

<script setup>
import { CalendarClockIcon, Container, Dot, FileSliders, FileSpreadsheet, FileText, Folder, LayoutGridIcon, LogIn, LogOut, MoreVertical, PenLine, Share, Trash } from 'lucide-vue-next';
import CrossedLinesDecoration from './CrossedLinesDecoration.vue';
import CustomBadge from './CustomBadge.vue';
import DropdownMenu from '../ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '../ui/dropdown-menu/DropdownMenuTrigger.vue';
import Button from '../ui/button/Button.vue';
import DropdownMenuContent from '../ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '../ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuSeparator from '../ui/dropdown-menu/DropdownMenuSeparator.vue';
import Badge from '../ui/badge/Badge.vue';
import IntegratedSystemsBeam from './IntegratedSystemsBeam.vue';

</script>