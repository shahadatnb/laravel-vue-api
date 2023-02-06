require('./bootstrap');

import { createApp } from 'vue';
import router from './router';
import axios from 'axios';
import store from './store';

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000/';
axios.defaults.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

import App from './components/App.vue';

store.dispatch('getUser').then( ()=> {
    const app = createApp(App)
    app.use(router);
    app.use(store);
    app.mount('#app');
});
