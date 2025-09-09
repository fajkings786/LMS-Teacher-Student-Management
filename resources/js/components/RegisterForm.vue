<template>
  <div class="auth-wrapper">
    <div class="card">
      <h2>Create Account</h2>
      <form @submit.prevent="submit">
        <div v-if="message" :class="['alert', success ? 'success' : 'error']">
          {{ message }}
        </div>

        <input v-model="name" type="text" placeholder="Full name" required />
        <input v-model="email" type="email" placeholder="Email" required />
        <input
          v-model="password"
          type="password"
          placeholder="Password"
          required
          minlength="6"
        />

        <button type="submit" :disabled="loading">
          <span v-if="loading">Sending...</span>
          <span v-else>Register</span>
        </button>
      </form>
      <div class="muted">
        Already registered? <RouterLink to="/login">Login</RouterLink>
        <br />
        <a href="/forgot-password" class="forgot-link">Forgot Password?</a>
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

        const token = document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content");

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
  /* Fullscreen center wrapper */
  .auth-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #6366f1, #3b82f6);
    padding: 20px;
  }

  /* Card styling */
  .card {
    background: white;
    padding: 32px;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    width: 400px;
    animation: fadeIn 0.5s ease-in-out;
  }

  h2 {
    margin-bottom: 20px;
    text-align: center;
    font-weight: 700;
    color: #111827;
  }

  /* Inputs + Button */
  input,
  button {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 14px;
    font-size: 15px;
  }

  input {
    border: 1px solid #d1d5db;
    transition: 0.2s;
  }
  input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    outline: none;
  }

  button {
    background: #6366f1;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    border: none;
  }
  button:hover {
    background: #4f46e5;
  }
  button:disabled {
    background: #9ca3af;
    cursor: not-allowed;
  }

  /* Muted text */
  .muted {
    color: #6b7280;
    font-size: 14px;
    text-align: center;
    margin-top: 15px;
  }
  .muted a {
    color: #6366f1;
    text-decoration: none;
    font-weight: 600;
  }

  /* Alerts */
  .alert {
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 14px;
    text-align: center;
    font-size: 14px;
  }
  .success {
    background: #ecfdf5;
    color: #065f46;
  }
  .error {
    background: #fee2e2;
    color: #991b1b;
  }

  /* Animation */
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
