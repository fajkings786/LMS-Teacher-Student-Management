import axios from "axios";
import router from "../router";

// Create axios instance
const api = axios.create({
    baseURL: "/",
    withCredentials: true, // Important for session authentication
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
    },
});

// Function to get CSRF cookie
const getCsrfToken = async () => {
    try {
        // Make a request to get CSRF cookie
        await api.get("/sanctum/csrf-cookie");
        return true;
    } catch (error) {
        console.error("Error getting CSRF token:", error);
        return false;
    }
};

// Request interceptor to add auth token
api.interceptors.request.use(
    async (config) => {
        // Always get CSRF token first for any request
        await getCsrfToken();
        
        // Add auth token if available
        const token = localStorage.getItem("userToken");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        
        // Ensure credentials are included
        config.withCredentials = true;
        
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Response interceptor to handle auth errors
api.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        if (error.response && error.response.status === 401) {
            // Clear token and redirect to login
            localStorage.removeItem("userToken");
            localStorage.removeItem("userData");
            router.push("/Login");
        }
        return Promise.reject(error);
    }
);

export { api, getCsrfToken };