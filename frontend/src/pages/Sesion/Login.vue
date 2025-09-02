<template>
	<MainLayout>
		<div class="flex flex-col items-center justify-center h-full bg-white">
			<h1 class="text-2xl font-semibold mb-6">Inicio de sesión</h1>

			<form
				@submit.prevent="handleSubmit"
				class="w-80 bg-gray-100 p-6 rounded-lg shadow-md space-y-4">
				<FormControl
					v-model="formData.email"
					type="text"
					id="username"
					label="Usuario"
					placeholder="Ingrese su usuario" />
				<FormControl
					v-model="formData.password"
					type="password"
					id="password"
					label="Contraseña"
					placeholder="Ingrese su contraseña" />
				<button
					class="w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
					type="submit">
					Ingresar
				</button>
			</form>

			<p class="mt-4 text-sm text-gray-600">
				¿No tienes una cuenta?
				<a href="/logup" class="text-blue-500 hover:underline"
					>Regístrate aquí</a
				>
			</p>
		</div>
	</MainLayout>
</template>

<script setup lang="ts">
	import MainLayout from '@/layouts/MainLayout.vue';
	import FormControl from '@/components/FormControl.vue';
	import { ref } from 'vue';
	import { api } from '../../services/apiClient';

	const formData = ref({
		email: '',
		password: '',
	});

	const handleSubmit = async () => {
		// Aquí puedes manejar la lógica de inicio de sesión
		console.log('Datos del formulario:', formData.value);
		try {
			const { data } = await api.post<{ token: string }>('/login', {
				email: formData.value.email,
				password: formData.value.password,
			});
			console.log('Respuesta del servidor:', data);
		} catch (error) {
			console.error('Error durante el inicio de sesión:', error);
		}
	};
</script>
