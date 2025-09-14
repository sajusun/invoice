import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: '#4f46e5',
                'primary-dark': '#4338ca',
                secondary: '#10b981',
                accent: '#f59e0b',
                dark: '#1f2937',
                'dark-light': '#374151',
            }
        }
    },

    plugins: [forms],
};
