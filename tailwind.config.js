const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Open Sans', 'sans-serif'],
            },
            fontSize: {
                sm: '0.9rem',
                base: '1rem',
                lg: '1.25rem',
                xl: '1.5rem',
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
