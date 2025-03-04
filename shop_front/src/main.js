import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

const app = createApp(App);
app.use(router);  // подключаем маршрутизатор
app.mount('#app');
import './assets/tailwind.css'
