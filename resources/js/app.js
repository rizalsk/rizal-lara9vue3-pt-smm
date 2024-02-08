import './bootstrap';

import { createApp } from 'vue';
import App from '@/layouts/App.vue';
import Router from '@/router';

const app = createApp(App)
app.use(Router)

// app.use(vuetify)
// app.use(store)

// app.component('DataTable', DataTable)
app.mount('#app')