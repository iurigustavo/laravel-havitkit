/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors');

export default {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./app/View/Components/**/*.php",
        "./app/Livewire/**/*.php",
        './app/Livewire/**/*Table.php',
        './app/Core/PowerGridThemes/DaisyUi.php',
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php'
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif']
            },
            colors: {
                'pg-primary': colors.neutral,
                'pg-secondary': colors.blue,
                secondary: {
                    DEFAULT: '#f9f9f9',
                    content: '#4b5675',
                    border: '#f1f1f4', // Adding custom border color for secondary
                },
            },
        }
    },
    safelist: [
        {
            pattern: /badge-|(bg-primary|bg-success|bg-info|bg-error|bg-warning|bg-neutral|bg-purple|bg-yellow)/
        }
    ],
    plugins: [require("daisyui")],
    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")["light"],
                    "primary": "#9b3bf5",
                    "primary-content": "#ffffff",
                    "secondary": "#f9f9f9",
                    "secondary-content": "#4b5675",
                    "accent": "#ff6f1e",
                    "accent-content": "#ffffff",
                    "neutral": "#FFFFFF",
                    "neutral-content": "#4B5675",
                    "base-100": "#f9f9f9",
                    "base-200": "#f1f1f4",
                    "base-300": "#dbdfe9",
                    "base-content": "#161616",
                    "info": "#1B84FF",
                    "info-content": "#ffffff",
                    "success": "#17C653",
                    "success-content": "#ffffff",
                    "warning": "#F6B100",
                    "warning-content": "#ffffff",
                    "error": "#F8285A",
                    "error-content": "#ffffff",
                },
                dark: {
                    ...require("daisyui/src/theming/themes")["dark"],
                    primary: '#9b3bf5'
                }
            }
        ]
    }
}
