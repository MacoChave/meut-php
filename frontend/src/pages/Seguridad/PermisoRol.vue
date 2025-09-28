<script lang="ts" setup>
	import Swal from 'sweetalert2';
	import { computed, ref } from 'vue';
	import type { ApiResponse } from '../../models/ApiResponse';
	import type {
		PagePermission,
		PagePermissionResponse,
	} from '../../models/PagePermissionResponse';
	import { api } from '../../services/apiClient';
	import useFetch from '../../services/useFetch';
	import PermissionTable from './components/PermissionTable.vue';
	import RolPermissionModal from './components/RolPermissionModal.vue';

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

	const handleSave = async (perm: PagePermissionResponse) => {
		try {
			if (perm.permisos) {
				perm.permisos = perm.permisos.map(
					(p: number | PagePermission) => {
						if (typeof p !== 'number') {
							return p.id_permiso;
						}
						return p;
					}
				);
			}

			const { data } = await api.post<ApiResponse<any>>(
				`/permission/${perm.id_hijo}/role/${perm.id_rol}`,
				{
					permissions: perm.permisos,
				}
			);

			if (data.status === 200) {
				Swal.fire({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					icon: 'success',
					title: 'Permisos actualizados correctamente',
				});
				fetchData();
			} else {
				Swal.fire({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					icon: 'error',
					title: 'Error al actualizar los permisos',
				});
			}
		} catch (err: any) {
			Swal.fire({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				icon: 'error',
				title:
					err.response?.data?.message ||
					'Error al actualizar los permisos',
			});
		}
	};
</script>

<template>
	<div class="md:px-20">
		<div class="my-8">
			<h1 class="text-3xl font-bold text-slate-900 tracking-tight">
				Permisos por rol
			</h1>
			<p class="text-slate-500 mt-1">
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
		@click="openCreateModal()" />

	<RolPermissionModal
		v-model="showModal"
		:permission="editingPermission"
		@save="handleSave" />
</template>
