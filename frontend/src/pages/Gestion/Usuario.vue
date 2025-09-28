<script setup lang="ts">
	import { shallowRef } from 'vue';

	const open = shallowRef(false);

	const templateBulkLoadHandler = () => {
		console.log('Descargar plantilla');
	};

	const bulkLoadHandler = () => {
		console.log('Carga masiva');
	};
</script>

<template>
	<div class="md:px-20">
		<div class="my-8">
			<h1 class="text-3xl font-bold text-slate-900 tracking-tight">
				Usuarios
			</h1>
			<p class="text-slate-500 mt-1">Gestión de usuarios del sistema</p>
		</div>
	</div>
	<v-fab :app="true" color="primary" icon="mdi-plus" location="right bottom">
		<v-icon>{{ open ? 'mdi-close' : 'mdi-plus' }}</v-icon>
		<v-speed-dial
			v-model="open"
			location="top"
			transition="fade-transition"
			activator="parent">
			<v-tooltip text="Agregar usuario">
				<template v-slot:activator="{ props }">
					<v-btn key="1" color="secondary" v-bind="props" icon>
						<v-icon size="24">mdi-plus</v-icon>
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip text="Descargar plantilla">
				<template v-slot:activator="{ props }">
					<v-btn
						key="2"
						color="secondary"
						v-bind="props"
						icon
						@click="templateBulkLoadHandler()">
						<v-icon size="24">mdi-download</v-icon>
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip text="Carga masiva">
				<template v-slot:activator="{ props }">
					<v-btn
						key="3"
						color="secondary"
						v-bind="props"
						icon
						@click="bulkLoadHandler()">
						<v-icon size="24">mdi-upload</v-icon>
					</v-btn>
				</template>
			</v-tooltip>
		</v-speed-dial>
	</v-fab>
</template>
