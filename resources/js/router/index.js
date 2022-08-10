import { createRouter, createWebHistory } from "vue-router";
import TokenService from "../services/TokenService";


const Login = () => import("../Pages/Login.vue");
const Dashboard = () => import("../Pages/Dashboard.vue");
const Chat = () => import("../Pages/Chat.vue");
const NotFound = () => import("../Pages/NotFound.vue");

const routes = [
    {
        path: "/",
        name: "Dashboard",
        component: Dashboard,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/chat",
        name: "Chat",
        component: Chat,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: NotFound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return (
            savedPosition ||
            new Promise((resolve) => {
                setTimeout(
                    () =>
                        resolve({
                            top: 0,
                            behavior: "smooth",
                        }),
                    300
                );
            })
        );
    },
});

// navigation guard for authentication and authorization
router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !TokenService.getAccessToken()) {
        // need to login if not already logged in
        return {
            name: "Login",
            query: {
                redirect: to.fullPath,
            },
        };
    }
});

export default router;
