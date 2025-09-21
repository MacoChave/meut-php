<script setup lang="ts">
	import type { PagePermissionResponse } from '../../../models/PagePermissionResponse';

	const props = defineProps<{
		items: PagePermissionResponse[];
		headers: { text: string; value: string }[];
	}>();

	const emit = defineEmits<{
		(e: 'edit', item: PagePermissionResponse): void;
	}>();
</script>

<template>
	<v-data-table
		:headers="props.headers"
		:items="props.items"
		class="elevation-1"
		fixed-header
		disable-pagination
		item-key="id_hijo">
		<template #item.permisos="{ item }">
			<span v-for="perm in JSON.parse(item.permisos)" :key="perm">
				<v-chip v-if="perm === 'ver'" small>{{ perm }}</v-chip>
				<v-chip v-else-if="perm === 'crear'" small>{{ perm }}</v-chip>
				<v-chip v-else-if="perm === 'editar'" small>{{ perm }}</v-chip>
				<v-chip v-else-if="perm === 'eliminar'" small>{{
					perm
				}}</v-chip>
				<v-chip v-else small>{{ perm }}</v-chip>
			</span>
		</template>
		<template #item.actions="{ item }">
			<v-btn
				variant="flat"
				icon="mdi-pencil"
				@click="emit('edit', item)" />
		</template>
	</v-data-table>
</template>
