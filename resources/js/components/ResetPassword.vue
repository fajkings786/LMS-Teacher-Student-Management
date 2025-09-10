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
  .auth-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
    overflow: hidden;
  }
  
  .auth-wrapper::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    animation: pulse 15s infinite ease-in-out;
  }
  
  @keyframes pulse {
    0% { transform: scale(0.8); opacity: 0.5; }
    50% { transform: scale(1.2); opacity: 0.8; }
    100% { transform: scale(0.8); opacity: 0.5; }
  }
  
  .card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 420px;
    text-align: center;
    animation: fadeIn 0.6s ease-out;
    position: relative;
    z-index: 1;
  }
  
  .title {
    margin-bottom: 2rem;
    color: #333;
    font-size: 1.8rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    display: inline-block;
  }
  
  .input-group {
    margin-bottom: 1.5rem;
    position: relative;
  }
  
  input {
    width: 100%;
    padding: 16px 20px;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    outline: none;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #f9fafb;
  }
  
  input:focus {
    border-color: #667eea;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
  }
  
  input::placeholder {
    color: #9ca3af;
  }
  
  .alert {
    padding: 14px 16px;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    font-size: 14px;
    display: flex;
    align-items: center;
    animation: slideDown 0.3s ease-out;
  }
  
  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  .alert::before {
    content: "";
    margin-right: 10px;
    font-size: 16px;
  }
  
  .alert.success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #22c55e;
  }
  
  .alert.success::before {
    content: "✓";
  }
  
  .alert.error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #ef4444;
  }
  
  .alert.error::before {
    content: "⚠";
  }
  
  .btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 16px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    width: 100%;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .btn::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    transition: all 0.5s ease;
  }
  
  .btn:hover:not(:disabled)::before {
    left: 100%;
  }
  
  .btn:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 7px 20px rgba(102, 126, 234, 0.4);
  }
  
  .btn:active:not(:disabled) {
    transform: translateY(-1px);
  }
  
  .btn:disabled {
    background: #a5b4fc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
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
  
  @media (max-width: 480px) {
    .card {
      padding: 2rem;
      max-width: 350px;
    }
    
    .title {
      font-size: 1.6rem;
    }
    
    input {
      padding: 14px 16px;
    }
  }
</style>
