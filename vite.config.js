import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vite';

const __dirname = dirname(fileURLToPath(import.meta.url));

export default defineConfig({
  root: './src',
  publicDir: '../public',
  build: {
    emptyOutDir: true,
    outDir: '../dist',
    rollupOptions: {
      input: {
        main: resolve(__dirname, './src/index.html'),
        'single-product': resolve(__dirname, './src/single-product.js'),
        'front-page': resolve(__dirname, './src/front-page.js'),
        'archive-product': resolve(__dirname, './src/archive-product.js'),
        cart: resolve(__dirname, './src/cart.js'),
        search: resolve(__dirname, './src/search.js'),
        404: resolve(__dirname, './src/404.js'),
        contact: resolve(__dirname, './src/contact.js'),
        // ACF Components - manually defined for now
        'acf-image_left_content_right': resolve(
          __dirname,
          './src/js/components/acf/image_left_content_right.js'
        ),
        'acf-image_left_content_right-styles': resolve(
          __dirname,
          './src/scss/components/acf/image_left_content_right.scss'
        ),
      },
      output: {
        entryFileNames: (chunkInfo) => {
          // Place ACF component files in acf subfolder
          if (chunkInfo.name.startsWith('acf-')) {
            return 'assets/acf/[name].js';
          }
          return 'assets/[name].js';
        },
        chunkFileNames: 'assets/[name].js',
        assetFileNames: (assetInfo) => {
          // Place ACF component CSS in acf subfolder
          if (assetInfo.name && assetInfo.name.startsWith('acf-')) {
            return 'assets/acf/[name][extname]';
          }
          return 'assets/[name][extname]';
        },
      },
    },
  },
});
