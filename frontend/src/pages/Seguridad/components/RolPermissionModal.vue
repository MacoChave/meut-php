<script setup lang="ts">
	import { ref, watch } from 'vue';
	import type { PagesResponse } from '../../../models/PagesResponse';
	import type { PagePermissionResponse } from '../../../models/PagePermissionResponse';
	import useFetch from '../../../services/useFetch';
	import type { RolResponse } from '../../../models/RolResponse';
	import type { PermissionResponse } from '../../../models/PermissionResponse';

	const props = defineProps<{
		modelValue: boolean;
		permission: PagePermissionResponse | null;
	}>();

	const {
		data: parentData,
		error: errorParent,
		loading: loadingParent,
		fetchData: fetchParentPages,
	} = useFetch<PagesResponse[]>('/page/0', null, false);

	const {
		data: childData,
		error: errorChild,
		loading: loadingChild,
		fetchData: fetchChildPages,
	} = useFetch<PagesResponse[]>('', null, false);

	const {
		data: rolesData,
		error: errorRoles,
		loading: loadingRoles,
		fetchData: fetchRoles,
	} = useFetch<RolResponse[]>('/rol', null, false);

	const {
		data: permissionsData,
		error: errorPermissions,
		loading: loadingPermissions,
		fetchData: fetchPermissions,
	} = useFetch<PermissionResponse>('/permission', null, false);

	const emit = defineEmits<{
		(e: 'update:modelValue', value: boolean): void;
		(e: 'save', value: PagePermissionResponse): void;
	}>();

	const localPermission = ref<PagePermissionResponse>({
		id_padre: undefined,
		nombre_padre: undefined,
		id_hijo: undefined,
		nombre_hijo: undefined,
		rol: undefined,
		permisos: undefined,
	});

	watch(
		() => props.modelValue,
		(open) => {
			if (open) {
				fetchParentPages();
				fetchRoles();
				fetchPermissions();
			}
		}
	);

	watch(
		() => localPermission.value?.id_padre,
		(padre) => {
			if (padre) {
				console.log('Fetching child pages for parent ID:', padre);
				console.log('localPermission:', localPermission.value);

				fetchChildPages(`/page/${padre}`);
			} else {
				childData.value = [];
			}
		}
	);

	watch(
		() => ({
			...props.permission,
			permisos: JSON.parse(props.permission?.permisos ?? '[]'),
		}),
		(newVal) => {
			localPermission.value = newVal
				? { ...newVal }
				: {
						id_padre: undefined,
						nombre_padre: undefined,
						id_hijo: undefined,
						nombre_hijo: undefined,
						rol: undefined,
						id_rol: undefined,
						permisos: [],
				  };
		},
		{ immediate: true }
	);

	const save = () => {
		if (localPermission.value) {
			emit('save', localPermission.value);
			emit('update:modelValue', false);
		}
	};
</script>

<template>
	<v-dialog v-model="props.modelValue" max-width="600px">
		<v-card>
			<v-card-title>
				{{ props.permission ? 'Editar permiso' : 'Crear permiso' }}
			</v-card-title>

			<v-card-text>
				<v-form>
					<v-select
						v-model="localPermission.id_padre"
						label="Página padre"
						:items="parentData || []"
						item-value="id_pagina"
						item-title="nombre"
						:loading="loadingParent"
						:rules="[(v: any) => !!v || 'La página padre es requerida']"
						:disabled="!!props.permission"
						:error-messages="errorParent"
						required />
					<v-select
						v-model="localPermission.id_hijo"
						label="Página hijo"
						:items="childData || []"
						item-value="id_pagina"
						item-title="nombre"
						:loading="loadingChild"
						:rules="[(v: any) => !!v || 'La página hijo es requerida']"
						:disabled="
							!!props.permission || !localPermission.id_padre
						"
						:error-messages="errorChild"
						required />
					<v-select
						v-model="localPermission.id_rol"
						label="Rol"
						:items="rolesData || []"
						item-value="id_rol"
						item-title="nombre"
						:loading="loadingRoles"
						:rules="[(v: any) => !!v || 'El rol es requerido']"
						:disabled="!!props.permission"
						:error-messages="errorRoles"
						required />
					<v-select
						v-model="localPermission.permisos"
						label="Permisos"
						:items="permissionsData || []"
						item-value="id_permiso"
						item-title="nombre"
						multiple
						chips
						:loading="loadingPermissions"
						:rules="[
							(v: string | any[]) =>
								(v && v.length > 0) ||
								'Al menos un permiso es requerido',
						]"
						:error-messages="errorPermissions"
						required />
				</v-form>
			</v-card-text>

			<v-card-actions>
				<v-btn
					variant="outlined"
					color="primary"
					@click="emit('update:modelValue', false)"
					>Cancelar</v-btn
				>
				<v-btn variant="flat" color="primary" @click="save"
					>Guardar</v-btn
				>
			</v-card-actions>
		</v-card>
	</v-dialog>
</template>
