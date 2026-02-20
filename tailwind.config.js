import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
                kaushan: ['"Kaushan Script"', 'cursive'],
            },

            colors: {
                trueGray: '#94a3b8',
                // New Corporate Palette
                primary: {
                    DEFAULT: '#335A92', // Color Principal
                    50: '#f2f6fc',
                    100: '#e1eaf8',
                    200: '#c6d9f1',
                    300: '#9ebfe7',
                    400: '#6f9ed8',
                    500: '#335A92', // Main #335A92
                    600: '#26467a',
                    700: '#1f3862',
                    800: '#1b3052',
                    900: '#1a2944',
                    950: '#111a2b',
                },
                secondary: {
                    DEFAULT: '#477EB1', // Color Secundario
                    50: '#f0f7fe',
                    100: '#deeffb',
                    200: '#c4e3f8',
                    300: '#9accef',
                    400: '#477EB1', // Main #477EB1
                    500: '#2b90c7',
                    600: '#1f74a8',
                    700: '#1a5d89',
                    800: '#184f71',
                    900: '#18425d',
                    950: '#102b3e',
                },
                accent: {
                    DEFAULT: '#FFC107', // Amarillo solicitado
                    50: '#FFF8E1',
                    100: '#FFECB3',
                    500: '#FFC107',
                    600: '#FFB300',
                },
                danger: {
                    DEFAULT: '#FC0B29', // Rojo
                },
                // Legacy Mapping (greenLime -> New Blue Scheme)
                // Maps old purple/green theme to new Blue/Yellow theme automatically
                greenLime_50: '#FFFFFF',   // Was Neon Green. Now White for text clarity.
                greenLime_100: '#ECBD2D',  // Was Purple. Now Yellow (Accent).
                greenLime_200: '#B6D2EC',  // Was Dark Purple. Now Very Light Blue.
                greenLime_300: '#92BEE3',  // Was Purple. Now Light Blue.
                greenLime_400: '#477EB1',  // Was Purple Hover. Now Blue Light (Secondary).
                greenLime_500: '#335A92',  // Was Deep Purple (Main). Now Blue Dark (Primary).
                greenLime_600: '#2A4B7C',  // Was Teal. Now Darker Blue.
                greenLime_700: '#223D66',
                greenLime_800: '#192E4F',
                greenLime_900: '#111F39',
                greenLime_950: '#0A1120',

                purple_50: '#F0F5FA', // Map to light blue
                orange_50: '#ECBD2D', // Map to new Yellow
                white_50: '#FFFFFF',
                gray_50: '#A8A8A8',
            }
        },
    },

    corePlugins: {
        container: false,

    },

    plugins: [forms, typography],
};
