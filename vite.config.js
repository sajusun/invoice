// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import vue from '@vitejs/plugin-vue'
//
// export default defineConfig({
//     plugins: [
//         laravel({
//             input: [
//                 'resources/css/app.css',
//                 'resources/js/app.js',
//                 'resources/js/dashboard.js',
//                 'resources/js/builder.js',
//                 'resources/js/customer.js'
//             ],
//             refresh: true,
//         }),
//         vue(),
//     ],
// });
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import path from 'path';

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/js/app.js'],
//             refresh: true,
//         }),
//         vue(), // 👈 this enables .vue files
//     ],
// });

export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js', // ✅ This line fixes the warning
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
    plugins: [vue(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/builder.js',
            ],
            refresh: true,
        }),],
});
