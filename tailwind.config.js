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
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Outfit', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                brand: {
                    50:  '#eef2ff',
                    100: '#e0e7ff',
                    200: '#c7d2fe',
                    300: '#a5b4fc',
                    400: '#818cf8',
                    500: '#6366f1',  // Primary Indigo
                    600: '#4f46e5',
                    700: '#4338ca',
                    800: '#3730a3',
                    900: '#312e81',
                    950: '#1e1b4b',
                },
                accent: {
                    400: '#34d399',  // Emerald accent
                    500: '#10b981',
                    600: '#059669',
                },
                surface: {
                    50:  '#fafafa',
                    100: '#f4f4f5',
                    200: '#e4e4e7',
                    700: '#3f3f46',
                    800: '#27272a',
                    850: '#1c1c1f',
                    900: '#18181b',
                    950: '#09090b',  // Deep Slate
                },
            },
            animation: {
                'fade-in': 'fadeIn 0.6s ease-out forwards',
                'slide-up': 'slideUp 0.6s ease-out forwards',
                'slide-in-left': 'slideInLeft 0.5s ease-out forwards',
                'pulse-slow': 'pulse 3s ease-in-out infinite',
                'float': 'float 6s ease-in-out infinite',
                'glow': 'glow 2s ease-in-out infinite alternate',
                'gradient': 'gradient 8s linear infinite',
                'counter': 'counter 2s ease-out forwards',
            },
            keyframes: {
                fadeIn: {
                    '0%':   { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%':   { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideInLeft: {
                    '0%':   { opacity: '0', transform: 'translateX(-30px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%':     { transform: 'translateY(-10px)' },
                },
                glow: {
                    '0%':   { boxShadow: '0 0 5px rgba(99, 102, 241, 0.3)' },
                    '100%': { boxShadow: '0 0 20px rgba(99, 102, 241, 0.6)' },
                },
                gradient: {
                    '0%, 100%': { 'background-position': '0% 50%' },
                    '50%':     { 'background-position': '100% 50%' },
                },
            },
            backdropBlur: {
                xs: '2px',
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'hero-pattern': 'radial-gradient(ellipse at 30% 20%, rgba(99, 102, 241, 0.15) 0%, transparent 60%), radial-gradient(ellipse at 70% 60%, rgba(16, 185, 129, 0.1) 0%, transparent 60%)',
            },
        },
    },

    plugins: [forms],
};
