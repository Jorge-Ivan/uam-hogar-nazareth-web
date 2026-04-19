import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/livewire/livewire/src/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                nazareth: {
                    // Core brand — teal scale extracted from logo
                    blue:  '#0A6B73',   // Teal 900 — nav, headers, hero backgrounds
                    light: '#19B0B8',   // Teal 500 — primary accent, buttons, hover
                    // Extended teal scale
                    700:   '#10939C',   // titles, subheadings
                    400:   '#3EC1C8',   // hover complements, graphics
                    200:   '#9ED7DC',   // borders, separators
                    100:   '#C9E3E6',   // card backgrounds, selected states
                    50:    '#EAF4F5',   // section wash
                    // Neutral
                    ink:   '#1F2A2E',   // body text
                    paper: '#FBFBF9',   // warm page background
                    // Functional (unchanged)
                    gold:  '#E8A020',   // CTA buttons (donate, actions)
                    gray:  '#EAF4F5',   // section backgrounds (maps to teal-50)
                    green: '#3D7A45',   // published badges, success states
                },
            },
        },
    },
    plugins: [forms, typography],
};
