import { createRouter, createWebHistory } from "vue-router";
// Pages
import Home from "../pages/Home.vue";
import About from "../pages/About.vue";
import Lectures from "../pages/Lectures.vue";
import Signup from "../pages/Signup.vue";
import LoginForm from "../components/LoginForm.vue";
import RegisterForm from "../components/RegisterForm.vue";
import ForgotPassword from "../components/ForgotPassword.vue";
import VerifyOtp from "../components/VerifyOtp.vue";
import ResetPassword from "../components/ResetPassword.vue";
import Course from "../pages/Course.vue";
import CreateCourse from "../pages/CreateCourse.vue";
import Contact from "../pages/Contact.vue";

const routes = [
    { path: "/", name: "home", component: Home },
    { path: "/about", name: "about", component: About },
    { path: "/lectures", name: "lectures", component: Lectures },
    { path: "/signup", name: "signup", component: Signup },
    { path: "/Login", name: "Login", component: LoginForm },
    { path: "/register", name: "RegisterForm", component: RegisterForm },
    { path: "/Course", name: "Course", component: Course },
    { path: "/courses/create", name: "createCourse", component: CreateCourse },
    { path: "/contact", name: "contact", component: Contact },
    { path: "/courses", name: "courses", component: Lectures },
    {
        path: "/forgot-password",
        name: "ForgotPassword",
        component: ForgotPassword,
    },
    {
        path: "/verify-otp-reset",
        name: "VerifyOtp",
        component: VerifyOtp,
        props: (route) => ({ email: route.query.email }),
    },
    {
        path: "/reset-password-form",
        name: "ResetPassword",
        component: ResetPassword,
        props: (route) => ({ email: route.query.email }),
    },
    // router/index.js
    {
        path: "/dashboard",
        name: "Dashboard",
        beforeEnter: (to, from, next) => {
            // Check if user is logged in
            const isLoggedIn = localStorage.getItem("userData") !== null;

            if (!isLoggedIn) {
                // If not logged in, redirect to login
                next("/Login");
            } else {
                // If logged in, redirect to Laravel dashboard
                window.location.href = "/dashboard";
            }
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (!localStorage.getItem("userToken")) {
            next("/Login");
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
