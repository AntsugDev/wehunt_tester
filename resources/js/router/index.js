import {createRouter, createWebHistory} from "vue-router";
import Home from "../component/Home.vue";
import Login from "../component/Login/Login.vue";
import ErrorPage from "../component/Login/ErrorPage.vue";

export const router = createRouter({
    history: createWebHistory(),
    routes:[
        {
            path:'/login',
            name: 'Login',
            meta: {requiresNoAuth: true},
            component: Login,
            children:[]
        },
        {
            path:'/error',
            name: 'Error',
            component: ErrorPage,
            meta: {requiresNoAuth: true},
            children:[]
        },
        {
            path:'/',
            name: 'Home',
            component: Home,
            meta: {requiresAuth: true},
            children:[
            ]
        },
        {
            path: '/:pathMatch(.*)*',
            redirect: '/login',
        }
    ]
})


