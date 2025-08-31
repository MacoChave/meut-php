import axios, { type AxiosRequestConfig, type AxiosResponse } from 'axios';

const apiClient = axios.create({
	baseURL: import.meta.env.VITE_API_URL || 'http://localhost:3000/api',
	timeout: 10000,
});

// Interceptor para agregar el token de autenticación a cada solicitud
apiClient.interceptors.request.use(
	(config) => {
		const token = localStorage.getItem('authToken');
		if (token) {
			config.headers.Authorization = `Bearer ${token}`;
		}
		return config;
	},
	(error) => {
		return Promise.reject(error);
	}
);

// Manejo global de errores
apiClient.interceptors.response.use(
	(response: AxiosResponse) => response,
	(error) => {
		if (error.response) {
			// Errores de respuesta del servidor
			console.error(
				'API Error:',
				error.response.status,
				error.response.data
			);
		} else if (error.request) {
			// Errores de solicitud sin respuesta
			console.error('No response received:', error.request);
		} else {
			// Otros errores
			console.error('Error setting up request:', error.message);
		}
		return Promise.reject(error);
	}
);

// Funciones genéricas para cada verbo
export const api = {
	get: <T>(url: string, params?: object, config?: AxiosRequestConfig) =>
		apiClient.get<T>(url, { params, ...config }),
	post: <T>(url: string, data?: object, config?: AxiosRequestConfig) =>
		apiClient.post<T>(url, data, config),
	put: <T>(url: string, data?: object, config?: AxiosRequestConfig) =>
		apiClient.put<T>(url, data, config),
	delete: <T>(url: string, config?: AxiosRequestConfig) =>
		apiClient.delete<T>(url, config),
};

export default apiClient;
