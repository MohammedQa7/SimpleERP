<template>
    <div class="min-h-screen bg-background text-foreground dark">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="hidden lg:flex w-64 flex-col fixed inset-y-0 z-50 border-r border-border bg-card">
                <div class="flex h-14 items-center border-b px-4 border-border">
                    <h2 class="font-semibold text-lg flex items-center gap-2">
                        <LayoutDashboard class="h-5 w-5" />
                        Finance ERP
                    </h2>
                </div>
                <div class="flex-1 overflow-auto py-2">
                    <nav class="grid gap-1 px-2 group">
                        <button v-for="(item, i) in navigation" :key="i" @click="activeTab = item.id" :class="[
                            'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors',
                            activeTab === item.id
                                ? 'bg-accent text-accent-foreground'
                                : 'hover:bg-accent hover:text-accent-foreground'
                        ]">
                            <component :is="item.icon" class="h-4 w-4" />
                            {{ item.name }}
                            <Badge v-if="item.badge" variant="secondary" class="ml-auto">{{ item.badge }}</Badge>
                        </button>
                    </nav>
                </div>
                <div class="border-t border-border p-4">
                    <div class="flex items-center gap-3">
                        <Avatar>
                            <AvatarImage src="https://github.com/shadcn.png" />
                            <AvatarFallback>JD</AvatarFallback>
                        </Avatar>
                        <div class="flex flex-col">
                            <span class="text-sm font-medium">John Doe</span>
                            <span class="text-xs text-muted-foreground">Finance Manager</span>
                        </div>
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="ghost" size="icon" class="ml-auto h-8 w-8">
                                    <MoreVertical class="h-4 w-4" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuItem>Profile</DropdownMenuItem>
                                <DropdownMenuItem>Settings</DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem>Logout</DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </div>
            </aside>

            <!-- Main content -->
            <main class="flex-1 lg:pl-64 pt-14 lg:pt-0">
                <div class="container p-4 md:p-6 lg:p-8 mx-auto">
                    <!-- Dashboard -->
                    <div v-if="activeTab === 'dashboard'">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-3xl font-bold tracking-tight">Dashboard</h1>
                                <p class="text-muted-foreground">Financial overview and key metrics</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- <DateRangePicker /> -->
                                date rage picker
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                        <Button variant="outline" size="sm" class="h-8 gap-1">
                                            <Download class="h-3.5 w-3.5" />
                                            <span>Export</span>
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem>
                                            <FileText class="mr-2 h-4 w-4" />
                                            <span>PDF</span>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem>
                                            <FileSpreadsheet class="mr-2 h-4 w-4" />
                                            <span>Excel</span>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem>
                                            <FileJson class="mr-2 h-4 w-4" />
                                            <span>CSV</span>
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </div>
                        </div>

                        <!-- Stats Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                            <Card v-for="(stat, index) in stats" :key="index">
                                <CardContent class="p-6">
                                    <div class="flex items-center justify-between space-x-4">
                                        <div class="flex flex-col space-y-1">
                                            <span class="text-sm font-medium text-muted-foreground">{{ stat.name
                                            }}</span>
                                            <span class="text-2xl font-bold">{{ stat.value }}</span>
                                        </div>
                                        <div :class="`p-2 rounded-full bg-${stat.color}/10`">
                                            <component :is="stat.icon" :class="`h-5 w-5 text-${stat.color}`" />
                                        </div>
                                    </div>
                                    <div class="flex items-center pt-4 text-sm">
                                        <div :class="stat.change > 0 ? 'text-emerald-500' : 'text-rose-500'"
                                            class="flex items-center">
                                            <component :is="stat.change > 0 ? 'TrendingUp' : 'TrendingDown'"
                                                class="mr-1 h-3 w-3" />
                                            {{ Math.abs(stat.change) }}%
                                        </div>
                                        <span class="text-muted-foreground ml-2">from last month</span>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>

                        <!-- Charts -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
                            <Card>
                                <CardHeader class="flex flex-row items-center justify-between pb-2">
                                    <div class="space-y-1">
                                        <CardTitle>Revenue vs Expenses</CardTitle>
                                        <CardDescription>Monthly comparison for the current year</CardDescription>
                                    </div>
                                </CardHeader>
                                <CardContent>
                                    <div
                                        class="h-[240px] w-full bg-muted/20 rounded-md flex items-center justify-center">
                                        <BarChart class="h-8 w-8 text-muted-foreground" />
                                        <span class="ml-2 text-muted-foreground">Revenue Chart</span>
                                    </div>
                                </CardContent>
                            </Card>
                            <Card>
                                <CardHeader class="flex flex-row items-center justify-between pb-2">
                                    <div class="space-y-1">
                                        <CardTitle>Cash Flow</CardTitle>
                                        <CardDescription>Daily cash flow for the current month</CardDescription>
                                    </div>
                                </CardHeader>
                                <CardContent>
                                    <div
                                        class="h-[240px] w-full bg-muted/20 rounded-md flex items-center justify-center">
                                        <LineChart class="h-8 w-8 text-muted-foreground" />
                                        <span class="ml-2 text-muted-foreground">Cash Flow Chart</span>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>

                        <!-- Recent Invoices -->
                        <Card>
                            <CardHeader class="flex flex-row items-center justify-between pb-2">
                                <div class="space-y-1">
                                    <CardTitle>Recent Invoices</CardTitle>
                                    <CardDescription>Latest invoices from your customers</CardDescription>
                                </div>
                                <Button variant="outline" size="sm" @click="activeTab = 'invoices'">
                                    View all
                                    <ChevronRight class="ml-1 h-4 w-4" />
                                </Button>
                            </CardHeader>
                            <CardContent>
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse">
                                        <thead>
                                            <tr class="border-b border-border">
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Invoice</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Customer</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Date</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Amount</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(invoice, index) in recentInvoices" :key="index"
                                                class="border-b border-border hover:bg-muted/10">
                                                <td class="py-3 px-4 text-sm font-medium">#{{ invoice.id }}</td>
                                                <td class="py-3 px-4 text-sm">{{ invoice.customer }}</td>
                                                <td class="py-3 px-4 text-sm">{{ invoice.date }}</td>
                                                <td class="py-3 px-4 text-sm">${{ invoice.amount.toFixed(2) }}</td>
                                                <td class="py-3 px-4 text-sm">
                                                    <Badge :variant="getStatusVariant(invoice.status)">
                                                        {{ invoice.status }}
                                                    </Badge>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <!-- Invoices -->
                    <div v-if="activeTab === 'invoices'">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-3xl font-bold tracking-tight">Invoices</h1>
                                <p class="text-muted-foreground">Manage and create customer invoices</p>
                            </div>
                            <Button @click="showInvoiceForm = true">
                                <Plus class="mr-2 h-4 w-4" />
                                Create Invoice
                            </Button>
                        </div>

                        <!-- Filters -->
                        <Card class="mb-6">
                            <CardContent class="p-4">
                                <div class="flex flex-col md:flex-row gap-4">
                                    <div class="flex-1 relative">
                                        <Input v-model="filters.search" placeholder="Search invoices..." class="pl-9" />
                                        <Search class="absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" />
                                    </div>
                                    <Select v-model="filters.status">
                                        <SelectTrigger class="w-full md:w-[180px]">
                                            <SelectValue placeholder="Status" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">All Statuses</SelectItem>
                                            <SelectItem value="Paid">Paid</SelectItem>
                                            <SelectItem value="Pending">Pending</SelectItem>
                                            <SelectItem value="Overdue">Overdue</SelectItem>
                                        </SelectContent>
                                    </Select>
                                    <Select v-model="filters.dateRange">
                                        <SelectTrigger class="w-full md:w-[180px]">
                                            <SelectValue placeholder="Date Range" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">All Time</SelectItem>
                                            <SelectItem value="today">Today</SelectItem>
                                            <SelectItem value="week">This Week</SelectItem>
                                            <SelectItem value="month">This Month</SelectItem>
                                            <SelectItem value="quarter">This Quarter</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                            </CardContent>
                        </Card>

                        <!-- Invoices Table -->
                        <Card>
                            <CardContent class="p-0">
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse">
                                        <thead>
                                            <tr class="border-b border-border">
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Invoice</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Customer</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Date</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Due Date</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Amount</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Status</th>
                                                <th
                                                    class="text-right py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(invoice, index) in filteredInvoices" :key="index"
                                                class="border-b border-border hover:bg-muted/10">
                                                <td class="py-3 px-4 text-sm font-medium">#{{ invoice.id }}</td>
                                                <td class="py-3 px-4 text-sm">{{ invoice.customer }}</td>
                                                <td class="py-3 px-4 text-sm">{{ invoice.date }}</td>
                                                <td class="py-3 px-4 text-sm">{{ invoice.dueDate }}</td>
                                                <td class="py-3 px-4 text-sm">${{ invoice.amount.toFixed(2) }}</td>
                                                <td class="py-3 px-4 text-sm">
                                                    <Badge :variant="getStatusVariant(invoice.status)">
                                                        {{ invoice.status }}
                                                    </Badge>
                                                </td>
                                                <td class="py-3 px-4 text-sm text-right">
                                                    <DropdownMenu>
                                                        <DropdownMenuTrigger as-child>
                                                            <Button variant="ghost" size="icon" class="h-8 w-8">
                                                                <MoreHorizontal class="h-4 w-4" />
                                                                <span class="sr-only">Open menu</span>
                                                            </Button>
                                                        </DropdownMenuTrigger>
                                                        <DropdownMenuContent align="end">
                                                            <DropdownMenuItem @click="viewInvoice(invoice)">
                                                                <Eye class="mr-2 h-4 w-4" />
                                                                <span>View</span>
                                                            </DropdownMenuItem>
                                                            <DropdownMenuItem @click="sendInvoice(invoice)">
                                                                <Send class="mr-2 h-4 w-4" />
                                                                <span>Send</span>
                                                            </DropdownMenuItem>
                                                            <DropdownMenuItem @click="editInvoice(invoice)">
                                                                <Pencil class="mr-2 h-4 w-4" />
                                                                <span>Edit</span>
                                                            </DropdownMenuItem>
                                                            <DropdownMenuSeparator />
                                                            <DropdownMenuItem
                                                                class="text-destructive focus:text-destructive">
                                                                <Trash class="mr-2 h-4 w-4" />
                                                                <span>Delete</span>
                                                            </DropdownMenuItem>
                                                        </DropdownMenuContent>
                                                    </DropdownMenu>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </CardContent>
                            <CardFooter className="flex items-center justify-between p-4">
                                <div class="text-sm text-muted-foreground">
                                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of
                                    <span class="font-medium">{{ invoices.length }}</span> results
                                </div>
                                <div class="flex items-center space-x-2">
                                    <Button variant="outline" size="icon" class="h-8 w-8">
                                        <ChevronLeft class="h-4 w-4" />
                                        <span class="sr-only">Previous page</span>
                                    </Button>
                                    <Button variant="outline" size="sm" class="h-8 w-8">1</Button>
                                    <Button variant="outline" size="sm" class="h-8 w-8">2</Button>
                                    <Button variant="outline" size="sm" class="h-8 w-8">3</Button>
                                    <Button variant="outline" size="icon" class="h-8 w-8">
                                        <ChevronRight class="h-4 w-4" />
                                        <span class="sr-only">Next page</span>
                                    </Button>
                                </div>
                            </CardFooter>
                        </Card>
                    </div>

                    <!-- Reports -->
                    <div v-if="activeTab === 'reports'">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-3xl font-bold tracking-tight">Reports</h1>
                                <p class="text-muted-foreground">Generate and manage financial reports</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Generate Report</CardTitle>
                                    <CardDescription>Create a new financial report</CardDescription>
                                </CardHeader>
                                <CardContent class="space-y-4">
                                    <div class="space-y-2">
                                        <Label for="report-type">Report Type</Label>
                                        <Select>
                                            <SelectTrigger id="report-type">
                                                <SelectValue placeholder="Select report type" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="income">Income Statement</SelectItem>
                                                <SelectItem value="balance">Balance Sheet</SelectItem>
                                                <SelectItem value="cashflow">Cash Flow Statement</SelectItem>
                                                <SelectItem value="aging">Accounts Receivable Aging</SelectItem>
                                                <SelectItem value="tax">Sales Tax Report</SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="date-range">Date Range</Label>
                                        <Select>
                                            <SelectTrigger id="date-range">
                                                <SelectValue placeholder="Select date range" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="this-month">This Month</SelectItem>
                                                <SelectItem value="last-month">Last Month</SelectItem>
                                                <SelectItem value="this-quarter">This Quarter</SelectItem>
                                                <SelectItem value="last-quarter">Last Quarter</SelectItem>
                                                <SelectItem value="this-year">This Year</SelectItem>
                                                <SelectItem value="last-year">Last Year</SelectItem>
                                                <SelectItem value="custom">Custom Range</SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <Label for="start-date">Start Date</Label>
                                            <Input id="start-date" type="date" />
                                        </div>
                                        <div class="space-y-2">
                                            <Label for="end-date">End Date</Label>
                                            <Input id="end-date" type="date" />
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="format">Format</Label>
                                        <Select>
                                            <SelectTrigger id="format">
                                                <SelectValue placeholder="Select format" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="pdf">PDF</SelectItem>
                                                <SelectItem value="excel">Excel</SelectItem>
                                                <SelectItem value="csv">CSV</SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                </CardContent>
                                <CardFooter>
                                    <Button class="w-full">
                                        <Download class="mr-2 h-4 w-4" />
                                        Generate Report
                                    </Button>
                                </CardFooter>
                            </Card>

                            <Card>
                                <CardHeader>
                                    <CardTitle>Recent Reports</CardTitle>
                                    <CardDescription>Your recently generated reports</CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <div class="space-y-4">
                                        <div v-for="(report, index) in recentReports" :key="index"
                                            class="flex items-center justify-between border-b border-border pb-4 last:border-0 last:pb-0">
                                            <div class="space-y-1">
                                                <p class="text-sm font-medium">{{ report.name }}</p>
                                                <p class="text-xs text-muted-foreground">{{ report.date }}</p>
                                            </div>
                                            <Button variant="outline" size="sm">
                                                <Download class="mr-2 h-3.5 w-3.5" />
                                                Download
                                            </Button>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>

                        <Card>
                            <CardHeader>
                                <CardTitle>Scheduled Reports</CardTitle>
                                <CardDescription>Reports that are automatically generated and sent</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse">
                                        <thead>
                                            <tr class="border-b border-border">
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Report Name</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Frequency</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Recipients</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Last Sent</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Next Scheduled</th>
                                                <th
                                                    class="text-right py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(report, index) in scheduledReports" :key="index"
                                                class="border-b border-border hover:bg-muted/10">
                                                <td class="py-3 px-4 text-sm font-medium">{{ report.name }}</td>
                                                <td class="py-3 px-4 text-sm">{{ report.frequency }}</td>
                                                <td class="py-3 px-4 text-sm">{{ report.recipients }}</td>
                                                <td class="py-3 px-4 text-sm">{{ report.lastSent }}</td>
                                                <td class="py-3 px-4 text-sm">{{ report.nextScheduled }}</td>
                                                <td class="py-3 px-4 text-sm text-right">
                                                    <DropdownMenu>
                                                        <DropdownMenuTrigger as-child>
                                                            <Button variant="ghost" size="icon" class="h-8 w-8">
                                                                <MoreHorizontal class="h-4 w-4" />
                                                                <span class="sr-only">Open menu</span>
                                                            </Button>
                                                        </DropdownMenuTrigger>
                                                        <DropdownMenuContent align="end">
                                                            <DropdownMenuItem>
                                                                <Pencil class="mr-2 h-4 w-4" />
                                                                <span>Edit</span>
                                                            </DropdownMenuItem>
                                                            <DropdownMenuSeparator />
                                                            <DropdownMenuItem
                                                                class="text-destructive focus:text-destructive">
                                                                <Trash class="mr-2 h-4 w-4" />
                                                                <span>Delete</span>
                                                            </DropdownMenuItem>
                                                        </DropdownMenuContent>
                                                    </DropdownMenu>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <!-- Accounts -->
                    <div v-if="activeTab === 'accounts'">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-3xl font-bold tracking-tight">Chart of Accounts</h1>
                                <p class="text-muted-foreground">Manage your financial accounts</p>
                            </div>
                            <Button>
                                <Plus class="mr-2 h-4 w-4" />
                                Add Account
                            </Button>
                        </div>

                        <Card class="mb-8">
                            <CardContent class="p-0">
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse">
                                        <thead>
                                            <tr class="border-b border-border">
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Account Code</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Account Name</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Type</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Balance</th>
                                                <th
                                                    class="text-right py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(account, index) in accounts" :key="index"
                                                class="border-b border-border hover:bg-muted/10">
                                                <td class="py-3 px-4 text-sm font-medium">{{ account.code }}</td>
                                                <td class="py-3 px-4 text-sm">{{ account.name }}</td>
                                                <td class="py-3 px-4 text-sm">{{ account.type }}</td>
                                                <td class="py-3 px-4 text-sm">${{ account.balance.toFixed(2) }}</td>
                                                <td class="py-3 px-4 text-sm text-right">
                                                    <DropdownMenu>
                                                        <DropdownMenuTrigger as-child>
                                                            <Button variant="ghost" size="icon" class="h-8 w-8">
                                                                <MoreHorizontal class="h-4 w-4" />
                                                                <span class="sr-only">Open menu</span>
                                                            </Button>
                                                        </DropdownMenuTrigger>
                                                        <DropdownMenuContent align="end">
                                                            <DropdownMenuItem>
                                                                <Eye class="mr-2 h-4 w-4" />
                                                                <span>View</span>
                                                            </DropdownMenuItem>
                                                            <DropdownMenuItem>
                                                                <Pencil class="mr-2 h-4 w-4" />
                                                                <span>Edit</span>
                                                            </DropdownMenuItem>
                                                        </DropdownMenuContent>
                                                    </DropdownMenu>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Account Categories</CardTitle>
                                <CardDescription>Organize your accounts by category</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <Card v-for="(category, index) in accountCategories" :key="index"
                                        class="border border-border">
                                        <CardHeader class="pb-2">
                                            <CardTitle>{{ category.name }}</CardTitle>
                                        </CardHeader>
                                        <CardContent class="pb-2">
                                            <p class="text-sm text-muted-foreground">{{ category.description }}</p>
                                        </CardContent>
                                        <CardFooter class="flex justify-between">
                                            <span class="text-sm text-muted-foreground">{{ category.accountCount }}
                                                accounts</span>
                                            <Button variant="ghost" size="sm">View Accounts</Button>
                                        </CardFooter>
                                    </Card>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <!-- Payments -->
                    <div v-if="activeTab === 'payments'">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-3xl font-bold tracking-tight">Payments</h1>
                                <p class="text-muted-foreground">Manage customer payments</p>
                            </div>
                            <Button>
                                <Plus class="mr-2 h-4 w-4" />
                                Record Payment
                            </Button>
                        </div>

                        <!-- Payment Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                            <Card>
                                <CardContent class="p-6">
                                    <div class="flex items-center justify-between space-x-4">
                                        <div class="flex flex-col space-y-1">
                                            <span class="text-sm font-medium text-muted-foreground">Payments
                                                Received</span>
                                            <span class="text-2xl font-bold">$24,567.00</span>
                                        </div>
                                        <div class="p-2 rounded-full bg-emerald-500/10">
                                            <CheckCircle class="h-5 w-5 text-emerald-500" />
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                            <Card>
                                <CardContent class="p-6">
                                    <div class="flex items-center justify-between space-x-4">
                                        <div class="flex flex-col space-y-1">
                                            <span class="text-sm font-medium text-muted-foreground">Pending
                                                Payments</span>
                                            <span class="text-2xl font-bold">$12,345.00</span>
                                        </div>
                                        <div class="p-2 rounded-full bg-amber-500/10">
                                            <Clock class="h-5 w-5 text-amber-500" />
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                            <Card>
                                <CardContent class="p-6">
                                    <div class="flex items-center justify-between space-x-4">
                                        <div class="flex flex-col space-y-1">
                                            <span class="text-sm font-medium text-muted-foreground">Overdue
                                                Payments</span>
                                            <span class="text-2xl font-bold">$5,432.00</span>
                                        </div>
                                        <div class="p-2 rounded-full bg-rose-500/10">
                                            <AlertCircle class="h-5 w-5 text-rose-500" />
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>

                        <!-- Recent Payments -->
                        <Card class="mb-8">
                            <CardHeader>
                                <CardTitle>Recent Payments</CardTitle>
                                <CardDescription>Latest payments from your customers</CardDescription>
                            </CardHeader>
                            <CardContent class="p-0">
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse">
                                        <thead>
                                            <tr class="border-b border-border">
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Payment ID</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Customer</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Invoice</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Date</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Amount</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Method</th>
                                                <th
                                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                    Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(payment, index) in recentPayments" :key="index"
                                                class="border-b border-border hover:bg-muted/10">
                                                <td class="py-3 px-4 text-sm font-medium">#{{ payment.id }}</td>
                                                <td class="py-3 px-4 text-sm">{{ payment.customer }}</td>
                                                <td class="py-3 px-4 text-sm">#{{ payment.invoice }}</td>
                                                <td class="py-3 px-4 text-sm">{{ payment.date }}</td>
                                                <td class="py-3 px-4 text-sm">${{ payment.amount.toFixed(2) }}</td>
                                                <td class="py-3 px-4 text-sm">{{ payment.method }}</td>
                                                <td class="py-3 px-4 text-sm">
                                                    <Badge :variant="getPaymentStatusVariant(payment.status)">
                                                        {{ payment.status }}
                                                    </Badge>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </CardContent>
                        </Card>

                        <!-- Payment Methods -->
                        <Card>
                            <CardHeader>
                                <CardTitle>Payment Methods</CardTitle>
                                <CardDescription>Configure payment methods for your customers</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <Card v-for="(method, index) in paymentMethods" :key="index"
                                        class="border border-border">
                                        <CardHeader class="pb-2">
                                            <div class="flex items-center space-x-3">
                                                <component :is="method.icon" class="h-5 w-5 text-muted-foreground" />
                                                <CardTitle>{{ method.name }}</CardTitle>
                                            </div>
                                        </CardHeader>
                                        <CardContent class="pb-2">
                                            <p class="text-sm text-muted-foreground">{{ method.description }}</p>
                                        </CardContent>
                                        <CardFooter class="flex justify-end">
                                            <Button variant="ghost" size="sm">Configure</Button>
                                        </CardFooter>
                                    </Card>
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </main>
        </div>

        <!-- Create Invoice Dialog -->
        <Dialog :open="showInvoiceForm" @update:open="showInvoiceForm = $event">
            <DialogContent class="sm:max-w-4xl">
                <DialogHeader>
                    <DialogTitle>Create New Invoice</DialogTitle>
                    <DialogDescription>Create a new invoice for your customer</DialogDescription>
                </DialogHeader>
                <div class="grid grid-cols-1 gap-4 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <Label for="customer">Customer</Label>
                            <Select>
                                <SelectTrigger id="customer">
                                    <SelectValue placeholder="Select customer" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="acme">Acme Inc.</SelectItem>
                                    <SelectItem value="globex">Globex Corporation</SelectItem>
                                    <SelectItem value="stark">Stark Industries</SelectItem>
                                    <SelectItem value="wayne">Wayne Enterprises</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                        <div class="space-y-2">
                            <Label for="invoice-number">Invoice Number</Label>
                            <Input id="invoice-number" value="INV-0001" />
                        </div>
                        <div class="space-y-2">
                            <Label for="issue-date">Issue Date</Label>
                            <Input id="issue-date" type="date" />
                        </div>
                        <div class="space-y-2">
                            <Label for="due-date">Due Date</Label>
                            <Input id="due-date" type="date" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium">Line Items</h3>
                            <Button variant="outline" size="sm">
                                <Plus class="mr-2 h-4 w-4" />
                                Add Item
                            </Button>
                        </div>
                        <div class="border rounded-md">
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr class="border-b border-border">
                                            <th
                                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                Item</th>
                                            <th
                                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                Description</th>
                                            <th
                                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                Quantity</th>
                                            <th
                                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                Price</th>
                                            <th
                                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                Total</th>
                                            <th
                                                class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b border-border">
                                            <td class="py-3 px-4 text-sm">
                                                <Input placeholder="Item name" />
                                            </td>
                                            <td class="py-3 px-4 text-sm">
                                                <Input placeholder="Description" />
                                            </td>
                                            <td class="py-3 px-4 text-sm">
                                                <Input type="number" placeholder="1" min="1" />
                                            </td>
                                            <td class="py-3 px-4 text-sm">
                                                <Input type="number" placeholder="0.00" step="0.01" min="0" />
                                            </td>
                                            <td class="py-3 px-4 text-sm">$0.00</td>
                                            <td class="py-3 px-4 text-sm">
                                                <Button variant="ghost" size="icon" class="h-8 w-8">
                                                    <Trash class="h-4 w-4 text-destructive" />
                                                </Button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <div class="w-64 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Subtotal:</span>
                                <span>$0.00</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Tax (10%):</span>
                                <span>$0.00</span>
                            </div>
                            <Separator />
                            <div class="flex justify-between font-medium">
                                <span>Total:</span>
                                <span>$0.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Label for="notes">Notes</Label>
                        <Textarea id="notes" placeholder="Additional notes or terms..." />
                    </div>
                </div>
                <DialogFooter>
                    <Button variant="outline" @click="showInvoiceForm = false">Cancel</Button>
                    <Button>Create Invoice</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import {
    AlertCircle,
    ArrowDown,
    ArrowUp,
    BarChart,
    Bell,
    CheckCircle,
    ChevronLeft,
    ChevronRight,
    Clock,
    CreditCard,
    Download,
    Eye,
    FileJson,
    FileSpreadsheet,
    FileText,
    Landmark,
    LayoutDashboard,
    LineChart,
    Menu,
    MoreHorizontal,
    MoreVertical,
    Package,
    Pencil,
    Plus,
    Search,
    Send,
    Trash,
    TrendingDown,
    TrendingUp
} from 'lucide-vue-next'
import Badge from '@/components/ui/badge/Badge.vue'
import Avatar from '@/components/ui/avatar/Avatar.vue'
import AvatarImage from '@/components/ui/avatar/AvatarImage.vue'
import AvatarFallback from '@/components/ui/avatar/AvatarFallback.vue'
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue'
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue'
import Button from '@/components/ui/button/Button.vue'
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue'
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue'
import DropdownMenuSeparator from '@/components/ui/dropdown-menu/DropdownMenuSeparator.vue'
import SheetTrigger from '@/components/ui/sheet/SheetTrigger.vue'
import SheetContent from '@/components/ui/sheet/SheetContent.vue'
import Card from '@/components/ui/card/Card.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import CardHeader from '@/components/ui/card/CardHeader.vue'
import CardTitle from '@/components/ui/card/CardTitle.vue'
import CardDescription from '@/components/ui/card/CardDescription.vue'
import Select from '@/components/ui/select/Select.vue'
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue'
import SelectValue from '@/components/ui/select/SelectValue.vue'
import SelectContent from '@/components/ui/select/SelectContent.vue'
import SelectItem from '@/components/ui/select/SelectItem.vue'
import CardFooter from '@/components/ui/card/CardFooter.vue'
import Label from '@/components/ui/label/Label.vue'
import Dialog from '@/components/ui/dialog/Dialog.vue'
import DialogContent from '@/components/ui/dialog/DialogContent.vue'
import DialogHeader from '@/components/ui/dialog/DialogHeader.vue'
import DialogTitle from '@/components/ui/dialog/DialogTitle.vue'
import DialogDescription from '@/components/ui/dialog/DialogDescription.vue'

// Import shadcn-vue components

// Active tab state
const activeTab = ref('dashboard')
const showInvoiceForm = ref(false)

// Filter state
const filters = ref({
    search: '',
    status: '',
    dateRange: ''
})

// Dashboard stats
const stats = [
    { name: 'Total Revenue', value: '$45,231.89', change: 12, icon: 'BarChart', color: 'emerald' },
    { name: 'Outstanding', value: '$21,402.00', change: -2, icon: 'Clock', color: 'amber' },
    { name: 'Paid Invoices', value: '36', change: 8, icon: 'CheckCircle', color: 'emerald' },
    { name: 'Pending Invoices', value: '12', change: 4, icon: 'AlertCircle', color: 'rose' }
]

// Navigation items
const navigation = [
    { id: 'dashboard', name: 'Dashboard', icon: 'BarChart' },
    { id: 'invoices', name: 'Invoices', icon: 'CreditCard', badge: '8' },
    { id: 'payments', name: 'Payments', icon: 'CreditCard' },
    { id: 'reports', name: 'Reports', icon: 'LineChart' },
    { id: 'accounts', name: 'Chart of Accounts', icon: 'Landmark' }
]

// Sample data for invoices
const invoices = [
    { id: '1001', customer: 'Acme Inc.', date: '2023-06-01', dueDate: '2023-06-15', amount: 1200.00, status: 'Paid' },
    { id: '1002', customer: 'Globex Corporation', date: '2023-06-05', dueDate: '2023-06-19', amount: 850.50, status: 'Pending' },
    { id: '1003', customer: 'Stark Industries', date: '2023-06-10', dueDate: '2023-06-24', amount: 3200.75, status: 'Paid' },
    { id: '1004', customer: 'Wayne Enterprises', date: '2023-06-12', dueDate: '2023-06-26', amount: 1750.25, status: 'Overdue' },
    { id: '1005', customer: 'Umbrella Corp', date: '2023-06-15', dueDate: '2023-06-29', amount: 920.00, status: 'Pending' },
    { id: '1006', customer: 'Cyberdyne Systems', date: '2023-06-18', dueDate: '2023-07-02', amount: 1500.00, status: 'Paid' },
    { id: '1007', customer: 'Oscorp Industries', date: '2023-06-20', dueDate: '2023-07-04', amount: 2100.50, status: 'Pending' },
    { id: '1008', customer: 'LexCorp', date: '2023-06-22', dueDate: '2023-07-06', amount: 3500.00, status: 'Overdue' }
]

// Recent invoices for dashboard
const recentInvoices = invoices.slice(0, 5)

// Filtered invoices based on search and filters
const filteredInvoices = computed(() => {
    return invoices.filter(invoice => {
        // Search filter
        if (filters.value.search && !invoice.customer.toLowerCase().includes(filters.value.search.toLowerCase()) &&
            !invoice.id.includes(filters.value.search)) {
            return false
        }

        // Status filter
        if (filters.value.status && filters.value.status !== 'all' && invoice.status !== filters.value.status) {
            return false
        }

        // Date range filter would be implemented here

        return true
    })
})

// Helper function to get badge variant based on status
const getStatusVariant = (status) => {
    switch (status) {
        case 'Paid': return 'success'
        case 'Pending': return 'warning'
        case 'Overdue': return 'destructive'
        default: return 'secondary'
    }
}

// Helper function to get payment badge variant based on status
const getPaymentStatusVariant = (status) => {
    switch (status) {
        case 'Completed': return 'success'
        case 'Processing': return 'warning'
        case 'Failed': return 'destructive'
        default: return 'secondary'
    }
}

// Sample data for reports
const recentReports = [
    { name: 'Income Statement - May 2023', date: 'Generated on Jun 02, 2023' },
    { name: 'Balance Sheet - Q2 2023', date: 'Generated on Jun 10, 2023' },
    { name: 'Cash Flow Statement - May 2023', date: 'Generated on Jun 05, 2023' },
    { name: 'Accounts Receivable Aging', date: 'Generated on Jun 15, 2023' }
]

// Sample data for scheduled reports
const scheduledReports = [
    { name: 'Monthly Income Statement', frequency: 'Monthly', recipients: 'finance@company.com', lastSent: 'Jun 01, 2023', nextScheduled: 'Jul 01, 2023' },
    { name: 'Quarterly Balance Sheet', frequency: 'Quarterly', recipients: 'ceo@company.com, cfo@company.com', lastSent: 'Apr 01, 2023', nextScheduled: 'Jul 01, 2023' },
    { name: 'Weekly Sales Report', frequency: 'Weekly', recipients: 'sales@company.com', lastSent: 'Jun 18, 2023', nextScheduled: 'Jun 25, 2023' }
]

// Sample data for accounts
const accounts = [
    { code: '1000', name: 'Cash', type: 'Asset', balance: 45000.00 },
    { code: '1100', name: 'Accounts Receivable', type: 'Asset', balance: 32500.00 },
    { code: '1200', name: 'Inventory', type: 'Asset', balance: 28750.00 },
    { code: '2000', name: 'Accounts Payable', type: 'Liability', balance: 18200.00 },
    { code: '3000', name: 'Common Stock', type: 'Equity', balance: 50000.00 },
    { code: '4000', name: 'Sales Revenue', type: 'Revenue', balance: 125000.00 },
    { code: '5000', name: 'Cost of Goods Sold', type: 'Expense', balance: 75000.00 }
]

// Sample data for account categories
const accountCategories = [
    { name: 'Assets', description: 'Resources owned by the business', accountCount: 12 },
    { name: 'Liabilities', description: 'Obligations owed by the business', accountCount: 8 },
    { name: 'Equity', description: 'Owner\'s interest in the business', accountCount: 4 },
    { name: 'Revenue', description: 'Income from business activities', accountCount: 6 },
    { name: 'Expenses', description: 'Costs incurred in operations', accountCount: 15 }
]

// Sample data for payments
const recentPayments = [
    { id: 'PMT001', customer: 'Acme Inc.', invoice: '1001', date: '2023-06-01', amount: 1200.00, method: 'Credit Card', status: 'Completed' },
    { id: 'PMT002', customer: 'Stark Industries', invoice: '1003', date: '2023-06-10', amount: 3200.75, method: 'Bank Transfer', status: 'Completed' },
    { id: 'PMT003', customer: 'Globex Corporation', invoice: '1002', date: '2023-06-12', amount: 850.50, method: 'PayPal', status: 'Processing' },
    { id: 'PMT004', customer: 'Cyberdyne Systems', invoice: '1006', date: '2023-06-18', amount: 1500.00, method: 'Credit Card', status: 'Completed' },
    { id: 'PMT005', customer: 'Oscorp Industries', invoice: '1007', date: '2023-06-21', amount: 2100.50, method: 'Check', status: 'Processing' }
]

// Sample data for payment methods
const paymentMethods = [
    { name: 'Credit Card', description: 'Accept Visa, Mastercard, Amex, and Discover cards', icon: 'CreditCard' },
    { name: 'Bank Transfer', description: 'Direct bank-to-bank transfers via ACH or wire', icon: 'Landmark' },
    { name: 'PayPal', description: 'Accept payments through PayPal platform', icon: 'CreditCard' }
]

// Invoice actions
const viewInvoice = (invoice) => {
    console.log('View invoice', invoice)
}

const sendInvoice = (invoice) => {
    console.log('Send invoice', invoice)
}

const editInvoice = (invoice) => {
    console.log('Edit invoice', invoice)
}
</script>

<style>
:root {
    --background: 240 10% 3.9%;
    --foreground: 0 0% 98%;
    --card: 240 10% 3.9%;
    --card-foreground: 0 0% 98%;
    --popover: 240 10% 3.9%;
    --popover-foreground: 0 0% 98%;
    --primary: 217.2 91.2% 59.8%;
    --primary-foreground: 222.2 47.4% 11.2%;
    --secondary: 217.2 32.6% 17.5%;
    --secondary-foreground: 210 40% 98%;
    --muted: 217.2 32.6% 17.5%;
    --muted-foreground: 215 20.2% 65.1%;
    --accent: 217.2 32.6% 17.5%;
    --accent-foreground: 210 40% 98%;
    --destructive: 0 62.8% 30.6%;
    --destructive-foreground: 210 40% 98%;
    --border: 217.2 32.6% 17.5%;
    --input: 217.2 32.6% 17.5%;
    --ring: 224.3 76.3% 48%;
}

.dark {
    --background: 240 10% 3.9%;
    --foreground: 0 0% 98%;
    --card: 240 10% 3.9%;
    --card-foreground: 0 0% 98%;
    --popover: 240 10% 3.9%;
    --popover-foreground: 0 0% 98%;
    --primary: 217.2 91.2% 59.8%;
    --primary-foreground: 222.2 47.4% 11.2%;
    --secondary: 217.2 32.6% 17.5%;
    --secondary-foreground: 210 40% 98%;
    --muted: 217.2 32.6% 17.5%;
    --muted-foreground: 215 20.2% 65.1%;
    --accent: 217.2 32.6% 17.5%;
    --accent-foreground: 210 40% 98%;
    --destructive: 0 62.8% 30.6%;
    --destructive-foreground: 210 40% 98%;
    --border: 217.2 32.6% 17.5%;
    --input: 217.2 32.6% 17.5%;
    --ring: 224.3 76.3% 48%;
}

.bg-background {
    background-color: hsl(var(--background));
}

.text-foreground {
    color: hsl(var(--foreground));
}

.bg-card {
    background-color: hsl(var(--card));
}

.border-border {
    border-color: hsl(var(--border));
}

.bg-accent {
    background-color: hsl(var(--accent));
}

.text-accent-foreground {
    color: hsl(var(--accent-foreground));
}

.text-muted-foreground {
    color: hsl(var(--muted-foreground));
}

.bg-muted\/20 {
    background-color: hsla(var(--muted), 0.2);
}
</style>