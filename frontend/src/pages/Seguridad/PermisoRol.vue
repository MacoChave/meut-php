<script lang="ts" setup>
	import { computed, ref } from 'vue';
	import type { PagePermissionResponse } from '../../models/PagePermissionResponse';
	import useFetch from '../../services/useFetch';
	import PermissionModal from './components/PermissionModal.vue';
	import PermissionTable from './components/PermissionTable.vue';

	const { data, error, loading, fetchData } = useFetch<
		PagePermissionResponse[]
	>('page/permissions/role', {}, true);
	const showModal = ref(false);
	const editingPermission = ref<PagePermissionResponse | null>(null);

	const groupedPerms = computed(() => {
		if (!data.value) return [];

		return data.value.reduce(
			(
				acc: Record<string, PagePermissionResponse[]>,
				item: PagePermissionResponse
			) => {
				if (!acc[item.nombre_padre]) acc[item.nombre_padre] = [];

				acc[item.nombre_padre].push(item);
				return acc;
			},
			{}
		);
	});

	const headers = [
		{ text: 'Página', value: 'nombre_hijo' },
		{ text: 'Rol', value: 'rol' },
		{ text: 'Permisos', value: 'permisos' },
		{ text: 'Acciones', value: 'actions', sortable: false },
	];

	const openCreateModal = () => {
		editingPermission.value = null;
		showModal.value = true;
	};

	const openEditModal = (item: PagePermissionResponse) => {
		editingPermission.value = { ...item };
		showModal.value = true;
	};

	const closeModal = () => {
		showModal.value = false;
		editingPermission.value = null;
	};

	const handleSave = (perm: PagePermissionResponse) => {
		if (perm.id_hijo) {
			console.log('Editando permiso:', perm);
		} else {
			console.log('Creando permiso:', perm);
		}
	};
</script>

<template>
	<div class="md:px-20">
		<div class="my-8">
			<h1 class="text-3xl font-bold text-slate-900 tracking-tight">
				Permisos por rol
			</h1>
			<p class="text-slate-500mt-1">
				Gestión de permisos por cada rol y agrupador de páginas
			</p>
		</div>

		<v-expansion-panels variant="popout">
			<v-expansion-panel
				v-for="(items, parentName) in groupedPerms"
				color="primary"
				:key="parentName">
				<v-expansion-panel-title
					>{{ parentName }}
				</v-expansion-panel-title>

				<v-expansion-panel-text>
					<PermissionTable
						:items="items"
						:headers="headers"
						@edit="openEditModal" />
				</v-expansion-panel-text>
			</v-expansion-panel>
		</v-expansion-panels>
	</div>

	<v-fab
		color="primary"
		icon="mdi-plus"
		:app="true"
		location="right bottom"
		@click="openCreateModal()">
	</v-fab>

	<PermissionModal
		v-model="showModal"
		:permission="editingPermission"
		@save="handleSave" />
</template>
