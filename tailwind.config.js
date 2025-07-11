import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'fade-in': 'fadeIn 0.8s ease-in-out',
                'fade-in-down': 'fadeInDown 0.6s ease-out',
                'fade-in-up': 'fadeInUp 0.6s ease-out',
                'fade-slide-up': 'fade-slide-up 0.5s ease-out forwards',
                'spin-fade': 'spinFade 0.6s ease-out',
            },
            borderRadius: {
                'br-custom': '1500px',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: 0, transform: 'translateY(5px)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                },
                fadeInDown: {
                    '0%': { opacity: 0, transform: 'translateY(-20px)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                },
                fadeInUp: {
                    '0%': { opacity: 0, transform: 'translateY(20px)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                },
                'fade-slide-up': {
                    '0%': { opacity: '0', transform: 'translateY(1rem)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                spinFade: {
                    '0%': { opacity: '0', transform: 'scale(0.5) rotate(-180deg)' },
                    '100%': { opacity: '1', transform: 'scale(1) rotate(0)' },
                },
            }
        },
    },

    plugins: [forms, require('flowbite/plugin')],
};
