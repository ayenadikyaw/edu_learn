import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', 'Open Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#0a316a',
                primary_light: '#1a69cc',
                secondary: '#7ed957',
                secondary_light: '#a3f09d',
                accent: '#f5f5f5',
                'accent-dark': '#e0e0e0',
            },
        },
    },

    plugins: [forms],
};
