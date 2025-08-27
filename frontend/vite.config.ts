import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

// https://vite.dev/config/
export default defineConfig({
	plugins: [vue()],
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
});
