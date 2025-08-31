import { createRouter, createWebHistory } from 'vue-router';
import Home from './pages/Home/Home.vue';
import Login from './pages/Sesion/Login.vue';
import Logup from './pages/Sesion/Logup.vue';

const routes = [
	{ path: '/', name: 'Home', component: Home },
	{ path: '/login', name: 'Login', component: Login },
	{ path: '/logup', name: 'Logup', component: Logup },
	{ path: '/:pathMatch(.*)*', redirect: '/' },
];

const router = createRouter({
	history: createWebHistory(),
	routes,
});

export default router;
