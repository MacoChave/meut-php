import { ref } from 'vue';
import { api } from './apiClient';
import type { ApiResponse } from '../models/ApiResponse';

export default function useFetch<T>(
	url: string,
	body: any = null,
	inmediate: boolean = true
) {
	const data = ref<T | null>(null);
	const error = ref<string | null>(null);
	const loading = ref<boolean>(false);

	async function fetchData(customUrl: string = url, customBody: any = body) {
		loading.value = true;
		try {
			const response = await api.get<ApiResponse<T>>(
				customUrl,
				customBody
			);
			data.value = response.data.data;
			error.value = response.data.message || null;
		} catch (err: any) {
			error.value = err.message;
		} finally {
			loading.value = false;
		}
	}

	if (inmediate) {
		fetchData();
	}

	return { data, error, loading, fetchData };
}
