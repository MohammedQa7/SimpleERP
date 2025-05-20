export const getStatusVariant = (status: string) => {
    switch (status) {
        case 'Paid': return 'bg-green-900 text-green-100'
        case 'Sent': return 'bg-cyan-900 text-cyan-100'
        default: return ''
    }
}