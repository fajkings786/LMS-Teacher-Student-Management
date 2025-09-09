<template>
  <div
    class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-100 flex items-center justify-center p-4"
  >
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-8 text-center">
        <h1 class="text-3xl font-bold text-white">Welcome Back</h1>
        <p class="text-indigo-200 mt-2">Sign in to your account</p>
      </div>

      <div class="p-8">
        <form @submit.prevent="handleLogin">
          <!-- Email -->
          <div class="mb-6">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="your@email.com"
              required
            />
            <div v-if="errors.email" class="text-red-500 text-sm mt-1">
              {{ errors.email }}
            </div>
          </div>

          <!-- Password -->
          <div class="mb-6">
            <label for="password" class="block text-gray-700 font-medium mb-2"
              >Password</label
            >
            <input
              id="password"
              v-model="form.password"
              type="password"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="••••••••"
              required
            />
            <div v-if="errors.password" class="text-red-500 text-sm mt-1">
              {{ errors.password }}
            </div>
          </div>

          <!-- Remember + Forgot -->
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
              <input
                id="remember"
                v-model="form.remember"
                type="checkbox"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
              />
              <label for="remember" class="ml-2 block text-sm text-gray-700"
                >Remember me</label
              >
            </div>
            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800"
              >Forgot password?</a
            >
          </div>

          <!-- Error -->
          <div v-if="loginError" class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg">
            {{ loginError }}
          </div>

          <!-- Success -->
          <div v-if="loginSuccess" class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg">
            {{ loginSuccess }}
          </div>

          <!-- Button -->
          <button
            type="submit"
            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium py-3 px-4 rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all"
            :disabled="isLoading"
          >
            <span v-if="isLoading" class="flex items-center justify-center">
              <svg
                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
              Signing in...
            </span>
            <span v-else>Sign In</span>
          </button>
        </form>

        <div class="mt-6 text-center">
          <p class="text-gray-600">
            Don't have an account?
            <router-link
              to="/signup"
              class="text-indigo-600 hover:text-indigo-800 font-medium"
              >Sign up</router-link
            >
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { ref, reactive, onMounted } from "vue";
  import { useRouter } from "vue-router";

  export default {
    name: "Login",
    setup() {
      const router = useRouter();
      const isLoading = ref(false);
      const loginError = ref("");
      const loginSuccess = ref("");
      const csrfToken = ref("");

      const form = reactive({
        email: "",
        password: "",
        remember: false,
      });

      const errors = reactive({
        email: "",
        password: "",
      });

      // Get CSRF token on mount
      onMounted(() => {
        getCsrfToken();
      });

      const getCsrfToken = async () => {
        try {
          const response = await fetch("/csrf-token");
          const data = await response.json();
          csrfToken.value = data.token;
        } catch (error) {
          console.error("Error getting CSRF token:", error);
          const metaTag = document.querySelector('meta[name="csrf-token"]');
          csrfToken.value = metaTag ? metaTag.getAttribute("content") : "";
        }
      };

      const handleLogin = async () => {
        // Reset
        errors.email = "";
        errors.password = "";
        loginError.value = "";
        loginSuccess.value = "";

        let isValid = true;
        if (!form.email) {
          errors.email = "Email is required";
          isValid = false;
        } else if (!/\S+@\S+\.\S+/.test(form.email)) {
          errors.email = "Email is invalid";
          isValid = false;
        }
        if (!form.password) {
          errors.password = "Password is required";
          isValid = false;
        }
        if (!isValid) return;

        isLoading.value = true;

        try {
          const response = await fetch("/login", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
              "X-Requested-With": "XMLHttpRequest",
              "X-CSRF-TOKEN": csrfToken.value,
            },
            body: JSON.stringify({
              email: form.email,
              password: form.password,
            }),
          });

          const data = await response.json();

          if (response.ok) {
            // Store token + user info
            localStorage.setItem("userToken", data.token);
            localStorage.setItem("userData", JSON.stringify(data.user));

            if (data.user.role === "Admin" || data.user.status === "approved") {
              loginSuccess.value = "Login successful! Redirecting...";
              setTimeout(() => {
                router.push("/dashboard");
              }, 1500);
            } else {
              loginError.value = "Your account is pending admin approval.";
              localStorage.removeItem("userToken");
              localStorage.removeItem("userData");
            }
          } else {
            loginError.value =
              data.error || "Login failed. Please check your credentials.";
          }
        } catch (error) {
          console.error("Login error:", error);
          loginError.value = "An error occurred. Please try again later.";
        } finally {
          isLoading.value = false;
        }
      };

      return {
        form,
        errors,
        isLoading,
        loginError,
        loginSuccess,
        handleLogin,
      };
    },
  };
</script>

<style>
  body {
    font-family: Inter, Arial;
    background: #f6f8fb;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
  }

  .card {
    background: white;
    padding: 28px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(20, 20, 50, 0.06);
    width: 420px;
  }

  h2 {
    margin-bottom: 18px;
    font-size: 22px;
    font-weight: 700;
    color: #111827;
    text-align: center;
  }

  input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #e6e9ef;
    margin-bottom: 12px;
  }

  button {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 0;
    background: #10b981;
    color: white;
    font-weight: 600;
    cursor: pointer;
  }

  button:hover {
    background: #059669;
  }

  .muted {
    color: #6b7280;
    font-size: 14px;
    margin-top: 10px;
    text-align: center;
  }

  .alert {
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 12px;
    font-size: 14px;
  }

  .error {
    background: #ffefef;
    color: #772020;
  }

  .success {
    background: #ecfdf5;
    color: #065f46;
  }
</style>
