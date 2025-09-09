<template>
  <div
    class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-100 flex items-center justify-center p-4"
  >
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-8 text-center">
        <h1 class="text-3xl font-bold text-white">Create Account</h1>
        <p class="text-indigo-200 mt-2">Join our learning platform today</p>
      </div>

      <div class="p-8">
        <form @submit.prevent="handleRegister">
          <div class="mb-6">
            <label for="name" class="block text-gray-700 font-medium mb-2"
              >Full Name</label
            >
            <input
              id="name"
              v-model="form.name"
              type="text"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="John Doe"
              required
            />
            <div v-if="errors.name" class="text-red-500 text-sm mt-1">
              {{ errors.name }}
            </div>
          </div>

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

          <div class="mb-6">
            <label
              for="password_confirmation"
              class="block text-gray-700 font-medium mb-2"
              >Confirm Password</label
            >
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="••••••••"
              required
            />
            <div v-if="errors.password_confirmation" class="text-red-500 text-sm mt-1">
              {{ errors.password_confirmation }}
            </div>
          </div>

          <div v-if="registerError" class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg">
            {{ registerError }}
          </div>

          <div
            v-if="registerSuccess"
            class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg"
          >
            {{ registerSuccess }}
          </div>

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
              Creating account...
            </span>
            <span v-else>Create Account</span>
          </button>
        </form>

        <div class="mt-6 text-center">
          <p class="text-gray-600">
            Already have an account?
            <router-link
              to="/login"
              class="text-indigo-600 hover:text-indigo-800 font-medium"
              >Sign in</router-link
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
    name: "Register",
    setup() {
      const router = useRouter();
      const isLoading = ref(false);
      const registerError = ref("");
      const registerSuccess = ref("");
      const csrfToken = ref("");

      const form = reactive({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      });

      const errors = reactive({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      });

      // Get CSRF token when component is mounted
      onMounted(() => {
        getCsrfToken();
      });

      // Function to get CSRF token from Laravel
      const getCsrfToken = async () => {
        try {
          const response = await fetch("/csrf-token");
          const data = await response.json();
          csrfToken.value = data.token;
        } catch (error) {
          console.error("Error getting CSRF token:", error);
          // Fallback to meta tag
          const metaTag = document.querySelector('meta[name="csrf-token"]');
          csrfToken.value = metaTag ? metaTag.getAttribute("content") : "";
        }
      };

      const handleRegister = async () => {
        // Reset errors
        errors.name = "";
        errors.email = "";
        errors.password = "";
        errors.password_confirmation = "";
        registerError.value = "";
        registerSuccess.value = "";

        // Validate form
        let isValid = true;

        if (!form.name) {
          errors.name = "Name is required";
          isValid = false;
        }

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
        } else if (form.password.length < 8) {
          errors.password = "Password must be at least 8 characters";
          isValid = false;
        }

        if (!form.password_confirmation) {
          errors.password_confirmation = "Password confirmation is required";
          isValid = false;
        } else if (form.password !== form.password_confirmation) {
          errors.password_confirmation = "Passwords do not match";
          isValid = false;
        }

        if (!isValid) return;

        isLoading.value = true;

        try {
          const response = await fetch("/register", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
              "X-Requested-With": "XMLHttpRequest",
              "X-CSRF-TOKEN": csrfToken.value,
            },
            body: JSON.stringify({
              name: form.name,
              email: form.email,
              password: form.password,
              password_confirmation: form.password_confirmation,
            }),
          });

          const data = await response.json();

          if (response.ok) {
            // Show success message
            registerSuccess.value =
              "Registration successful! Please wait for admin approval.";

            // Clear form
            form.name = "";
            form.email = "";
            form.password = "";
            form.password_confirmation = "";

            // Redirect to login page after a delay
            setTimeout(() => {
              router.push("/login");
            }, 3000);
          } else {
            // Handle validation errors
            if (data.errors) {
              if (data.errors.email) {
                errors.email = data.errors.email[0];
              }
              if (data.errors.name) {
                errors.name = data.errors.name[0];
              }
              if (data.errors.password) {
                errors.password = data.errors.password[0];
              }
            }

            // Show error message
            registerError.value =
              data.message || "Registration failed. Please try again.";
          }
        } catch (error) {
          console.error("Registration error:", error);
          registerError.value = "An error occurred. Please try again later.";
        } finally {
          isLoading.value = false;
        }
      };

      return {
        form,
        errors,
        isLoading,
        registerError,
        registerSuccess,
        handleRegister,
      };
    },
  };
</script>

<style>
  body {
    font-family: "Inter", Arial, sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
  }

  .card {
    background: white;
    padding: 32px;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    width: 400px;
    animation: fadeIn 0.5s ease-in-out;
  }

  h2 {
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: 700;
    color: #111827;
    text-align: center;
  }

  input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    margin-bottom: 14px;
    font-size: 15px;
    transition: 0.2s;
  }

  input:focus {
    border-color: #6366f1;
    outline: none;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
  }

  button {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    background: #6366f1;
    color: white;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: 0.2s;
  }

  button:hover {
    background: #4f46e5;
  }

  .muted {
    color: #6b7280;
    font-size: 14px;
    margin-top: 15px;
    text-align: center;
  }

  .muted a {
    color: #6366f1;
    text-decoration: none;
    font-weight: 600;
  }

  .alert {
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 14px;
    font-size: 14px;
    text-align: center;
  }

  .success {
    background: #ecfdf5;
    color: #065f46;
  }

  .error {
    background: #fee2e2;
    color: #991b1b;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>
