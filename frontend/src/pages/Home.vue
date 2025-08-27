<template>
	<MainLayout>
		<div
			class="flex flex-col items-center justify-center min-h-screen bg-gray-50">
			<h1 class="text-3xl font-bold text-blue-600 mb-6">
				Bienvenido al Home
			</h1>

			<router-link
				to="/login"
				class="px-6 py-3 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition">
				Iniciar sesión
			</router-link>
		</div>
	</MainLayout>
</template>

<script setup lang="ts">
	import MainLayout from '@/layouts/MainLayout.vue';
</script>
