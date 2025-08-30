import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

// https://vite.dev/config/
export default defineConfig({
	plugins: [vue(), tailwindcss()],
	resolve: {
		alias: {
			'@': '/src',
		},
	},
	build: {
		outDir: '../public/dist',
		emptyOutDir: true,
		manifest: true,
		rollupOptions: {
			input: './src/main.ts',
		},
	},
	server: {
		origin: 'http://localhost:5173',
		cors: true,
	},
});
