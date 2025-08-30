<template>
	<nav class="h-16 text-white shadow-md">
		<div
			class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
			<!-- Brand -->
			<router-link to="/" class="text-xl font-bold"
				>Unidad de tesis</router-link
			>

			<!-- Links -->
			<div class="space-x-4">
				<router-link to="/" class="hover:text-primary-500 transition"
					>Inicio</router-link
				>
				<router-link
					to="/Login"
					class="hover:text-primary-500 transition"
					>Iniciar sesión</router-link
				>
			</div>
		</div>
	</nav>
</template>

<script setup lang="ts"></script>
