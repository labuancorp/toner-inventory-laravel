import './bootstrap';
import './material.js';
import '../css/material.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Global manual theme helper (no auto-detect)
function applyThemeFromStorage() {
    try {
        const stored = localStorage.getItem('theme') || 'light';
        const isDark = stored === 'dark';
        document.documentElement.classList.toggle('dark', isDark);
        const btn = document.getElementById('themeToggle');
        const label = document.getElementById('themeLabel');
        if (btn) btn.setAttribute('aria-pressed', String(isDark));
        if (label) label.textContent = isDark ? 'Dark' : 'Light';
    } catch (e) { /* noop */ }
}

window.toggleTheme = function toggleTheme() {
    const nowDark = !document.documentElement.classList.contains('dark');
    document.documentElement.classList.toggle('dark', nowDark);
    localStorage.setItem('theme', nowDark ? 'dark' : 'light');
    const btn = document.getElementById('themeToggle');
    const label = document.getElementById('themeLabel');
    if (btn) btn.setAttribute('aria-pressed', String(nowDark));
    if (label) label.textContent = nowDark ? 'Dark' : 'Light';
}

document.addEventListener('DOMContentLoaded', applyThemeFromStorage);
