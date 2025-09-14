<script setup lang="ts">
	import StepForm from '@/components/StepForm.vue';
	import Swal from 'sweetalert2';
	import { computed, onMounted, ref } from 'vue';
	import FormControl from '../../components/FormControl.vue';
	import { api } from '../../services/apiClient';

	interface Department {
		id_departamento: number;
		nombre: string;
	}

	interface Municipality {
		id_municipio: number;
		municipio: string;
		id_departamento: number;
	}

	const formData = ref({
		firstName: '',
		lastName: '',
		gender: '',
		bornDate: '',
		userRegister: '',
		userIdentification: '',
		department: '',
		municipality: '',
		userAddress: '',
		phone: '',
		email: '',
		password: '',
		confirmPassword: '',
	});

	const steps = [
		{ title: 'Información Personal', content: 'PersonalInfo' },
		{ title: 'Información de contacto', content: 'ContactInfo' },
		{ title: 'Seguridad', content: 'Security' },
	];

	// Estados para departamentos y municipios
	const departments = ref<Department[]>([]);
	const municipalities = ref<Municipality[]>([]);
	const loadingDepartment = ref(false);
	const loadingMunicipality = ref(false);

	// Opciones computadas para los selects
	const departmentOptions = computed(() =>
		departments.value.map((depto) => ({
			label: depto.nombre,
			value: depto.id_departamento.toString(),
		}))
	);

	// Opciones computadas para los selects
	const municipalityOptions = computed(() =>
		municipalities.value.map((muni) => ({
			label: muni.municipio,
			value: muni.id_municipio.toString(),
		}))
	);

	onMounted(async () => {
		await loadDepartments();
	});

	const loadDepartments = async () => {
		loadingDepartment.value = true;
		try {
			const { data } = await api.get<{ data: Department[] }>(
				'/location/departments'
			);
			departments.value = data.data || data;
		} catch (error) {
			Swal.fire({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				icon: 'error',
				title: 'Error al cargar departamentos',
			});
		} finally {
			loadingDepartment.value = false;
		}
	};

	const loadMunicipalities = async (departmentId: string) => {
		if (!departmentId) {
			municipalities.value = [];
			return;
		}

		loadingMunicipality.value = true;
		try {
			const { data } = await api.get<{ data: Municipality[] }>(
				`/location/departments/${departmentId}/municipality`
			);
			municipalities.value = data.data || data;
		} catch (error) {
			console.error('Error cargando municipios:', error);
			municipalities.value = [];
			Swal.fire({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				icon: 'error',
				title: 'Error al cargar municipios',
			});
		} finally {
			loadingMunicipality.value = false;
		}
	};

	const onDepartmentChange = async (departmentId: string) => {
		formData.value.municipality = '';

		if (departmentId) await loadMunicipalities(departmentId);
		else municipalities.value = [];
	};

	const handleSubmit = async () => {
		try {
			console.log('Datos del formulario:', formData.value);

			const { data } = await api.post<any>('/logup', {
				firstName: formData.value.firstName,
				lastName: formData.value.lastName,
				gender: formData.value.gender,
				bornDate: formatDate(formData.value.bornDate),
				userRegister: formData.value.userRegister,
				userIdentification: formData.value.userIdentification,
				municipality_id: +formData.value.municipality,
				userAddress: formData.value.userAddress,
				phone: formData.value.phone,
				email: formData.value.email,
				password: formData.value.password,
			});
			console.log('Respuesta del servidor:', data);
			Swal.fire({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				icon: 'success',
				title: data.data[0]?.message || 'Usuario registrado con éxito',
			});
		} catch (error: any) {
			let data = error?.response?.data ?? null;

			console.log({ error });

			Swal.fire({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				icon: 'error',
				title: data?.message ?? 'Error al registrar el usuario',
			});
		}
	};

	const formatDate = (date: Date | string) => {
		if (!date) return '';

		if (date instanceof Date) {
			return date.toISOString().split('T')[0];
		}

		if (typeof date === 'string') {
			if (date.includes('T')) {
				return date.split('T')[0];
			}
			return date; // Ya está en formato correcto
		}

		// Si es otro tipo, intentar convertir a Date
		try {
			return new Date(date).toISOString().split('T')[0];
		} catch (error) {
			console.error('Error al formatear fecha:', error);
			return '';
		}
	};
</script>

<template>
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
					placeholder="Ingrese sus nombres"
					prependIcon="mdi-account" />
				<FormControl
					v-model="formData.lastName"
					type="text"
					id="lastName"
					label="Apellidos"
					placeholder="Ingrese sus apellidos"
					prependIcon="mdi-account" />
				<FormControl
					v-model="formData.gender"
					type="select"
					id="gender"
					label="Genero"
					placeholder="Seleccione su género"
					:options="[
						{ label: 'Masculino', value: 'M' },
						{ label: 'Femenino', value: 'F' },
					]"
					prependIcon="mdi-account" />
				<FormControl
					v-model="formData.bornDate"
					type="date"
					id="bornDate"
					label="Fecha de nacimiento"
					placeholder="Seleccione su fecha de nacimiento" />
			</template>

			<!-- Paso 2 -->
			<!-- @ts-ignore -->
			<template #step-1="{ formData }">
				<FormControl
					v-model="formData.userRegister"
					type="text"
					id="userRegister"
					label="Registro universitario"
					placeholder="Ingrese el registro universitario"
					prependIcon="mdi-id-card" />
				<FormControl
					v-model="formData.userIdentification"
					type="text"
					id="userIdentification"
					label="Código único de identificación"
					placeholder="Ingrese su código único de identificación (CUI)"
					prependIcon="mdi-id-card" />
				<FormControl
					v-model="formData.phone"
					type="text"
					id="phone"
					label="Teléfono"
					placeholder="Ingrese su número de teléfono"
					prependIcon="mdi-phone" />
				<FormControl
					v-model="formData.department"
					type="select"
					label="Departamento *"
					placeholder="Seleccione un departamento"
					:options="departmentOptions"
					:loading="loadingDepartment"
					:disabled="loadingDepartment"
					:rules="[(v) => !!v || 'Departamento es obligarorio']"
					required
					@change="onDepartmentChange"
					prependIcon="mdi-home" />
				<FormControl
					v-model="formData.municipality"
					type="select"
					label="Municipalidad *"
					placeholder="Seleccione una municipalidad"
					:options="municipalityOptions"
					:loading="loadingMunicipality"
					:disabled="loadingMunicipality"
					:rules="[(v) => !!v || 'Municipio es obligarorio']"
					required
					prependIcon="mdi-city" />
				<FormControl
					v-model="formData.userAddress"
					type="textarea"
					id="userAddress"
					label="Dirección"
					placeholder="Complemente su dirección de residencia"
					:options="municipalityOptions"
					prependIcon="mdi-map-marker" />
			</template>

			<!-- Paso 3 -->
			<!-- @ts-ignore -->
			<template #step-2="{ formData }">
				<FormControl
					v-model="formData.email"
					type="email"
					id="email"
					label="Correo electrónico"
					placeholder="Ingrese su correo electrónico"
					prependIcon="mdi-email" />
				<FormControl
					v-model="formData.password"
					type="password"
					id="password"
					label="Contraseña"
					placeholder="Ingrese su contraseña"
					prependIcon="mdi-lock" />
				<FormControl
					v-model="formData.confirmPassword"
					type="password"
					id="confirmPassword"
					label="Confirmar contraseña"
					placeholder="Confirme su contraseña"
					prependIcon="mdi-lock"
					:rules="[
						(v) =>
							!!v || 'Confirmación de contraseña es obligarorio',
					]" />
			</template>
		</StepForm>

		<p class="mt-4 text-sm text-gray-600">
			¿Ya tienes una cuenta?
			<a href="/login" class="text-blue-500 hover:underline"
				>Inicia sesión aquí</a
			>
		</p>
	</div>
</template>

<style></style>
