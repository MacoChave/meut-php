<template>
	<MainLayout>
		<div class="flex flex-col items-center justify-center h-full bg-white">
			<h1 class="text-2xl font-semibold mb-6">Registro de usuario</h1>

			<StepForm :steps="steps" v-model="formData" @submit="handleSubmit">
				<!-- Paso 1 -->
				<!-- @ts-ignore -->
				<template #step-0="{ formData }">
					<FormControl
						v-model="formData.firstName"
						type="text"
						id="firstName"
						label="Nombres"
						placeholder="Ingrese sus nombres" />
					<FormControl
						v-model="formData.lastName"
						type="text"
						id="lastName"
						label="Apellidos"
						placeholder="Ingrese sus apellidos" />
					<FormControl
						v-model="formData.gender"
						type="select"
						id="gender"
						label="Genero"
						placeholder="Seleccione su género"
						:options="[
							{ label: 'Masculino', value: 'M' },
							{ label: 'Femenino', value: 'F' },
						]" />
				</template>

				<!-- Paso 2 -->
				<!-- @ts-ignore -->
				<template #step-1="{ formData }">
					<FormControl
						v-model="formData.userRegister"
						type="text"
						id="userRegister"
						label="Registro universitario"
						placeholder="Ingrese el registro universitario" />
					<FormControl
						v-model="formData.userIdentification"
						type="text"
						id="userIdentification"
						label="Código único de identificación"
						placeholder="Ingrese su código único de identificación (CUI)" />
					<FormControl
						v-model="formData.userAddress"
						type="textarea"
						id="userAddress"
						label="Dirección"
						placeholder="Ingrese su dirección de residencia" />
					<FormControl
						v-model="formData.bornDate"
						type="date"
						id="bornDate"
						label="Fecha de nacimiento"
						placeholder="Seleccione su fecha de nacimiento" />
				</template>

				<!-- Paso 3 -->
				<!-- @ts-ignore -->
				<template #step-2="{ formData }">
					<FormControl
						v-model="formData.email"
						type="email"
						id="email"
						label="Correo electrónico"
						placeholder="Ingrese su correo electrónico" />
					<FormControl
						v-model="formData.password"
						type="password"
						id="password"
						label="Contraseña"
						placeholder="Ingrese su contraseña" />
					<FormControl
						v-model="formData.confirmPassword"
						type="password"
						id="confirmPassword"
						label="Confirmar contraseña"
						placeholder="Confirme su contraseña" />
				</template>
			</StepForm>

			<p class="mt-4 text-sm text-gray-600">
				¿Ya tienes una cuenta?
				<a href="/login" class="text-blue-500 hover:underline"
					>Inicia sesión aquí</a
				>
			</p>
		</div>
	</MainLayout>
</template>

<script setup lang="ts">
	import { ref } from 'vue';
	import MainLayout from '@/layouts/MainLayout.vue';
	import StepForm from '@/components/StepForm.vue';
	import FormControl from '../../components/FormControl.vue';

	const formData = ref({
		firstName: '',
		lastName: '',
		gender: '',
		bornDate: '',
		userRegister: '',
		userIdentification: '',
		userAddress: '',
		email: '',
		password: '',
		confirmPassword: '',
	});

	const steps = [
		{ title: 'Información Personal', content: 'PersonalInfo' },
		{ title: 'Información de contacto', content: 'ContactInfo' },
		{ title: 'Seguridad', content: 'Security' },
	];

	const handleSubmit = (data: any) => {
		console.log('Formulario enviado con datos:', data);
	};
</script>

<style></style>
