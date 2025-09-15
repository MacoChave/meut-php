<script lang="ts" setup>
	import { computed } from 'vue';
	import type { PermissionResponse } from '../../models/PermissionResponse';
	import useFetchRolePermissions from '../../services/useFetchRolePermissions';

	const { loading, error, data: perms } = useFetchRolePermissions();

	const groupedPerms = computed(() => {
		if (!perms.value) return [];

		return perms.value.reduce(
			(
				acc: Record<string, PermissionResponse[]>,
				item: PermissionResponse
			) => {
				if (!acc[item.nombre_padre]) acc[item.nombre_padre] = [];

				acc[item.nombre_padre].push(item);
				return acc;
			},
			{}
		);
	});

	const edit = (item: PermissionResponse) => {
		console.log('Edit', item);
	};
</script>

<template>
	<div class="w-full mx-auto md:w-2xl">
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
				<v-expansion-panel-title>{{
					parentName
				}}</v-expansion-panel-title>

				<v-expansion-panel-text>
					<v-table height="100%" fixed-header>
						<thead>
							<tr>
								<th class="text-left">Página</th>
								<th class="text-left">Rol</th>
								<th class="text-left">Permisos</th>
								<th class="text-left"></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="item in items" :key="item.id_hijo">
								<td>{{ item.nombre_hijo }}</td>
								<td>{{ item.rol }}</td>
								<td>
									<span
										v-for="perm in JSON.parse(
											item.permisos
										)"
										:key="perm"
										class="mr-2">
										<v-chip small color="primary">
											{{ perm }}
										</v-chip>
									</span>
								</td>
								<td>
									<v-btn
										variant="flat"
										icon="mdi-pencil"
										@click="edit(item)">
									</v-btn>
								</td>
							</tr>
						</tbody>
					</v-table>
				</v-expansion-panel-text>
			</v-expansion-panel>
		</v-expansion-panels>
	</div>
</template>
