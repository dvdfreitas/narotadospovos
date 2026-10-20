import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    // Keep the site light regardless of the device's color preference.
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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'nrp-blue': '#0083b3',
                'nrp-green': '#91be4a',
            },
            // O caminho em pontos do lema: cada ciclo avança dois pontos
            // (o stroke-dasharray é de 12), por isso o recomeço não se vê.
            keyframes: {
                route: {
                    to: { strokeDashoffset: '-24' },
                },
            },
            animation: {
                route: 'route 2.4s linear infinite',
            },
        },
    },
    plugins: [forms, typography],
};
