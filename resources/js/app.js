require('./bootstrap');

import { createApp } from 'vue';
import router from './router';

import ExampleComponent from './components/ExampleComponent.vue';

const app = createApp(ExampleComponent)
app.use(router);

app.mount('#app');