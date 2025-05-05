export function useCustomTheme(themeName: string): void {
    if (themeName) {
        loadTheme(themeName);
    }
}

export function loadTheme(themeName: string): void {
    const themeId = 'theme-css';

    // Remove existing theme if any
    const existingLink = document.getElementById(themeId);
    if (existingLink) existingLink.remove();

    // Create new <link> for the selected theme
    const link = document.createElement('link');
    link.id = themeId;
    link.rel = 'stylesheet';
    link.href = `/css/themes/${themeName}.css`;

    document.head.appendChild(link);

    link.onerror = () => {
        console.log(`Theme ${themeName} was not found!`);
    };


    localStorage.setItem('theme', themeName);
}

export const getStoredTheme = (): string | null => {
    if (typeof window === 'undefined') {
        return null;
    }

    return localStorage.getItem('theme');
};

export function initializeCustomTheme(): void {
    if (typeof window === 'undefined') {
        return;
    }

    // Initialize theme from saved preference or default to system...
    const savedTheme = getStoredTheme();
    if (savedTheme) {
        loadTheme(savedTheme);
    }
}

export function resetToDefaultTheme(): void {
    // Store in localStorage for client-side persistence...
    localStorage.setItem('theme', 'default');
}



