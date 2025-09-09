<template>
  <div class="auth-wrapper">
    <div class="card">
      <h2 class="title">📩 Forgot Password</h2>

      <form @submit.prevent="sendOtp">
        <div v-if="message" :class="['alert', success ? 'success' : 'error']">
          {{ message }}
        </div>

        <div class="input-group">
          <input v-model="email" type="email" placeholder="Enter your email" required />
        </div>

        <button type="submit" class="btn" :disabled="loading">
          <span v-if="loading">⏳ Sending...</span>
          <span v-else>Send OTP</span>
        </button>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        email: "",
        message: "",
        success: false,
        loading: false,
      };
    },
    methods: {
      async sendOtp() {
        this.message = "";
        this.success = false;
        this.loading = true;

        const token = document.querySelector('meta[name="csrf-token"]').content;

        try {
          let res = await fetch("/forgot-password", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
              "X-CSRF-TOKEN": token,
            },
            body: JSON.stringify({ email: this.email }),
          });

          let data = await res.json();
          if (!res.ok) throw data;

          this.message = data.message;
          this.success = true;

          if (data.redirect) {
            setTimeout(() => {
              window.location.href = data.redirect;
            }, 1200);
          }
        } catch (err) {
          this.message = err.error || "Something went wrong ❌";
        } finally {
          this.loading = false;
        }
      },
    },
  };
</script>

<style scoped>
  /* Background */
  .auth-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #3b82f6, #9333ea);
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  }

  /* Card */
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
    color: #3b82f6;
    font-size: 1.6rem;
    font-weight: 700;
  }

  /* Input field */
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
    border-color: #3b82f6;
    box-shadow: 0px 0px 6px rgba(59, 130, 246, 0.4);
  }

  /* Alerts */
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

  /* Button */
  .btn {
    background: #3b82f6;
    color: white;
    padding: 12px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    width: 100%;
    font-weight: 600;
    transition: background 0.3s ease, transform 0.2s ease;
  }
  .btn:hover {
    background: #2563eb;
    transform: translateY(-2px);
  }
  .btn:disabled {
    background: #9ca3af;
    cursor: not-allowed;
  }
  .btn:active {
    transform: translateY(0);
  }

  /* Animation */
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
