<template>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Employee Management</h2>
        <CreateEmployeeDialog :departments="departments" :job-titles="jobTitles" />
    </div>

    <Card class="mb-6">
        <CardContent class="p-6">
            <div class="flex flex-col md:flex-row gap-4 mb-4">
                <div class="flex-1">
                    <Input placeholder="Search employees..." />
                </div>
                <div class="flex gap-2">
                    <Select>
                        <SelectTrigger>
                            <SelectValue placeholder="Select a department" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <!-- @select="filter.date = null" -->
                                <SelectItem>
                                    All Departments
                                </SelectItem>
                                <SelectItem value="all">

                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
            </div>
            <!-- Employees Table -->
            <EmployeeTable :employees="employees" :departments="departments" :job-titles="jobTitles" />

        </CardContent>
    </Card>
</template>

<script setup>
import { ref, computed } from 'vue'

// Import Lucide icons
import { UserPlus, ChevronLeft, ChevronRight } from 'lucide-vue-next'

// Import individual shadcn-vue components
import Button from '@/components/ui/button/Button.vue'
import Input from '@/components/ui/input/Input.vue'
import Card from '@/components/ui/card/Card.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import Select from '@/components/ui/select/Select.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue'
import SelectValue from '@/components/ui/select/SelectValue.vue'
import SelectContent from '@/components/ui/select/SelectContent.vue'
import SelectGroup from '@/components/ui/select/SelectGroup.vue'
import SelectItem from '@/components/ui/select/SelectItem.vue'
import EmployeeTable from '@/components/HrDep/EmployeeTable.vue'
import CreateEmployeeDialog from '@/components/HrDep/CreateEmployeeDialog.vue'

const propsData = defineProps({
    employees: Object,
    departments: Array,
    jobTitles: Array
})


defineOptions({
    layout: AppLayout,
});

</script>