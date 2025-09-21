export function getLeaveRequestStatusClass(status: string) {
    switch (status.toLowerCase()) {
        case 'approved':
            return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
        case 'rejected':
            return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
    }
}