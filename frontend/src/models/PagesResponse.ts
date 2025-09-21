export interface PagesResponse {
	id_pagina: number;
	nombre: string;
	descripcion: string;
	ruta: string | null;
	componente: string | null;
	icono: string;
	indice: number;
	id_padre: number | null;
	require_auth: boolean;
	visible_en_menu: boolean;
}
