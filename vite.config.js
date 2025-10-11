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
        // nested: resolve(__dirname, 'nested/index.html'),
      },
      output: {
        entryFileNames: 'assets/[name].js',
        chunkFileNames: 'assets/[name].js',
        assetFileNames: 'assets/[name][extname]',
      },
    },
  },
});
