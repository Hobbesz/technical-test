import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import LoginView from './Views/LoginView.vue';

const app = createApp();

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/login',
            component: LoginView,
            name: 'login',
        },
    ],
});

app.use(router);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => app.component(key.split('/').pop().split('.')[0], files(key).default));

app.mount('#app');