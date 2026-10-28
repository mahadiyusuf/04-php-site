const themeToggle = document.querySelector('.theme-toggle');
const themeToggleLabel = document.querySelector('.theme-toggle-label');
const themeToggleIcon = document.querySelector('.theme-toggle-icon');

if (themeToggle && themeToggleLabel && themeToggleIcon) {
    const updateThemeToggle = () => {
        const isDark = document.documentElement.dataset.theme === 'dark';

        themeToggle.setAttribute('aria-pressed', String(isDark));
        themeToggle.setAttribute('aria-label', `Switch to ${isDark ? 'light' : 'dark'} mode`);
        themeToggleLabel.textContent = `${isDark ? 'Light' : 'Dark'} mode`;
        themeToggleIcon.textContent = isDark ? '☀' : '☾';
    };

    updateThemeToggle();

    themeToggle.addEventListener('click', () => {
        const nextTheme = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
        document.documentElement.dataset.theme = nextTheme;
        localStorage.setItem('site-theme', nextTheme);
        updateThemeToggle();
    });
}
