<script setup lang="ts">
	import FormControl from '@/components/FormControl.vue';
	import Swal from 'sweetalert2';
	import { ref } from 'vue';
	import type { ApiResponse } from '../../models/ApiResponse';
	import type { LoginResponse } from '../../models/LoginResponse';
	import { api } from '../../services/apiClient';
	import { useAuthStore } from '../../store/auth';
	import { useRouter } from 'vue-router';

	const auth = useAuthStore();
	const router = useRouter();

	const formData = ref({
		email: '',
		password: '',
	});

	const handleSubmit = async () => {
		// Aquí puedes manejar la lógica de inicio de sesión
		try {
			const { data } = await api.post<ApiResponse<LoginResponse>>(
				'/login',
				{
					email: formData.value.email,
					password: formData.value.password,
				}
			);

			auth.setAuth(data.data);

			Swal.fire({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				icon: 'success',
				title: 'Inicio de sesión exitoso',
			});

			router.push('/dashboard');
		} catch ({ response }: any) {
			let { data } = response;

			Swal.fire({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				icon: 'error',
				title: data?.error || 'Error en el inicio de sesión',
			});
		}
	};
</script>

<template>
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
</template>
