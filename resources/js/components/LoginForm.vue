<template>
  <div class="login-form">
    <h2>Login</h2>
    <div v-if="error" class="error-message">{{ error }}</div>
    <form @submit.prevent="handleLogin">
      <input type="hidden" name="_token" :value="csrfToken" />
      <div class="form-group">
        <label for="email">Email</label>
        <input
          type="email"
          id="email"
          v-model="form.email"
          required
          placeholder="Enter your email"
        />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input
          type="password"
          id="password"
          v-model="form.password"
          required
          placeholder="Enter your password"
        />
      </div>
      <div class="form-actions">
        <button type="submit" :disabled="loading">
          {{ loading ? "Logging in..." : "Login" }}
        </button>
        <router-link to="/forgot-password" class="forgot-password">
          Forgot Password?
        </router-link>
      </div>
    </form>
    <div class="signup-link">
      Don't have an account? <router-link to="/signup">Sign up</router-link>
    </div>
  </div>
</template>

<script>
  import { reactive, ref, onMounted } from "vue";
  import { useRouter } from "vue-router";

  export default {
    name: "LoginForm",
    setup() {
      const router = useRouter();
      const form = reactive({
        email: "",
        password: "",
      });
      const error = ref(null);
      const loading = ref(false);
      const csrfToken = ref("");

      // Get CSRF token on component mount
      onMounted(async () => {
        try {
          // First get CSRF cookie
          await fetch("/sanctum/csrf-cookie", {
            credentials: "include",
          });

          // Get the CSRF token from the meta tag
          csrfToken.value =
            document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") ||
            "";
        } catch (e) {
          console.error("Failed to get CSRF token:", e);
        }
      });

      const handleLogin = async () => {
        loading.value = true;
        error.value = null;

        try {
          // Get CSRF token again to ensure it's fresh
          await fetch("/sanctum/csrf-cookie", {
            credentials: "include",
          });

          // Get the fresh CSRF token
          const freshCsrfToken =
            document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") ||
            "";

          // Login using web route
          const response = await fetch("/login", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
              "X-Requested-With": "XMLHttpRequest",
              "X-CSRF-TOKEN": freshCsrfToken,
            },
            credentials: "include",
            body: JSON.stringify(form),
          });

          const data = await response.json();

          if (response.ok) {
            // Store user data in localStorage
            localStorage.setItem("userData", JSON.stringify(data.user));

            // Dispatch event for other components
            window.dispatchEvent(new CustomEvent("userLoggedIn", { detail: data.user }));

            // Navigate to dashboard
            window.location.href = data.redirect; // This should now be '/dashboard'
          } else {
            error.value = data.error || "Login failed Please reload again ";
          }
        } catch (err) {
          console.error("Login error:", err);
          error.value = "An error occurred. Please try again.";
        } finally {
          loading.value = false;
        }
      };

      return {
        form,
        error,
        loading,
        csrfToken,
        handleLogin,
      };
    },
  };
</script>

<style scoped>
  .login-form {
    max-width: 400px;
    margin: 0 auto;
    padding: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  h2 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: #4f46e5;
  }

  .error-message {
    background: #fee;
    color: #c33;
    padding: 0.75rem;
    border-radius: 4px;
    margin-bottom: 1rem;
    text-align: center;
  }

  .form-group {
    margin-bottom: 1rem;
  }

  label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #4b5563;
  }

  input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    font-size: 1rem;
  }

  input:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
  }

  .form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.5rem;
  }

  button {
    background: #4f46e5;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.2s;
  }

  button:hover {
    background: #4338ca;
  }

  button:disabled {
    background: #a5b4fc;
    cursor: not-allowed;
  }

  .forgot-password {
    color: #4f46e5;
    text-decoration: none;
    font-size: 0.9rem;
  }

  .forgot-password:hover {
    text-decoration: underline;
  }

  .signup-link {
    text-align: center;
    margin-top: 1.5rem;
    color: #6b7280;
  }

  .signup-link a {
    color: #4f46e5;
    text-decoration: none;
    font-weight: 500;
  }

  .signup-link a:hover {
    text-decoration: underline;
  }
</style>
