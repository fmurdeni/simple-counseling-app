import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/common.css",
                //"resources/css/tailwind.output.css",
                "resources/js/app.js",
                "resources/js/init-alpine.js",
            ],
            refresh: true,
        }),
    ],
});
