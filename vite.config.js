import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/internal.css',
                'resources/css/map.css',
                'resources/css/reviewer.css',
                'resources/css/tutorial.css',
                'resources/js/map.js',
                'resources/js/review.js',
                'resources/js/reviewer.js',
            ],
            refresh: true,
        }),
    ],
});
