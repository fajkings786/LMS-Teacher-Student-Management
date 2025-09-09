<template>
  <div class="auth-wrapper">
    <div class="card">
      <h2 class="title">🔑 Reset Password</h2>
      <form @submit.prevent="resetPassword">
        <input type="hidden" name="_token" :value="csrfToken" />
        <input type="hidden" name="email" :value="email" />

        <div class="input-group">
          <input v-model="password" type="password" placeholder="New Password" required />
        </div>

        <div class="input-group">
          <input
            v-model="confirmPassword"
            type="password"
            placeholder="Confirm Password"
            required
          />
        </div>

        <div v-if="message" :class="['alert', success ? 'success' : 'error']">
          {{ message }}
        </div>

        <button type="submit" class="btn" :disabled="loading">
          {{ loading ? "Processing..." : "Update Password" }}
        </button>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        password: "",
        confirmPassword: "",
        message: "",
        success: false,
        email: "",
        csrfToken:
          document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") ||
          "",
        loading: false,
      };
    },
    methods: {
      async resetPassword() {
        if (this.password !== this.confirmPassword) {
          this.message = "Passwords do not match ❌";
          this.success = false;
          return;
        }

        if (this.password.length < 6) {
          this.message = "Password must be at least 6 characters ❌";
          this.success = false;
          return;
        }

        this.loading = true;

        try {
          const formData = new FormData();
          formData.append("_token", this.csrfToken);
          formData.append("password", this.password);
          formData.append("password_confirmation", this.confirmPassword);
          formData.append("email", this.email);

          let res = await fetch("/reset-password", {
            method: "POST",
            headers: {
              "X-Requested-With": "XMLHttpRequest",
              Accept: "application/json",
            },
            body: formData,
            credentials: "same-origin",
          });

          const data = await res.json();

          if (!res.ok) {
            // Handle validation errors
            if (res.status === 422 && data.errors) {
              let errorMsg = "";
              for (const field in data.errors) {
                errorMsg += data.errors[field].join(" ") + " ";
              }
              throw new Error(errorMsg);
            }
            throw new Error(data.error || "Failed to reset password");
          }

          this.message = data.message;
          this.success = true;

          setTimeout(() => {
            this.$router.push("/login");
          }, 1500);
        } catch (err) {
          console.error("Reset password error:", err);
          this.message = err.message || "Something went wrong ❌";
          this.success = false;
        } finally {
          this.loading = false;
        }
      },
    },
    mounted() {
      // Get email from URL parameters
      const urlParams = new URLSearchParams(window.location.search);
      this.email = urlParams.get("email") || "";

      if (!this.email) {
        this.message =
          "Email is required. Please start the password reset process again.";
        this.success = false;
      }

      // Check CSRF token
      if (!this.csrfToken) {
        console.error("CSRF token not found");
        this.message = "Security token missing. Please refresh the page.";
        this.success = false;
      }
    },
  };
</script>

<style scoped>
  /* Styles remain the same */
  .auth-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #4f46e5, #9333ea);
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  }

  .card {
    background: #fff;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 400px;
    text-align: center;
    animation: fadeIn 0.6s ease-in-out;
  }

  .title {
    margin-bottom: 1.5rem;
    color: #4f46e5;
    font-size: 1.6rem;
    font-weight: 700;
  }

  .input-group {
    margin-bottom: 1rem;
  }

  input {
    width: 100%;
    padding: 12px 14px;
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    outline: none;
    font-size: 14px;
    transition: all 0.3s ease;
  }

  input:focus {
    border-color: #4f46e5;
    box-shadow: 0px 0px 6px rgba(79, 70, 229, 0.4);
  }

  .alert {
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 1rem;
    font-size: 14px;
  }

  .alert.success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #22c55e;
  }

  .alert.error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #ef4444;
  }

  .btn {
    background: #4f46e5;
    color: white;
    padding: 12px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    width: 100%;
    font-weight: 600;
    transition: background 0.3s ease, transform 0.2s ease;
  }

  .btn:hover:not(:disabled) {
    background: #4338ca;
    transform: translateY(-2px);
  }

  .btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(15px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>
