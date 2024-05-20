import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/reviewer/main.css',
                'resources/css/internal/main.css',
                'resources/js/reviewer.js',
            ],
            refresh: true,
        }),
    ],
});
