import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
const path = require('path')

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias:{
            vue         :"vue/dist/vue.esm-bundler.js",
            // "~bootstrap":"bootstrap",
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~bootstrap-icons': path.resolve(__dirname, 'node_modules/bootstrap-icons'),
        }
    }
});
