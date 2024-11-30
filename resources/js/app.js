import './bootstrap';
import { createApp } from 'vue';
import HomeView from './Views/HomeView.vue';

const app = createApp({});

const files = require.context('./Views', true, /\.vue$/i)
files.keys().map(key => app.component(key.split('/').pop().split('.')[0], files(key).default))

app.mount('#app');