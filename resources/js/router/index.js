import { createWebHistory, createRouter } from 'vue-router'

// const Home = () => import('@/pages/Home.vue');
import Dashboard from '@/pages/Dashboard.vue';
import Welcome from '@/pages/Welcome.vue';
import Permintaan from '@/pages/Permintaan.vue';
import AllTable from '@/pages/AllTable.vue';
import PageNotFound from '@/pages/404.vue';

/* Authenticated Component */
const routes = [
    {
        "name": "dashboard",
        path: "/",
        component: Dashboard,
        meta: {
            title: `Dashboard`
        },
        children:[
            {
                name: 'welcome',
                path: '/',
                component: Welcome,
            },
            {
                name: 'permintaan',
                path: '/permintaans',
                component: Permintaan,
            },
            {
                name: 'all-tables',
                path: '/datas',
                component: AllTable,
            },
        ]
    },
    { 
        path: '/:pathMatch(.*)*', 
        component: PageNotFound,
        meta:{
            title: "Page Not Found"
        }
    },
]
const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router