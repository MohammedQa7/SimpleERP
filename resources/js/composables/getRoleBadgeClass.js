export function getRoleBadgeClass(role) {
    const roleClasses = {
        'Administrator': 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        'Sales Manager': 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
        'Finance Manager': 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        'HR Manager': 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        'Inventory Manager': 'bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-400',
        'CRM Manager': 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400'
    };

    return roleClasses[role] || 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300'; // Default fallback
}