import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.tsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['InterVariable', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        function ({ addComponents }) {
            addComponents({
                '.transparent-scrollbar': {
                    /* This will apply the transparent background to the scrollbar */
                    '&::-webkit-scrollbar': {
                        width: '3px', // Set the width of the scrollbar
                    },
                    '&::-webkit-scrollbar-track': {
                        background: 'transparent', // Make the track (background) transparent
                    },
                    '&::-webkit-scrollbar-thumb': {
                        background: '#888', // Set a color for the thumb (you can change this)
                        borderRadius: '10px', // Optional, for rounded thumb
                    },
                    '&::-webkit-scrollbar-thumb:hover': {
                        background: '#555', // Optional, change color on hover
                    },
                },
            });
        },
    ],
};
