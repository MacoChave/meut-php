// Tipo para las respuestas de la API. Incluye data genérico, mensaje y código de estado.
export interface ApiResponse<T> {
	data: T;
	message: string;
	status: number;
}
