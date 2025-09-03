export function getAttendancesStatusVariant(status: string) {
    switch (status) {
        case 'Present': return 'bg-green-900 text-green-100'
        case 'Late': return 'bg-yellow-900 text-yellow-100'
        case 'Absent': return 'bg-red-900 text-red-100'
        case 'On Leave': return 'bg-cyan-900 text-cyan-100'
        default: return ''
    }
}