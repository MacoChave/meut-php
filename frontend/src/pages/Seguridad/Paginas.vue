<script setup lang="ts">
	import { computed, watch } from 'vue';
	import { useRoute } from 'vue-router';
	import type { PagesResponse } from '../../models/PagesResponse';
	import useFetch from '../../services/useFetch';
	import Swal from 'sweetalert2';

	const route = useRoute();

	const { data, error, fetchData } = useFetch<PagesResponse[]>('', {}, false);

	const headers = [
		{ text: 'Nombre', value: 'nombre', align: 'start' },
		{ text: 'Descripción', value: 'descripcion' },
		{ text: 'Requiere sesión', value: 'required_auth' },
		{ text: 'Es visible', value: 'visible_en_menu' },
	];

	const items = computed(() => data.value || []);

	// On mount component, call to fetchData
	watch(
		() => route.params.PageId,
		async (PageId) => {
			await fetchData(`/page/${PageId || 0}`);
			console.log({ data, error });

			if (error.value) {
				Swal.fire({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					icon: 'error',
					title: 'Error al cargar las páginas',
				});
				// Redirect to previous page
				window.history.back();
			}
		},
		{ immediate: true }
	);
</script>

<template>
	<div class="md:px-20">
		<div class="my-8">
			<h1 class="text-3xl font-bold text-slate-900 tracking-tight">
				Páginas
			</h1>
			<p class="text-slate-500 mt-1">Gestión de páginas</p>
		</div>

		<v-table>
			<thead>
				<tr>
					<th
						v-for="header in headers"
						:key="header.value"
						class="bg-slate-100 text-slate-600 font-medium">
						{{ header.text }}
					</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in items" :key="item.id_pagina">
					<td class="text-left">{{ item.nombre }}</td>
					<td class="text-left">{{ item.descripcion }}</td>
					<td class="text-center">
						<v-switch v-model="item.require_auth" color="primary">
							{{ item.require_auth ? 'Sí' : 'No' }}
						</v-switch>
					</td>
					<td class="text-center">
						<v-switch
							v-model="item.visible_en_menu"
							color="primary">
							{{ item.visible_en_menu ? 'Sí' : 'No' }}
						</v-switch>
					</td>
					<td>
						<div class="flex flex-row gap-2">
							<router-link
								:to="`/seguridad/paginas/${item.id_pagina}`">
								<v-btn color="secondary" icon="mdi-eye"></v-btn>
							</router-link>
							<v-btn color="primary" icon="mdi-pencil"></v-btn>
						</div>
					</td>
				</tr>
			</tbody>
		</v-table>
	</div>
</template>
