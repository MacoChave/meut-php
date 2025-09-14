export interface MenuItem {
	id: number;
	nombre: string;
	ruta: any;
	icono: any;
	hijos?: MenuItem[];
}

export interface LoginResponse {
	token: string;
	email: string;
	permissions: Record<string, MenuItem>;
}
