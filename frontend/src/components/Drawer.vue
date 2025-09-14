<script setup lang="ts">
	import { useAuthStore } from '../store/auth';

	const auth = useAuthStore();

	// Convertir permisos a un array para recorrerlos
	const menuItems = Object.values(auth.permissions || {});
</script>

<template>
	<v-navigation-drawer app expand-on-hover permanent rail color="primary">
		<v-list class="bg-primary">
			<v-list-item
				prepend-avatar="https://cdn.vuetifyjs.com/images/john.jpg"
				:title="auth.email"
				:subtitle="auth.email"></v-list-item>
		</v-list>
		<v-divider></v-divider>
		<v-list density="compact" class="bg-primary text-white" nav>
			<!-- Grupo principal -->
			<v-list-group
				v-for="item in menuItems"
				:key="item.id"
				:value="item.nombre"
				prepend-icon="mdi-folder">
				<template #activator="{ props }">
					<v-list-item
						v-bind="props"
						:title="item.nombre"></v-list-item>
				</template>

				<!-- Hijos -->
				<v-list-item
					v-for="child in item.hijos"
					:key="child.id"
					:title="child.nombre"
					:to="child.ruta"
					link
					prepend-icon="mdi-circle-small"></v-list-item>
			</v-list-group>
		</v-list>
	</v-navigation-drawer>
</template>
