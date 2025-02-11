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
            colors: {
                'upei-red': {
                    100: '#7c2d1c', // Lighter shade
                    200: '#8a3d32', // Muted version
                    300: '#b84e3e', // Slightly lighter
                    400: '#9f3a29', // Mid-light
                    500: '#661702', // Base color
                    600: '#4e0f10', // Darker shade
                    700: '#3d0c0b', // Even darker
                    800: '#2b0907', // Very dark
                    900: '#1a0604', // Almost black
                },
                'upei-green': {
                    100: '#7fa33f', // Lighter shade
                    200: '#88b44b', // Muted version
                    300: '#a3c85f', // Slightly lighter
                    400: '#7f9d31', // Mid-light
                    500: '#5c8727', // Base color
                    600: '#4a6e21', // Darker shade
                    700: '#3b5c1b', // Even darker
                    800: '#2d4a16', // Very dark
                    900: '#1f3912', // Almost black
                },
                'upei-yellow': {
                    100: '#fcd177', // Lighter shade
                    200: '#fcd95e', // Muted version
                    300: '#fbdb44', // Slightly lighter
                    400: '#fbbd2d', // Mid-light
                    500: '#fbb040', // Base color
                    600: '#e69a34', // Darker shade
                    700: '#d2872b', // Even darker
                    800: '#be7322', // Very dark
                    900: '#a76119', // Almost black
                },
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
