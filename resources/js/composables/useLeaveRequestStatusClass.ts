export function getLeaveRequestStatusClass(status: string): string {
    switch (status.toLowerCase()) {
        case 'approved':
            return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
        case 'rejected':
            return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'

        default: return 'bg-zinc-100 text-zinc-800 dark:bg-zinc-900 dark:text-zinc-300'
    }
}