import { createApp } from "vue";
import Navbar from "./components/Navbar.vue";
const navbarApp = createApp(Navbar);
if (window.userData) {
    navbarApp.provide("userProfile", window.userData);
}
navbarApp.mount("#navbar-app");
