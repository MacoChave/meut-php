import { ref } from 'vue';
import { api } from './apiClient';
import type { PagePermissionResponse } from '../models/PagePermissionResponse';
import type { ApiResponse } from '../models/ApiResponse';

export default function useFetchRolePermissions(rol?: string) {
	const data = ref<PagePermissionResponse[]>();
	const error = ref();
	const loading = ref(false);

	async function fetchData() {
		loading.value = true;

		try {
			const response = await api.get<
				ApiResponse<PagePermissionResponse[]>
			>('page/permissions/role', {
				rol,
			});

			data.value = response.data.data;
			error.value = response.data.message;
		} catch (err: any) {
			error.value = err.message;
		} finally {
			loading.value = false;
		}
	}

	fetchData();

	return { data, error, loading };
}
