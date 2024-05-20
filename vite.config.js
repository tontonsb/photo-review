import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/reviewer.css',
                'resources/css/internal.css',
                'resources/js/reviewer.js',
            ],
            refresh: true,
        }),
    ],
});
