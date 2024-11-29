import {createRouter, createWebHistory} from "vue-router";
import Home from "../component/Home.vue";
import Login from "../component/Login/Login.vue";
import ErrorPage from "../component/Login/ErrorPage.vue";
import IndexList from "../component/List/IndexList.vue";

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
                {
                    path:'/list',
                    name: 'IndexList',
                    component: IndexList,
                    children:[]
                },
            ]
        },
        {
            path: '/:pathMatch(.*)*',
            redirect: '/login',
        }
    ]
})


