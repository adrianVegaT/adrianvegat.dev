import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/View/Resources/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            typography: {
                DEFAULT: {
                    css: {
                        p: {
                            marginTop: '0.6em',
                            marginBottom: '0.6em',
                        },
                    },
                },
                lg: {
                    css: {
                        p: {
                            marginTop: '0.6em',
                            marginBottom: '0.6em',
                        },
                    },
                },
            },
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                    950: '#082f49',
                },
                terminal: {
                    bg: '#0a0a0a',
                    card: '#111111',
                    elevated: '#1a1a1a',
                    border: '#222222',
                    'border-bright': '#333333',
                    muted: '#737373',
                    dim: '#525252',
                },
            },
        },
    },

    plugins: [
        forms,
        require('@tailwindcss/typography'),
    ],
    
    darkMode: 'class',
};