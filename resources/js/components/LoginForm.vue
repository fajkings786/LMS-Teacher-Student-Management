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
    max-width: 450px;
    margin: 0 auto;
    padding: 2.5rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    position: relative;
    overflow: hidden;
    animation: fadeIn 0.6s ease-out;
  }

  .login-form::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  h2 {
    text-align: center;
    margin-bottom: 2rem;
    color: #333;
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    position: relative;
  }

  h2::after {
    content: "";
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 3px;
  }

  .error-message {
    background: #fee2e2;
    color: #991b1b;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    text-align: center;
    font-size: 0.9rem;
    border: 1px solid #fecaca;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: shake 0.5s ease-in-out;
  }

  .error-message::before {
    content: "⚠";
    margin-right: 8px;
    font-size: 1.1rem;
  }

  @keyframes shake {
    0%,
    100% {
      transform: translateX(0);
    }
    10%,
    30%,
    50%,
    70%,
    90% {
      transform: translateX(-5px);
    }
    20%,
    40%,
    60%,
    80% {
      transform: translateX(5px);
    }
  }

  .form-group {
    margin-bottom: 1.5rem;
    position: relative;
  }

  label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #4b5563;
    font-size: 0.95rem;
  }

  input {
    width: 100%;
    padding: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f9fafb;
  }

  input:focus {
    outline: none;
    border-color: #667eea;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
  }

  input::placeholder {
    color: #9ca3af;
  }

  .form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
  }

  button {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    min-width: 120px;
  }

  button::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    transition: all 0.5s ease;
  }

  button:hover::before {
    left: 100%;
  }

  button:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 15px rgba(102, 126, 234, 0.4);
  }

  button:active {
    transform: translateY(0);
  }

  button:disabled {
    background: #a5b4fc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
  }

  .forgot-password {
    color: #667eea;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: color 0.3s ease;
    position: relative;
  }

  .forgot-password::after {
    content: "";
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: #667eea;
    transition: width 0.3s ease;
  }

  .forgot-password:hover {
    color: #764ba2;
  }

  .forgot-password:hover::after {
    width: 100%;
  }

  .signup-link {
    text-align: center;
    margin-top: 2rem;
    color: #6b7280;
    font-size: 0.95rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
  }

  .signup-link a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
  }

  .signup-link a:hover {
    color: #764ba2;
    text-decoration: underline;
  }

  @media (max-width: 480px) {
    .login-form {
      padding: 2rem;
      margin: 0 1rem;
    }

    h2 {
      font-size: 1.8rem;
    }

    .form-actions {
      flex-direction: column;
      gap: 1rem;
    }

    button {
      width: 100%;
    }
  }
</style>
