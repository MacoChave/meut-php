import '@mdi/font/css/materialdesignicons.css';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

export default createVuetify({
	components,
	directives,
	icons: {
		defaultSet: 'mdi',
	},
	theme: {
		defaultTheme: 'light',
		themes: {
			light: {
				colors: {
					primary: '#00225b',
					secondary: '#ff0000',
					accent: '#447cff',
					error: '#ff0000',
					info: '#271343',
					success: '#4bb543',
					warning: '#ffb7b7',
				},
			},
		},
	},
});
