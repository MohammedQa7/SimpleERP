<template>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
        <h2 class="text-lg font-medium">My Drive</h2>
        <div class="flex">
            <div class="flex items-center gap-2 flex-wrap">
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="sm" class="h-8 gap-1 px-2">
                            <ListFilter class="h-4 w-4" />
                            <span>Sort</span>
                            <ChevronDown class="h-4 w-4 opacity-50" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuRadioGroup value="name">
                            <DropdownMenuRadioItem value="name">Name</DropdownMenuRadioItem>
                            <DropdownMenuRadioItem value="modified">Last modified
                            </DropdownMenuRadioItem>
                            <DropdownMenuRadioItem value="size">Size</DropdownMenuRadioItem>
                        </DropdownMenuRadioGroup>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
            <!-- Action buttons (Google Drive-style) -->
            <div class="flex items-center gap-2 flex-wrap">
                <Tooltip>
                    <TooltipTrigger asChild>
                        <Button variant="outline" size="icon" class="rounded-full ml-2">
                            <Upload class="h-4 w-4" />
                        </Button>
                    </TooltipTrigger>
                    <TooltipContent>Upload files</TooltipContent>
                </Tooltip>

                <Tooltip>
                    <TooltipTrigger asChild>
                        <CreateFolderDialog />
                    </TooltipTrigger>
                    <TooltipContent>New folder</TooltipContent>
                </Tooltip>
            </div>


        </div>
    </div>

    <!-- File Type Filter (Google Drive-style) -->
    <div class="flex flex-wrap gap-2 mb-4">
        <Button variant="outline" class="rounded-full text-sm h-8 px-3 bg-background">
            All items
        </Button>
        <Button variant="outline" class="rounded-full text-sm h-8 px-3">
            <FileText class="mr-1 h-3.5 w-3.5" />
            Documents
        </Button>
        <Button variant="outline" class="rounded-full text-sm h-8 px-3">
            <FileSpreadsheet class="mr-1 h-3.5 w-3.5" />
            Spreadsheets
        </Button>
        <Button variant="outline" class="rounded-full text-sm h-8 px-3">
            <FileImage class="mr-1 h-3.5 w-3.5" />
            Images
        </Button>
        <Button variant="outline" class="rounded-full text-sm h-8 px-3">
            <Folder class="mr-1 h-3.5 w-3.5" />
            Folders
        </Button>
    </div>

    <!-- Files and Folders (Grid Layout) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <!-- Folder Item -->
        <div class="group relative bg-card rounded-lg border shadow-sm hover:shadow-md transition-all">
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
            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" class="h-8 w-8 rounded-full">
                            <MoreVertical class="h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem>
                            <Share class="mr-2 h-4 w-4" />
                            <span>Share</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <PenLine class="mr-2 h-4 w-4" />
                            <span>Rename</span>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem class="text-destructive">
                            <Trash class="mr-2 h-4 w-4" />
                            <span>Delete</span>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>

        <!-- PDF File Item -->
        <div class="group relative bg-card rounded-lg border shadow-sm hover:shadow-md transition-all">
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
            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" class="h-8 w-8 rounded-full">
                            <MoreVertical class="h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem>
                            <Eye class="mr-2 h-4 w-4" />
                            <span>Preview</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Download class="mr-2 h-4 w-4" />
                            <span>Download</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Share class="mr-2 h-4 w-4" />
                            <span>Share</span>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem class="text-destructive">
                            <Trash class="mr-2 h-4 w-4" />
                            <span>Delete</span>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>

        <!-- Excel File Item -->
        <div class="group relative bg-card rounded-lg border shadow-sm hover:shadow-md transition-all">
            <div class="p-4">
                <div class="flex items-center gap-3 mb-2">
                    <FileSpreadsheet class="h-10 w-10 text-muted-foreground" />
                    <div class="flex-1 min-w-0">
                        <h3 class="font-medium text-sm truncate">Financial Projections.xlsx</h3>
                        <p class="text-xs text-muted-foreground">1.8 MB</p>
                    </div>
                </div>
                <div class="text-xs text-muted-foreground">
                    Modified May 10, 2025
                </div>
            </div>
            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" class="h-8 w-8 rounded-full">
                            <MoreVertical class="h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem>
                            <Eye class="mr-2 h-4 w-4" />
                            <span>Preview</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Download class="mr-2 h-4 w-4" />
                            <span>Download</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Share class="mr-2 h-4 w-4" />
                            <span>Share</span>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem class="text-destructive">
                            <Trash class="mr-2 h-4 w-4" />
                            <span>Delete</span>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>

        <!-- Image File Item -->
        <div class="group relative bg-card rounded-lg border shadow-sm hover:shadow-md transition-all">
            <div class="p-4">
                <div class="flex items-center gap-3 mb-2">
                    <FileImage class="h-10 w-10 text-muted-foreground" />
                    <div class="flex-1 min-w-0">
                        <h3 class="font-medium text-sm truncate">Product Mockup.png</h3>
                        <p class="text-xs text-muted-foreground">3.2 MB</p>
                    </div>
                </div>
                <div class="text-xs text-muted-foreground">
                    Modified May 8, 2025
                </div>
            </div>
            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" class="h-8 w-8 rounded-full">
                            <MoreVertical class="h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem>
                            <Eye class="mr-2 h-4 w-4" />
                            <span>Preview</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Download class="mr-2 h-4 w-4" />
                            <span>Download</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Share class="mr-2 h-4 w-4" />
                            <span>Share</span>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem class="text-destructive">
                            <Trash class="mr-2 h-4 w-4" />
                            <span>Delete</span>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>

        <!-- Word File Item -->
        <div class="group relative bg-card rounded-lg border shadow-sm hover:shadow-md transition-all">
            <div class="p-4">
                <div class="flex items-center gap-3 mb-2">
                    <FileText class="h-10 w-10 text-muted-foreground" />
                    <div class="flex-1 min-w-0">
                        <h3 class="font-medium text-sm truncate">Meeting Notes.docx</h3>
                        <p class="text-xs text-muted-foreground">1.1 MB</p>
                    </div>
                </div>
                <div class="text-xs text-muted-foreground">
                    Modified May 5, 2025
                </div>
            </div>
            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" class="h-8 w-8 rounded-full">
                            <MoreVertical class="h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem>
                            <Eye class="mr-2 h-4 w-4" />
                            <span>Preview</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Download class="mr-2 h-4 w-4" />
                            <span>Download</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Share class="mr-2 h-4 w-4" />
                            <span>Share</span>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem class="text-destructive">
                            <Trash class="mr-2 h-4 w-4" />
                            <span>Delete</span>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>

        <!-- Another Folder Item -->
        <div class="group relative bg-card rounded-lg border shadow-sm hover:shadow-md transition-all">
            <div class="p-4">
                <div class="flex items-center gap-3 mb-2">
                    <Folder class="h-10 w-10 text-muted-foreground" />
                    <div class="flex-1 min-w-0">
                        <h3 class="font-medium text-sm truncate">Marketing Assets</h3>
                        <p class="text-xs text-muted-foreground">8 items</p>
                    </div>
                </div>
                <div class="text-xs text-muted-foreground">
                    Modified May 3, 2025
                </div>
            </div>
            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" class="h-8 w-8 rounded-full">
                            <MoreVertical class="h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem>
                            <Share class="mr-2 h-4 w-4" />
                            <span>Share</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <PenLine class="mr-2 h-4 w-4" />
                            <span>Rename</span>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem class="text-destructive">
                            <Trash class="mr-2 h-4 w-4" />
                            <span>Delete</span>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref } from 'vue'
import {
    ChevronDown,
    Download,
    Eye,
    FileImage,
    FileSpreadsheet,
    FileText,
    Folder,
    FolderPlus,
    ListFilter,
    MoreVertical,
    PenLine,
    Share,
    Trash,
    Upload,
} from 'lucide-vue-next'

// Import shadcn-vue components
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuRadioGroup, DropdownMenuRadioItem } from '@/components/ui/dropdown-menu'
import { Tooltip, TooltipContent, TooltipTrigger, } from '@/components/ui/tooltip'
import CreateFolderDialog from './CreateFolderDialog.vue'
const isCreateFolderDialogOpened = ref(false);



</script>