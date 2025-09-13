<template>
  <div class="auth-wrapper">
    <!-- Full-page loader overlay -->
    <div v-if="loading" class="loader-overlay">
      <div class="loader-container">
        <div class="loader-spinner"></div>
        <p class="loader-text">Creating Account...</p>
      </div>
    </div>

    <div class="auth-container">
      <div class="auth-card">
        <div class="auth-header">
          <div class="auth-icon"></div>
          <h2 class="auth-title">Create Account</h2>
          <p class="auth-subtitle">Join us today and start your journey</p>
        </div>

        <form @submit.prevent="submit" class="auth-form">
          <div v-if="message" :class="['alert', success ? 'success' : 'error']">
            <span class="alert-icon">{{ success ? "✓" : "⚠" }}</span>
            {{ message }}
          </div>

          <div class="input-group">
            <div class="input-icon">👤</div>
            <input
              v-model="name"
              type="text"
              placeholder="Full name"
              required
              class="auth-input"
            />
          </div>

          <div class="input-group">
            <div class="input-icon">✉️</div>
            <input
              v-model="email"
              type="email"
              placeholder="Email"
              required
              class="auth-input"
            />
          </div>

          <div class="input-group">
            <div class="input-icon">🔒</div>
            <input
              v-model="password"
              type="password"
              placeholder="Password"
              required
              minlength="6"
              class="auth-input"
            />
          </div>

          <button type="submit" class="auth-button" :disabled="loading">
            <span v-if="loading" class="button-spinner"></span>
            <span v-else>Create Account</span>
          </button>
        </form>

        <div class="auth-footer">
          <p class="login-text">
            Already registered?
            <RouterLink to="/login" class="login-link">Login</RouterLink>
          </p>
          <a href="/forgot-password" class="forgot-link">Forgot Password?</a>
        </div>
      </div>

      <div class="auth-info">
        <div class="info-item">
          <div class="info-icon">✅</div>
          <div class="info-content">
            <div class="info-title">Quick Registration</div>
            <div class="info-desc">Create your account in less than a minute</div>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon">🔒</div>
          <div class="info-content">
            <div class="info-title">Secure & Private</div>
            <div class="info-desc">
              Your data is protected with industry-leading security
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        name: "",
        email: "",
        password: "",
        message: "",
        success: false,
        loading: false,
      };
    },
    methods: {
      async submit() {
        this.message = "";
        this.success = false;
        this.loading = true;

        // Check if CSRF token meta tag exists before trying to access it
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        if (!csrfTokenMeta) {
          this.message =
            "Security token not found. Please refresh the page and try again.";
          this.success = false;
          this.loading = false;
          return;
        }

        const token = csrfTokenMeta.getAttribute("content");

        try {
          let res = await fetch("/register", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
              "X-CSRF-TOKEN": token,
            },
            body: JSON.stringify({
              name: this.name,
              email: this.email,
              password: this.password,
            }),
          });
          let data = await res.json();
          if (!res.ok) throw data;
          this.message = data.message || "Request sent to Admin";
          this.success = true;
          this.name = this.email = this.password = "";
          if (data.redirect) {
            setTimeout(() => {
              window.location.href = data.redirect;
            }, 1500);
          }
        } catch (err) {
          this.message = err.message || err.error || "Something went wrong ❌";
          this.success = false;
        } finally {
          this.loading = false;
        }
      },
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
    padding: 20px;
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
    background: radial-gradient(
      circle,
      rgba(255, 255, 255, 0.1) 0%,
      rgba(255, 255, 255, 0) 70%
    );
    animation: pulse 15s infinite ease-in-out;
  }

  @keyframes pulse {
    0% {
      transform: scale(0.8);
      opacity: 0.5;
    }
    50% {
      transform: scale(1.2);
      opacity: 0.8;
    }
    100% {
      transform: scale(0.8);
      opacity: 0.5;
    }
  }

  /* Full-page loader overlay */
  .loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10000;
    backdrop-filter: blur(5px);
  }

  .loader-container {
    text-align: center;
    padding: 30px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
  }

  .loader-spinner {
    width: 60px;
    height: 60px;
    border: 5px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
  }

  .loader-text {
    color: #fff;
    font-size: 18px;
    font-weight: 500;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }

  .auth-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px;
    width: 100%;
    max-width: 450px;
    z-index: 1;
  }

  .auth-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    padding: 40px 30px;
    width: 100%;
    animation: fadeIn 0.6s ease-out;
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

  .auth-header {
    text-align: center;
    margin-bottom: 30px;
  }

  .auth-icon {
    font-size: 64px;
    margin-bottom: 15px;
    animation: bounce 2s infinite;
  }

  @keyframes bounce {
    0%,
    100% {
      transform: translateY(0);
    }
    50% {
      transform: translateY(-10px);
    }
  }

  .auth-title {
    font-size: 28px;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
  }

  .auth-subtitle {
    font-size: 16px;
    color: #666;
    margin: 0;
  }

  .auth-form {
    margin-bottom: 25px;
  }

  .alert {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 14px;
    animation: slideDown 0.3s ease-out;
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .alert-icon {
    margin-right: 8px;
    font-size: 16px;
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

  .input-group {
    position: relative;
    margin-bottom: 20px;
  }

  .input-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    color: #667eea;
    z-index: 1;
  }

  .auth-input {
    width: 100%;
    padding: 15px 15px 15px 50px;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    font-size: 16px;
    color: #333;
    background: #f9fafb;
    transition: all 0.3s ease;
  }

  .auth-input:focus {
    outline: none;
    border-color: #667eea;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
  }

  .auth-button {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    margin-top: 10px;
  }

  .auth-button::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    transition: all 0.5s ease;
  }

  .auth-button:hover::before {
    left: 100%;
  }

  .auth-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
  }

  .auth-button:disabled {
    background: #a5b4fc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
  }

  .button-spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 0.8s linear infinite;
    margin-right: 8px;
  }

  .auth-footer {
    text-align: center;
  }

  .login-text {
    font-size: 14px;
    color: #666;
    margin-bottom: 10px;
  }

  .login-link {
    color: #667eea;
    font-weight: 600;
    text-decoration: none;
    position: relative;
    transition: color 0.3s ease;
  }

  .login-link::after {
    content: "";
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: #667eea;
    transition: width 0.3s ease;
  }

  .login-link:hover {
    color: #764ba2;
  }

  .login-link:hover::after {
    width: 100%;
  }

  .forgot-link {
    color: #667eea;
    font-size: 14px;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
  }

  .forgot-link:hover {
    color: #764ba2;
    text-decoration: underline;
  }

  .auth-info {
    width: 100%;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  }

  .info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
  }

  .info-item:last-child {
    margin-bottom: 0;
  }

  .info-icon {
    font-size: 24px;
    margin-right: 15px;
    flex-shrink: 0;
  }

  .info-content {
    text-align: left;
  }

  .info-title {
    font-weight: 600;
    font-size: 16px;
    color: #333;
    margin-bottom: 5px;
  }

  .info-desc {
    font-size: 14px;
    color: #666;
  }

  @media (max-width: 480px) {
    .auth-card {
      padding: 30px 20px;
    }

    .auth-title {
      font-size: 24px;
    }

    .auth-input {
      padding: 12px 12px 12px 45px;
    }

    .loader-spinner {
      width: 50px;
      height: 50px;
    }

    .loader-text {
      font-size: 16px;
    }
  }
</style>
