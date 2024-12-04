import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import ListView from './Views/ListView.vue';
import LoginView from './Views/LoginView.vue';
import MapView from './Views/MapView.vue';

const app = createApp();

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '',
            component: ListView,
            name: 'home',
        },
        {
            path: '/wind-farm/:id',
            component: MapView,
            name: 'wind-farm',
        },
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