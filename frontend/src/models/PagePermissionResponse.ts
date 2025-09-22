export interface PagePermissionResponse {
	id_rol: any;
	id_padre?: number;
	nombre_padre?: string;
	id_hijo?: number;
	nombre_hijo?: string;
	rol?: string;
	permisos?: string;
}
