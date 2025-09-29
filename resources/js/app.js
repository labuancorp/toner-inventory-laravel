import './bootstrap';
import './material.js';
import '../css/material.css';
import '../css/material-dark.css'; // Import the dark theme styles

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Global theme helper to apply/toggle Tailwind and Material themes
function applyTheme(isDark) {
    // 1. Set Tailwind's 'dark' class on the <html> element
    document.documentElement.classList.toggle('dark', isDark);

    // 2. Set Material theme's `data-theme` attribute on the <body>
    const materialBody = document.querySelector('body.material-layout');
    if (materialBody) {
        materialBody.dataset.theme = isDark ? 'dark' : 'light';
    }

    // 3. Update ARIA state and label for the theme toggle button
    const btn = document.getElementById('themeToggle');
    const label = document.getElementById('themeLabel');
    if (btn) {
        btn.setAttribute('aria-pressed', String(isDark));
    }
    if (label) {
        label.textContent = isDark ? 'Dark Mode' : 'Light Mode';
    }
}

// Read theme from localStorage and apply it
function applyThemeFromStorage() {
    try {
        const storedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(storedTheme === 'dark');
    } catch (e) {
        console.error('Failed to apply theme from storage:', e);
    }
}

// Toggle theme and save preference to localStorage
window.toggleTheme = function toggleTheme() {
    const isCurrentlyDark = document.documentElement.classList.contains('dark');
    const newTheme = isCurrentlyDark ? 'light' : 'dark';
    localStorage.setItem('theme', newTheme);
    applyTheme(newTheme === 'dark');
}

// Apply theme as soon as the DOM is loaded
document.addEventListener('DOMContentLoaded', applyThemeFromStorage);
