import { createApp } from 'vue';
import App from './App.vue';
import vuetify from './plugins/vuetify';
import router from './router';
import './style.css';
import { createPinia } from 'pinia';
import { useAuthStore } from './store/auth';

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.use(vuetify);

const auth = useAuthStore();
auth.loadFromLocalStorage();

app.mount('#app');
