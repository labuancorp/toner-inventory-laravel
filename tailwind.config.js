import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    primary: '#2563eb', // indigo-600
                    accent: '#f59e0b',  // amber-500
                    success: '#10b981', // emerald-500
                    danger: '#ef4444',  // red-500
                    muted: '#64748b',   // slate-500
                },
            },
        },
    },

    plugins: [forms],
};
