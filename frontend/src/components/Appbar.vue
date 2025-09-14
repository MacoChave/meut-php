<script setup lang="ts">
	import { computed } from 'vue';
	import { useAuthStore } from '../store/auth';
	import { useRouter } from 'vue-router';

	const auth = useAuthStore();
	const router = useRouter();

	// Check if user is logged in
	const isLogged = computed(() => !!auth.getToken());

	// Logout function
	const logout = () => {
		auth.clearAuth();
		router.push({ name: 'Login' });
	};

	const login = () => {
		router.push({ name: 'Login' });
	};

	const logup = () => {
		router.push({ name: 'Logup' });
	};
</script>

<template>
	<v-app-bar :elevation="2" color="primary">
		<v-app-bar-title>Unidad de tesis</v-app-bar-title>

		<template v-slot:append>
			<v-tooltip v-if="!isLogged" text="Iniciar sesión">
				<template v-slot:activator="{ props }">
					<v-btn
						v-bind="props"
						icon="mdi-login"
						@click="login"></v-btn>
				</template>
			</v-tooltip>
			<v-tooltip v-if="!isLogged" text="Crear cuenta">
				<template v-slot:activator="{ props }">
					<v-btn
						v-bind="props"
						icon="mdi-account-plus"
						@click="logup"></v-btn>
				</template>
			</v-tooltip>
			<v-tooltip v-if="isLogged" text="Cerrar sesión">
				<template v-slot:activator="{ props }">
					<v-btn
						v-bind="props"
						icon="mdi-logout"
						@click="logout"></v-btn>
				</template>
			</v-tooltip>
		</template>
	</v-app-bar>
</template>
