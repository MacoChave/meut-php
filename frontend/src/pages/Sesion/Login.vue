<template>
	<MainLayout>
		<div class="flex flex-col items-center justify-center h-full bg-white">
			<h1 class="text-2xl font-semibold mb-6">Inicio de sesión</h1>

			<form
				action=""
				class="w-80 bg-gray-100 p-6 rounded-lg shadow-md space-y-4">
				<input
					type="text"
					class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-blue-300"
					placeholder="Usuario" />
				<input
					type="password"
					class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-blue-300"
					placeholder="Contraseña" />
				<button
					class="w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
					type="submit">
					Ingresar
				</button>
			</form>
		</div>
	</MainLayout>
</template>

<script setup lang="ts">
	import MainLayout from '@/layouts/MainLayout.vue';
</script>
