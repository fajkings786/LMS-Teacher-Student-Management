import "../css/app.css"; // Tailwind CSS include kiya
import "@fortawesome/fontawesome-free/css/all.css";
import "@fortawesome/fontawesome-free/js/all.js";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { api } from "./utils/axios"; // Import the configured axios instance
import router from "./router";
// Existing components
import RegisterForm from "./components/RegisterForm.vue";
import LoginForm from "./components/LoginForm.vue";
import ForgotPassword from "./components/ForgotPassword.vue";
import VerifyOtp from "./components/VerifyOtp.vue";
import ResetPassword from "./components/ResetPassword.vue";
import App from "./App.vue";

// Set up axios defaults
const token = localStorage.getItem("userToken");
if (token) {
    api.defaults.headers.common["Authorization"] = `Bearer ${token}`;
}

const app = createApp(App);
app.component("register-form", RegisterForm);
app.component("login-form", LoginForm);
app.component("forgot-password", ForgotPassword);
app.component("verify-otp-reset", VerifyOtp);
app.component("resetpassword", ResetPassword);
app.use(router);
app.use(createPinia());
app.mount("#app");