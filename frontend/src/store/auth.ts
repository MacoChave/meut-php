import { defineStore } from 'pinia';
import type { LoginResponse, MenuItem } from '../models/LoginResponse';

export const useAuthStore = defineStore('auth', {
	state: () => ({
		email: '' as string,
		token: '' as string,
		permissions: {} as Record<string, MenuItem>,
	}),
	actions: {
		setAuth(data: LoginResponse) {
			this.token = data.token;
			this.permissions = data.permissions;
			this.email = data.email;

			localStorage.setItem('ut_meut', JSON.stringify(data));
		},
		loadFromLocalStorage() {
			const raw = localStorage.getItem('ut_meut');
			if (!raw) return;
			const parsed = JSON.parse(raw) as LoginResponse;

			this.token = parsed.token;
			this.permissions = parsed.permissions;
			this.email = parsed.email;
		},
		getEmail() {
			return this.email;
		},
		getToken() {
			return this.token;
		},
		getPermissions() {
			return this.permissions;
		},
		clearAuth() {
			this.token = '';
			this.permissions = {};
			this.email = '';

			localStorage.removeItem('ut_meut');
		},
	},
});
