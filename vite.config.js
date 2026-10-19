import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

 
export default defineConfig({
    plugins: [
        laravel([
           'resources/css/app.scss',
            'resources/js/app.js',
              'resources/js/style.js',
            'resources/css/app.css',
        ]),
    ],
});
//npm run dev