import { ref } from 'vue';
import { api } from './apiClient';
import type { PermissionResponse } from '../models/PermissionResponse';
import type { ApiResponse } from '../models/ApiResponse';

export default function useFetchRolePermissions(rol?: string) {
	const data = ref<PermissionResponse[]>();
	const error = ref();
	const loading = ref(false);

	async function fetchData() {
		loading.value = true;

		try {
			const response = await api.post<ApiResponse<PermissionResponse[]>>(
				'page/permissions/role',
				{
					rol,
				}
			);

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
