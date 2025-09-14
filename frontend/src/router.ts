import { createRouter, createWebHistory } from 'vue-router';

const routes = [
	{
		path: '/',
		name: 'Home',
		component: () => import('./pages/Home/Home.vue'),
		meta: { layout: 'MainLayout' },
	},
	{
		path: '/login',
		name: 'Login',
		component: () => import('./pages/Sesion/Login.vue'),
		meta: { layout: 'MainLayout' },
	},
	{
		path: '/logup',
		name: 'Logup',
		component: () => import('./pages/Sesion/Logup.vue'),
		meta: { layout: 'MainLayout' },
	},
	{ path: '/:pathMatch(.*)*', redirect: '/' },
	// Protected routes (require authentication)

	// Protected routes (require authentication)
	{
		path: '/dashboard',
		name: 'Dashboard',
		component: () => import('./pages/Dashboard/Dashboard.vue'),
		meta: { layout: 'SignedLayout' },
	},

	// Gestión Routes
	{
		path: '/gestion/usuario',
		name: 'GestionUsuario',
		component: () => import('./pages/Gestion/Usuario.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/gestion/curso',
		name: 'GestionCurso',
		component: () => import('./pages/Gestion/Curso.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/gestion/horario',
		name: 'GestionHorario',
		component: () => import('./pages/Gestion/Horario.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/gestion/jornada',
		name: 'GestionJornada',
		component: () => import('./pages/Gestion/Jornada.vue'),
		meta: { layout: 'SignedLayout' },
	},

	// Seguridad Routes
	{
		path: '/seguridad/paginas',
		name: 'SeguridadPaginas',
		component: () => import('./pages/Seguridad/Paginas.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/seguridad/permiso-rol',
		name: 'SeguridadPermisoRol',
		component: () => import('./pages/Seguridad/PermisoRol.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/seguridad/permiso-usuario',
		name: 'SeguridadPermisoUsuario',
		component: () => import('./pages/Seguridad/PermisoUsuario.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/seguridad/constantes',
		name: 'SeguridadConstantes',
		component: () => import('./pages/Seguridad/Constantes.vue'),
		meta: { layout: 'SignedLayout' },
	},

	// Encargado Routes
	{
		path: '/encargado/punto-tesis',
		name: 'EncargadoPuntoTesis',
		component: () => import('./pages/Encargado/PuntoTesis.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/encargado/curso-1',
		name: 'EncargadoCurso1',
		component: () => import('./pages/Encargado/Curso1.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/encargado/curso-2',
		name: 'EncargadoCurso2',
		component: () => import('./pages/Encargado/Curso2.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/encargado/comision-estilos',
		name: 'EncargadoComisionEstilos',
		component: () => import('./pages/Encargado/ComisionEstilos.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/encargado/previos-internos',
		name: 'EncargadoPreviosInternos',
		component: () => import('./pages/Encargado/PreviosInternos.vue'),
		meta: { layout: 'SignedLayout' },
	},

	// Docente Routes
	{
		path: '/docente/punto-tesis',
		name: 'DocentePuntoTesis',
		component: () => import('./pages/Docente/PuntoTesis.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/docente/curso-1',
		name: 'DocenteCurso1',
		component: () => import('./pages/Docente/Curso1.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/docente/curso-2',
		name: 'DocenteCurso2',
		component: () => import('./pages/Docente/Curso2.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/docente/comision-estilos',
		name: 'DocenteComisionEstilos',
		component: () => import('./pages/Docente/ComisionEstilos.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/docente/previos-internos',
		name: 'DocentePreviosInternos',
		component: () => import('./pages/Docente/PreviosInternos.vue'),
		meta: { layout: 'SignedLayout' },
	},

	// Estudiante Routes
	{
		path: '/estudiante/punto-tesis',
		name: 'EstudiantePuntoTesis',
		component: () => import('./pages/Estudiante/PuntoTesis.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/estudiante/curso-1',
		name: 'EstudianteCurso1',
		component: () => import('./pages/Estudiante/Curso1.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/estudiante/curso-2',
		name: 'EstudianteCurso2',
		component: () => import('./pages/Estudiante/Curso2.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/estudiante/comision-estilos',
		name: 'EstudianteComisionEstilos',
		component: () => import('./pages/Estudiante/ComisionEstilos.vue'),
		meta: { layout: 'SignedLayout' },
	},
	{
		path: '/estudiante/previos-internos',
		name: 'EstudiantePreviosInternos',
		component: () => import('./pages/Estudiante/PreviosInternos.vue'),
		meta: { layout: 'SignedLayout' },
	},

	// Progreso Route
	{
		path: '/progreso',
		name: 'Progreso',
		component: () => import('./pages/Progreso.vue'),
		meta: { layout: 'SignedLayout' },
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes,
});

export default router;
