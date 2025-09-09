<template>
  <div class="auth-wrapper">
    <div class="card">
      <h2 class="title">🔑 Verify OTP</h2>
      <form @submit.prevent="verifyOtp">
        <input type="hidden" name="_token" :value="csrfToken" />
        <div class="input-group">
          <input
            v-model="otp"
            type="text"
            placeholder="Enter OTP"
            maxlength="6"
            required
          />
          <input type="hidden" :value="localEmail" />
        </div>
        <div v-if="message" :class="['alert', success ? 'success' : 'error']">
          {{ message }}
        </div>
        <button type="submit" class="btn" :disabled="loading">
          <span v-if="loading">Verifying...</span>
          <span v-else>Verify</span>
        </button>
      </form>
      <div class="resend-link">
        <p>Didn't receive the code?</p>
        <button @click="resendOtp" :disabled="resending" class="link-btn">
          <span v-if="resending">Sending...</span>
          <span v-else>Resend OTP</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["email"],
  data() {
    return {
      otp: "",
      message: "",
      success: false,
      loading: false,
      resending: false,
      localEmail: this.email || "",
      csrfToken:
        document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") ||
        "",
    };
  },
  methods: {
    async verifyOtp() {
      this.loading = true;
      this.message = "";
      
      try {
        const formData = new FormData();
        formData.append("_token", this.csrfToken);
        formData.append("otp", this.otp);
        formData.append("email", this.localEmail);
        
        let res = await fetch("/verify-otp-reset", {
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
          throw new Error(data.message || "Server error");
        }
        
        this.message = data.message;
        this.success = data.success;
        
        if (data.success && data.redirect) {
          setTimeout(() => (window.location.href = data.redirect), 1000);
        }
      } catch (err) {
        console.error("Verification error:", err);
        this.message = err.message || "An error occurred. Please try again.";
        this.success = false;
      } finally {
        this.loading = false;
      }
    },
    
    async resendOtp() {
      this.resending = true;
      this.message = "";
      
      try {
        const formData = new FormData();
        formData.append("_token", this.csrfToken);
        formData.append("email", this.localEmail);
        
        let res = await fetch("/forgot-password", {
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
          throw new Error(data.message || "Server error");
        }
        
        this.message = data.message;
        this.success = true;
      } catch (err) {
        console.error("Resend OTP error:", err);
        this.message = err.message || "An error occurred. Please try again.";
        this.success = false;
      } finally {
        this.resending = false;
      }
    }
  },
  mounted() {
    // Get email from URL if localEmail is empty
    if (!this.localEmail) {
      const urlParams = new URLSearchParams(window.location.search);
      this.localEmail = urlParams.get("email") || "";
    }
    
    // Make sure we have the CSRF token
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
  background: linear-gradient(135deg, #9333ea, #3b82f6);
}
.card {
  background: #fff;
  padding: 2rem;
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  max-width: 360px;
  text-align: center;
}
.title {
  margin-bottom: 1.5rem;
  color: #9333ea;
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
  text-align: center;
  font-size: 14px;
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
  background: #9333ea;
  color: white;
  padding: 12px;
  border-radius: 10px;
  border: none;
  cursor: pointer;
  width: 100%;
  font-weight: 600;
}
.btn:hover {
  background: #7e22ce;
}
.btn:disabled {
  background: #a5b4fc;
  cursor: not-allowed;
}
.resend-link {
  margin-top: 1rem;
  font-size: 14px;
  color: #6b7280;
}
.link-btn {
  background: none;
  border: none;
  color: #9333ea;
  cursor: pointer;
  text-decoration: underline;
  padding: 0;
  font-size: 14px;
}
.link-btn:hover {
  color: #7e22ce;
}
.link-btn:disabled {
  color: #a5b4fc;
  cursor: not-allowed;
  text-decoration: none;
}
</style>