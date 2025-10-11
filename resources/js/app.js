import './bootstrap';
import './material.js';
import '../css/material.css';
import '../css/material-dark.css'; // Import the dark theme styles

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// --- Theme & Appearance Helpers ---

const THEME_COLORS = {
    'blue': '#206bc4',
    'green': '#2fb344',
    'purple': '#ae3ec9',
    'orange': '#d6336c',
    'red': '#d63939',
};

function applyTheme(isDark) {
    document.documentElement.classList.toggle('dark', isDark);
    const materialBody = document.querySelector('body.material-layout');
    if (materialBody) {
        materialBody.dataset.theme = isDark ? 'dark' : 'light';
    }
    const btn = document.getElementById('themeToggle');
    if (btn) btn.setAttribute('aria-pressed', String(isDark));
}

function applyColor(colorName) {
    const colorValue = THEME_COLORS[colorName] || THEME_COLORS['blue'];
    document.documentElement.style.setProperty('--theme-primary-color', colorValue);
}

function applyDensity(densityName) {
    // Uniform modern theme: no density class toggling
    try { localStorage.setItem('theme_density', densityName); } catch (e) {}
    document.documentElement.classList.remove('layout-compact-material');
}

// --- Global Functions & Event Listeners ---

window.toggleTheme = function() {
    const isDark = !document.documentElement.classList.contains('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    applyTheme(isDark);
};

window.setThemeColor = function(colorName) {
    localStorage.setItem('theme_color', colorName);
    applyColor(colorName);
}

window.setThemeDensity = function(densityName) {
    localStorage.setItem('theme_density', densityName);
    applyDensity(densityName);
}

document.addEventListener('DOMContentLoaded', () => {
    try {
        const theme = localStorage.getItem('theme') || 'light';
        applyTheme(theme === 'dark');

        const color = localStorage.getItem('theme_color') || 'blue';
        applyColor(color);

    const density = localStorage.getItem('theme_density') || 'default';
    applyDensity(density);
    } catch (e) {
        console.error("Failed to apply theme settings from localStorage.", e);
    }
});
