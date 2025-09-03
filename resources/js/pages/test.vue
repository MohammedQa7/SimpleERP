<template>
  <div class="min-h-screen bg-background text-foreground">
    <!-- TooltipProvider -->
    <TooltipProvider>
      <!-- Header (Google Drive-inspired) -->
      <header class="sticky top-0 z-40 w-full border-b bg-background shadow-sm">
        <div class="container flex h-16 items-center space-x-4 px-4 sm:px-6">
          <div class="flex items-center gap-2">
            <FileText class="h-6 w-6 text-primary" />
            <span class="font-bold text-xl">DriveDMS</span>
          </div>

          <!-- Google Drive-like search bar -->
          <div class="flex-1 max-w-2xl mx-4 hidden sm:block">
            <div class="relative">
              <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <Input type="search" placeholder="Search in Drive"
                class="pl-10 pr-4 py-2 h-10 w-full bg-accent/50 hover:bg-accent focus-within:bg-background focus-within:shadow-md transition-all border-0 focus-visible:ring-0" />
            </div>
          </div>

          <div class="flex items-center gap-2 ml-auto">
            <!-- Mobile search button -->
            <Button variant="ghost" size="icon" class="rounded-full sm:hidden">
              <Search class="h-5 w-5" />
            </Button>

            <Tooltip>
              <TooltipTrigger asChild>
                <Button variant="ghost" size="icon" class="rounded-full hidden sm:flex">
                  <HelpCircle class="h-5 w-5" />
                </Button>
              </TooltipTrigger>
              <TooltipContent>Help</TooltipContent>
            </Tooltip>

            <Tooltip>
              <TooltipTrigger asChild>
                <Button variant="ghost" size="icon" class="rounded-full">
                  <Settings class="h-5 w-5" />
                </Button>
              </TooltipTrigger>
              <TooltipContent>Settings</TooltipContent>
            </Tooltip>

            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <Avatar class="cursor-pointer h-9 w-9">
                  <AvatarImage src="https://v0.dev/placeholder.svg?height=36&width=36" alt="User avatar" />
                  <AvatarFallback>JD</AvatarFallback>
                </Avatar>
              </DropdownMenuTrigger>
              <DropdownMenuContent align="end" class="w-56">
                <div class="flex items-center justify-start gap-2 p-2">
                  <Avatar class="h-10 w-10">
                    <AvatarImage src="https://v0.dev/placeholder.svg?height=40&width=40" alt="User avatar" />
                    <AvatarFallback>JD</AvatarFallback>
                  </Avatar>
                  <div class="flex flex-col space-y-1">
                    <p class="text-sm font-medium">John Doe</p>
                    <p class="text-xs text-muted-foreground">john@example.com</p>
                  </div>
                </div>
                <DropdownMenuSeparator />
                <DropdownMenuItem>
                  <User class="mr-2 h-4 w-4" />
                  <span>Manage your Account</span>
                </DropdownMenuItem>
                <DropdownMenuItem>
                  <HardDrive class="mr-2 h-4 w-4" />
                  <span>Storage (2.4GB used)</span>
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem>
                  <LogOut class="mr-2 h-4 w-4" />
                  <span>Sign out</span>
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>
        </div>
      </header>



      <!-- Main Content -->
      <main class="container py-6 px-4 sm:px-6">
        <!-- Mobile search - only visible on small screens -->
        <div class="mb-6 sm:hidden">
          <div class="relative">
            <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
            <Input type="search" placeholder="Search in Drive"
              class="pl-10 pr-4 py-2 h-10 w-full bg-accent/50 hover:bg-accent focus-within:bg-background focus-within:shadow-md transition-all border-0 focus-visible:ring-0" />
          </div>
        </div>

        <div class="flex flex-col gap-6">
          <!-- Action buttons (Google Drive-style) -->
          <div class="flex items-center gap-2 flex-wrap">
            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <Button class="bg-primary text-primary-foreground hover:bg-primary/90">
                  <Plus class="mr-2 h-4 w-4" />
                  New
                  <ChevronDown class="ml-2 h-4 w-4 opacity-70" />
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent>
                <DropdownMenuItem>
                  <FileText class="mr-2 h-4 w-4" />
                  <span>Document</span>
                </DropdownMenuItem>
                <DropdownMenuItem>
                  <FileSpreadsheet class="mr-2 h-4 w-4" />
                  <span>Spreadsheet</span>
                </DropdownMenuItem>
                <DropdownMenuItem>
                  <Folder class="mr-2 h-4 w-4" />
                  <span>Folder</span>
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem>
                  <Upload class="mr-2 h-4 w-4" />
                  <span>File upload</span>
                </DropdownMenuItem>
                <DropdownMenuItem>
                  <FolderUp class="mr-2 h-4 w-4" />
                  <span>Folder upload</span>
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>

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
                <Button variant="outline" size="icon" class="rounded-full">
                  <FolderPlus class="h-4 w-4" />
                </Button>
              </TooltipTrigger>
              <TooltipContent>New folder</TooltipContent>
            </Tooltip>

            <!-- Simplified Storage Display -->
            <div class="ml-auto flex items-center gap-2 bg-card rounded-full border px-4 py-1.5 shadow-sm">
              <HardDrive class="h-4 w-4 text-primary" />
              <span class="text-sm font-medium">2.4 GB used</span>
            </div>
          </div>

          <!-- Quick Access Section (Google Drive-style) -->
          <div>
            <h2 class="text-lg font-medium mb-4">Quick access</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
              <Card class="overflow-hidden border hover:shadow-md transition-shadow">
                <CardContent class="p-0">
                  <div class="aspect-video bg-muted flex items-center justify-center">
                    <FileText class="h-10 w-10 text-muted-foreground/60" />
                  </div>
                  <div class="p-3">
                    <h3 class="text-sm font-medium truncate">Q4 Report.pdf</h3>
                    <p class="text-xs text-muted-foreground">Modified 2 days ago</p>
                  </div>
                </CardContent>
              </Card>

              <Card class="overflow-hidden border hover:shadow-md transition-shadow">
                <CardContent class="p-0">
                  <div class="aspect-video bg-muted flex items-center justify-center">
                    <FileSpreadsheet class="h-10 w-10 text-muted-foreground/60" />
                  </div>
                  <div class="p-3">
                    <h3 class="text-sm font-medium truncate">Budget 2025.xlsx</h3>
                    <p class="text-xs text-muted-foreground">Modified 3 days ago</p>
                  </div>
                </CardContent>
              </Card>

              <Card class="overflow-hidden border hover:shadow-md transition-shadow">
                <CardContent class="p-0">
                  <div class="aspect-video bg-muted flex items-center justify-center">
                    <FileText class="h-10 w-10 text-muted-foreground/60" />
                  </div>
                  <div class="p-3">
                    <h3 class="text-sm font-medium truncate">Client Agreement.docx</h3>
                    <p class="text-xs text-muted-foreground">Modified 5 days ago</p>
                  </div>
                </CardContent>
              </Card>

              <Card class="overflow-hidden border hover:shadow-md transition-shadow">
                <CardContent class="p-0">
                  <div class="aspect-video bg-muted flex items-center justify-center">
                    <Folder class="h-10 w-10 text-muted-foreground/60" />
                  </div>
                  <div class="p-3">
                    <h3 class="text-sm font-medium truncate">Project Assets</h3>
                    <p class="text-xs text-muted-foreground">8 items</p>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>

          <!-- Folder Navigation (Google Drive-style collapsible) -->
          <div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
              <h2 class="text-lg font-medium">My Drive</h2>
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
                      <DropdownMenuRadioItem value="modified">Last modified</DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="size">Size</DropdownMenuRadioItem>
                    </DropdownMenuRadioGroup>
                  </DropdownMenuContent>
                </DropdownMenu>

                <div class="flex border rounded-md">
                  <Button variant="ghost" size="icon" class="h-8 w-8 rounded-r-none border-r bg-accent">
                    <LayoutGrid class="h-4 w-4" />
                  </Button>
                  <Button variant="ghost" size="icon" class="h-8 w-8 rounded-l-none">
                    <List class="h-4 w-4" />
                  </Button>
                </div>
              </div>
            </div>

            <!-- Folder Tree (Collapsible) -->
            <Collapsible class="w-full border rounded-lg mb-4 shadow-sm">
              <CollapsibleTrigger
                class="flex w-full items-center justify-between p-3 hover:bg-accent hover:text-accent-foreground rounded-t-lg">
                <div class="flex items-center gap-2">
                  <FolderTree class="h-5 w-5" />
                  <span class="font-medium">Folder structure</span>
                </div>
                <ChevronDown class="h-4 w-4 transition-transform duration-200" />
              </CollapsibleTrigger>
              <CollapsibleContent>
                <div class="p-3 pt-0 border-t">
                  <div class="relative mb-2">
                    <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                    <Input type="search" placeholder="Search folders" class="pl-8" />
                  </div>
                  <ScrollArea className="h-[250px] pr-4">
                    <div class="grid gap-1 pt-2">
                      <Collapsible>
                        <CollapsibleTrigger
                          class="flex w-full items-center gap-1 rounded-md px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">
                          <ChevronRight class="h-4 w-4 text-muted-foreground transition-transform" />
                          <Folder class="h-4 w-4 text-muted-foreground" />
                          <span>Projects</span>
                          <Badge variant="outline" class="ml-auto">12</Badge>
                        </CollapsibleTrigger>
                      </Collapsible>

                      <Collapsible defaultOpen>
                        <CollapsibleTrigger
                          class="flex w-full items-center gap-1 rounded-md px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">
                          <ChevronRight class="h-4 w-4 text-muted-foreground transition-transform rotate-90" />
                          <Folder class="h-4 w-4 text-muted-foreground" />
                          <span>Documents</span>
                          <Badge variant="outline" class="ml-auto">34</Badge>
                        </CollapsibleTrigger>
                        <CollapsibleContent>
                          <div class="pl-6 mt-1 grid gap-1">
                            <Button variant="ghost" class="justify-start h-8 px-2">
                              <Folder class="mr-2 h-4 w-4" />
                              Reports
                              <Badge variant="outline" class="ml-auto">8</Badge>
                            </Button>
                            <Button variant="secondary" class="justify-start h-8 px-2">
                              <Folder class="mr-2 h-4 w-4" />
                              Contracts
                              <Badge variant="outline" class="ml-auto">15</Badge>
                            </Button>
                            <Button variant="ghost" class="justify-start h-8 px-2">
                              <Folder class="mr-2 h-4 w-4" />
                              Invoices
                              <Badge variant="outline" class="ml-auto">11</Badge>
                            </Button>
                          </div>
                        </CollapsibleContent>
                      </Collapsible>

                      <Collapsible>
                        <CollapsibleTrigger
                          class="flex w-full items-center gap-1 rounded-md px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">
                          <ChevronRight class="h-4 w-4 text-muted-foreground transition-transform" />
                          <Folder class="h-4 w-4 text-muted-foreground" />
                          <span>Templates</span>
                          <Badge variant="outline" class="ml-auto">7</Badge>
                        </CollapsibleTrigger>
                      </Collapsible>

                      <Collapsible>
                        <CollapsibleTrigger
                          class="flex w-full items-center gap-1 rounded-md px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">
                          <ChevronRight class="h-4 w-4 text-muted-foreground transition-transform" />
                          <Folder class="h-4 w-4 text-muted-foreground" />
                          <span>Archive</span>
                          <Badge variant="outline" class="ml-auto">23</Badge>
                        </CollapsibleTrigger>
                      </Collapsible>
                    </div>
                  </ScrollArea>
                </div>
              </CollapsibleContent>
            </Collapsible>

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
          </div>
        </div>
      </main>
    </TooltipProvider>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import {
  Bell,
  ChevronDown,
  ChevronRight,
  Clock,
  Download,
  Eye,
  File,
  FileImage,
  FileSpreadsheet,
  FileText,
  Filter,
  Folder,
  FolderPlus,
  FolderTree,
  FolderUp,
  HardDrive,
  HelpCircle,
  Home,
  LayoutGrid,
  List,
  ListFilter,
  LogOut,
  Menu,
  MoreHorizontal,
  MoreVertical,
  PenLine,
  Plus,
  Search,
  Settings,
  Share,
  Star,
  Trash,
  Upload,
  User
} from 'lucide-vue-next'

// Import shadcn-vue components
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import {
  DropdownMenu,
  DropdownMenuTrigger,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuCheckboxItem,
  DropdownMenuRadioGroup,
  DropdownMenuRadioItem
} from '@/components/ui/dropdown-menu'
import {
  Avatar,
  AvatarImage,
  AvatarFallback
} from '@/components/ui/avatar'
import {
  Card,
  CardContent,
  CardFooter
} from '@/components/ui/card'
import {
  Collapsible,
  CollapsibleTrigger,
  CollapsibleContent
} from '@/components/ui/collapsible'
import { Badge } from '@/components/ui/badge'
import { Separator } from '@/components/ui/separator'
import { ScrollArea } from '@/components/ui/scroll-area'
import {
  Tooltip,
  TooltipContent,
  TooltipTrigger,
  TooltipProvider
} from '@/components/ui/tooltip'
</script>

<style>
:root {
  --background: 0 0% 100%;
  --foreground: 240 10% 3.9%;
  --card: 0 0% 100%;
  --card-foreground: 240 10% 3.9%;
  --popover: 0 0% 100%;
  --popover-foreground: 240 10% 3.9%;
  --primary: 224 89% 60%;
  --primary-foreground: 0 0% 98%;
  --secondary: 240 4.8% 95.9%;
  --secondary-foreground: 240 5.9% 10%;
  --muted: 240 4.8% 95.9%;
  --muted-foreground: 240 3.8% 46.1%;
  --accent: 240 4.8% 95.9%;
  --accent-foreground: 240 5.9% 10%;
  --destructive: 0 84.2% 60.2%;
  --destructive-foreground: 0 0% 98%;
  --border: 240 5.9% 90%;
  --input: 240 5.9% 90%;
  --ring: 224 89% 60%;
  --radius: 0.5rem;
}

.dark {
  --background: 20 14.3% 4.1%;
  --foreground: 0 0% 95%;
  --card: 24 9.8% 10%;
  --card-foreground: 0 0% 95%;
  --popover: 0 0% 9%;
  --popover-foreground: 0 0% 95%;
  --primary: 224 89% 60%;
  --primary-foreground: 0 0% 98%;
  --secondary: 240 3.7% 15.9%;
  --secondary-foreground: 0 0% 98%;
  --muted: 0 0% 15%;
  --muted-foreground: 240 5% 64.9%;
  --accent: 12 6.5% 15.1%;
  --accent-foreground: 0 0% 98%;
  --destructive: 0 62.8% 30.6%;
  --destructive-foreground: 0 85.7% 97.3%;
  --border: 240 3.7% 15.9%;
  --input: 240 3.7% 15.9%;
  --ring: 224 89% 60%;
}

body {
  @apply bg-background text-foreground;
  font-feature-settings: "rlig" 1, "calt" 1;
}

/* Fix for Collapsible rotation */
.collapsible[data-state="open"]>.collapsible-trigger svg:last-child {
  transform: rotate(180deg);
}
</style>