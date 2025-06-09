import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'Noto Sans', 'sans-serif'],
                poppins: ['Poppins', 'sans-serif'],
                noto: ['Noto Sans', 'sans-serif'],
            },
            colors: {
                'creamhh': '#FFF0B7',
                'all': '#F5F5DE',
                'redb': '#902B29',
                'greenbg': '#3F8044',
                'greenpastel': '#64B16A',
                'creamcard': '#FFF7D9',
                'base-100': '#FFFFFF',
                'blackAuth': '#2C2C2C',
                'greenAuth': '#29642A',
                'greyAuth': '#B5B5B5',
                'greyCheck': 'A4A4A4',
            },
            boxShadow: {
                'quadrupleNonHover': '3px 3px 0px rgb(0, 0, 0, 0.25), 2px 2px 0px rgb(255, 240, 183, 1), 1px 1px 0px rgb(255, 240, 183, 1), 4px 4px 0px rgb(144, 43, 41, 1)',
                'quadrupleHover': '3px 3px 0px rgb(0, 0, 0, 0.25), 2px 2px 0px rgb(255, 240, 183, 1), 1px 1px 0px rgb(255, 240, 183, 1), 4px 4px 0px rgb(63, 128, 68, 1)',
            },

        },
    },

    plugins: [forms, typography],
};
