<template>

    <div>
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Approved Orders</h1>
                <p class="text-muted-foreground">Convert sales orders to invoices</p>
            </div>
            <div class="flex items-center gap-2">
                <Button variant="outline" size="sm" class="h-8 gap-1">
                    <RefreshCw class="h-3.5 w-3.5" />
                    <span>Refresh</span>
                </Button>
                <Button variant="outline" size="sm" class="h-8 gap-1">
                    <Download class="h-3.5 w-3.5" />
                    <span>Export</span>
                </Button>
            </div>
        </div>

        <!-- Filters -->
        <Card class="mb-6">
            <CardContent class="p-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <Input v-model="orderFilters.search" placeholder="Search orders..." class="pl-9" />
                        <Search class="absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" />
                    </div>
                    <Select v-model="orderFilters.department">
                        <SelectTrigger class="w-full md:w-[180px]">
                            <SelectValue placeholder="Department" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">All Departments</SelectItem>
                            <SelectItem value="sales">Sales</SelectItem>
                            <SelectItem value="retail">Retail</SelectItem>
                            <SelectItem value="wholesale">Wholesale</SelectItem>
                        </SelectContent>
                    </Select>
                    <Select v-model="orderFilters.dateRange">
                        <SelectTrigger class="w-full md:w-[180px]">
                            <SelectValue placeholder="Date Range" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">All Time</SelectItem>
                            <SelectItem value="today">Today</SelectItem>
                            <SelectItem value="week">This Week</SelectItem>
                            <SelectItem value="month">This Month</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </CardContent>
        </Card>

        <!-- Orders Table -->
        <Card>
            <CardHeader class="flex flex-row items-center justify-between pb-2">
                <div class="space-y-1">
                    <CardTitle>Pending Invoice Generation</CardTitle>
                    <CardDescription>Orders approved by sales department ready for invoicing
                    </CardDescription>
                </div>
                <Badge variant="secondary" class="ml-auto">{{ approvedOrders.length }} Orders</Badge>
            </CardHeader>
            <CardContent class="p-0">
                <div class="overflow-x-auto">

                    <ApprovedOrdersTable :approved-orders="approvedOrders.data" />

                </div>
            </CardContent>
            <CardFooter v-if="approvedOrders.data.length > 0" class="flex items-center justify-between p-4">
                <div class="text-sm text-muted-foreground">
                    Showing <strong>{{ approvedOrders.meta.from }}</strong> to <strong>{{ approvedOrders.meta.to
                    }}</strong> of
                    <strong>{{
                        approvedOrders.meta.total
                        }}</strong> results
                </div>
                <div class="flex items-center space-x-2">
                    <Link :href="approvedOrders.links.prev" preserve-scroll>
                    <Button variant="outline" size="sm" :disabled="isNull(approvedOrders.links.prev)">Previous</Button>
                    </Link>
                    <Link :href="approvedOrders.links.next" preserve-scroll>
                    <Button variant="outline" size="sm" :disabled="isNull(approvedOrders.links.next)">Next</Button>
                    </Link>
                </div>
            </CardFooter>
        </Card>

        <!-- Recently Generated Invoices -->
        <Card class="mt-8">
            <CardHeader class="flex flex-row items-center justify-between pb-2">
                <div class="space-y-1">
                    <CardTitle>Recently Generated Invoices</CardTitle>
                    <CardDescription>Invoices created from sales orders</CardDescription>
                </div>
            </CardHeader>
            <CardContent class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b border-border">
                                <th
                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                    Invoice ID</th>
                                <th
                                    class="text-left py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                    Order ID</th>
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
                                <th
                                    class="text-right py-3 px-4 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(invoice, index) in recentGeneratedInvoices" :key="index"
                                class="border-b border-border hover:bg-muted/10">
                                <td class="py-3 px-4 text-sm font-medium">#{{ invoice.id }}</td>
                                <td class="py-3 px-4 text-sm">#{{ invoice.orderId }}</td>
                                <td class="py-3 px-4 text-sm">{{ invoice.customer }}</td>
                                <td class="py-3 px-4 text-sm">{{ invoice.date }}</td>
                                <td class="py-3 px-4 text-sm">${{ invoice.amount.toFixed(2) }}</td>
                                <td class="py-3 px-4 text-sm">
                                    <Badge :variant="getStatusVariant(invoice.status)">
                                        {{ invoice.status }}
                                    </Badge>
                                </td>
                                <td class="py-3 px-4 text-sm text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button variant="outline" size="sm">
                                            <Eye class="h-3.5 w-3.5 mr-1" />
                                            View
                                        </Button>
                                        <Button variant="outline" size="sm">
                                            <Send class="h-3.5 w-3.5 mr-1" />
                                            Send
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </CardContent>
        </Card>
    </div>

    <!-- View Order Dialog -->

</template>

<script setup>
import { ref, computed } from 'vue'
import {
    ChevronLeft,
    ChevronRight,
    Download,
    Eye,
    FileText,
    RefreshCw,
    Search,
    Send,
} from 'lucide-vue-next'

// Import shadcn-vue components
import Badge from '@/components/ui/badge/Badge.vue'
import Button from '@/components/ui/button/Button.vue'
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
import AppLayout from '@/layouts/AppLayout.vue'
import Input from '@/components/ui/input/Input.vue'
import { isNull } from 'lodash';
import ApprovedOrdersTable from '@/components/FinanceDep/ApprovedOrdersTable.vue'
import { router } from '@inertiajs/vue3'

const propsData = defineProps({
    approvedOrders: Array,
});


// Filter state
const filters = ref({
    search: '',
    status: '',
    dateRange: ''
})

// Order filter state
const orderFilters = ref({
    search: '',
    department: 'all',
    dateRange: 'all'
})

// Navigation items - Added Approved Orders
const navigation = [
    { id: 'dashboard', name: 'Dashboard', icon: 'BarChart' },
    { id: 'approved-orders', name: 'Approved Orders', icon: 'FileText', badge: '12' },
    { id: 'invoices', name: 'Invoices', icon: 'CreditCard', badge: '8' },
    { id: 'payments', name: 'Payments', icon: 'CreditCard' },
    { id: 'reports', name: 'Reports', icon: 'LineChart' },
    { id: 'accounts', name: 'Chart of Accounts', icon: 'Landmark' }
]


// Sample data for recently generated invoices
const recentGeneratedInvoices = [
    { id: 'INV1021', orderId: 'SO1001', customer: 'Acme Inc.', date: '2023-06-02', amount: 2450.00, status: 'Sent' },
    { id: 'INV1022', orderId: 'SO1002', customer: 'Globex Corporation', date: '2023-06-04', amount: 3750.50, status: 'Pending' },
    { id: 'INV1023', orderId: 'SO1003', customer: 'Stark Industries', date: '2023-06-06', amount: 12800.75, status: 'Paid' },
    { id: 'INV1024', orderId: 'SO1004', customer: 'Wayne Enterprises', date: '2023-06-08', amount: 5200.25, status: 'Overdue' },
    { id: 'INV1025', orderId: 'SO1005', customer: 'Umbrella Corp', date: '2023-06-10', amount: 1850.00, status: 'Pending' }
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

// Filtered approved orders based on search and filters
// const filteredApprovedOrders = computed(() => {
//     return approvedOrders.filter(order => {
//         // Search filter
//         if (orderFilters.value.search &&
//             !order.customer.toLowerCase().includes(orderFilters.value.search.toLowerCase()) &&
//             !order.id.includes(orderFilters.value.search)) {
//             return false
//         }

//         // Department filter
//         if (orderFilters.value.department && orderFilters.value.department !== 'all' &&
//             order.department.toLowerCase() !== orderFilters.value.department.toLowerCase()) {
//             return false
//         }

//         // Date range filter would be implemented here

//         return true
//     })
// })

// Helper function to get badge variant based on status
const getStatusVariant = (status) => {
    switch (status) {
        case 'Paid': return 'success'
        case 'Pending': return 'warning'
        case 'Overdue': return 'destructive'
        case 'Sent': return 'info'
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

// Helper function to calculate subtotal
const calculateSubtotal = (items) => {
    return items.reduce((total, item) => total + (item.quantity * item.unitPrice), 0)
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

// Order actions
const viewOrder = (order) => {
    selectedOrder.value = order
    showOrderDetails.value = true
}

const generateInvoice = (order) => {
    console.log('Generate invoice for order', order)
    // Here you would typically:
    // 1. Create a new invoice based on the order
    // 2. Add it to the invoices list
    // 3. Update the order status
    // 4. Show a success message

    // For demo purposes, we'll just close the dialog if it's open
    showOrderDetails.value = false

    // And show a success message (in a real app)
    // toast.success(`Invoice generated for order #${order.id}`)
}

defineOptions({
    layout: AppLayout,
});
</script>