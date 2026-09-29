import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';

export default defineConfig({
  plugins: [
    react(),
    tailwindcss(),
  ],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src'),
    },
  },
  build: {
    outDir: 'style',
    emptyOutDir: false,
    rollupOptions: {
      input: 'src/main.tsx',
      output: {
        entryFileNames: 'worldcampus.bundle.js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith('.css')) {
            return 'worldcampus.css';
          }
          return '[name].[ext]';
        },
        format: 'iife',
        name: 'WorldCampusApp',
      },
    },
  },
});
