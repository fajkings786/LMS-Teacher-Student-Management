<template>
  <div class="auth-wrapper">
    <!-- Full-page loader overlay -->
    <div v-if="resending" class="loader-overlay">
      <div class="loader-container">
        <div class="loader-spinner"></div>
        <p class="loader-text">Sending OTP...</p>
      </div>
    </div>

    <div class="auth-container">
      <div class="auth-card">
        <div class="auth-header">
          <div class="auth-icon">🔑</div>
          <h2 class="auth-title">Verify OTP</h2>
          <p class="auth-subtitle">Enter the verification code sent to your email</p>
        </div>

        <form @submit.prevent="verifyOtp" class="auth-form">
          <input type="hidden" name="_token" :value="csrfToken" />
          <input type="hidden" :value="localEmail" />

          <div class="otp-container">
            <div v-for="(index, i) in 6" :key="i" class="otp-input-wrapper">
              <input
                v-model="otpDigits[i]"
                type="text"
                maxlength="1"
                @input="handleOtpInput(i)"
                @keydown="handleKeyDown(i, $event)"
                @paste="handlePaste"
                :ref="`otpInput${i}`"
                class="otp-input"
                :class="{ filled: otpDigits[i], shake: shakeIndex === i }"
              />
              <div class="otp-input-underline"></div>
            </div>
          </div>

          <div v-if="message" :class="['alert', success ? 'success' : 'error']">
            <span class="alert-icon">{{ success ? "✓" : "⚠" }}</span>
            {{ message }}
          </div>

          <button
            type="submit"
            class="auth-button"
            :disabled="loading || otpDigits.join('').length !== 6"
          >
            <span v-if="loading" class="button-spinner"></span>
            <span v-else>Verify</span>
          </button>
        </form>

        <div class="auth-footer">
          <p class="resend-text">Didn't receive the code?</p>
          <button @click="resendOtp" :disabled="resending" class="resend-button">
            <span v-if="resending" class="button-spinner"></span>
            <span v-else>Resend OTP</span>
          </button>
        </div>
      </div>

      <div class="auth-info">
        <div class="info-item">
          <div class="info-icon">📧</div>
          <div class="info-content">
            <div class="info-title">Check your email</div>
            <div class="info-desc">We've sent a 6-digit code to {{ maskedEmail }}</div>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon">⏱️</div>
          <div class="info-content">
            <div class="info-title">Code expires</div>
            <div class="info-desc">
              Your OTP will expire in
              <span class="countdown" v-if="timeRemaining > 0">
                {{ formatTime(timeRemaining) }}
              </span>
              <span v-else>0:00</span>
            </div>
          </div>
        </div>
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
        otpDigits: ["", "", "", "", "", ""],
        message: "",
        success: false,
        loading: false,
        resending: false,
        localEmail: this.email || "",
        csrfToken:
          document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") ||
          "",
        shakeIndex: -1,
        timeRemaining: 900, // 15 minutes in seconds
        countdownInterval: null,
      };
    },
    computed: {
      maskedEmail() {
        if (!this.localEmail) return "";
        const [name, domain] = this.localEmail.split("@");
        return `${name.substring(0, 2)}***@${domain}`;
      },
    },
    methods: {
      handleOtpInput(index) {
        // Move to next input if current is filled
        if (this.otpDigits[index] && index < 5) {
          this.$refs[`otpInput${index + 1}`][0].focus();
        }
        // Update the full OTP
        this.otp = this.otpDigits.join("");
      },

      handleKeyDown(index, event) {
        // Handle backspace
        if (event.key === "Backspace" && !this.otpDigits[index] && index > 0) {
          this.otpDigits[index - 1] = "";
          this.$refs[`otpInput${index - 1}`][0].focus();
        }

        // Handle enter key
        if (event.key === "Enter" && this.otpDigits.join("").length === 6) {
          this.verifyOtp();
        }
      },

      handlePaste(event) {
        event.preventDefault();
        const pasteData = event.clipboardData.getData("text").trim();
        if (/^\d{6}$/.test(pasteData)) {
          this.otpDigits = pasteData.split("");
          this.otp = pasteData;
          // Focus on the last input
          this.$refs.otpInput5[0].focus();
        }
      },

      async verifyOtp() {
        if (this.otp.length !== 6) {
          this.message = "Please enter a complete 6-digit OTP";
          this.success = false;
          // Shake the last empty input
          const emptyIndex = this.otpDigits.findIndex((digit) => !digit);
          if (emptyIndex !== -1) {
            this.shakeIndex = emptyIndex;
            setTimeout(() => {
              this.shakeIndex = -1;
            }, 500);
          }
          return;
        }

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

          // Shake all inputs on error
          this.otpDigits.forEach((_, i) => {
            this.shakeIndex = i;
            setTimeout(() => {
              this.shakeIndex = -1;
            }, 500);
          });
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

          // Reset the countdown
          this.timeRemaining = 900;
          this.startCountdown();

          // Clear OTP inputs
          this.otpDigits = ["", "", "", "", "", ""];
          this.otp = "";

          // Focus on first input
          if (this.$refs.otpInput0) {
            this.$refs.otpInput0[0].focus();
          }
        } catch (err) {
          console.error("Resend OTP error:", err);
          this.message = err.message || "An error occurred. Please try again.";
          this.success = false;
        } finally {
          this.resending = false;
        }
      },

      formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins}:${secs < 10 ? "0" : ""}${secs}`;
      },

      startCountdown() {
        // Clear any existing interval
        if (this.countdownInterval) {
          clearInterval(this.countdownInterval);
        }

        // Start new countdown
        this.countdownInterval = setInterval(() => {
          if (this.timeRemaining > 0) {
            this.timeRemaining--;
          } else {
            clearInterval(this.countdownInterval);
          }
        }, 1000);
      },
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

      // Focus on first OTP input
      if (this.$refs.otpInput0) {
        this.$refs.otpInput0[0].focus();
      }

      // Start the countdown
      this.startCountdown();
    },

    beforeUnmount() {
      // Clear the countdown interval when component is destroyed
      if (this.countdownInterval) {
        clearInterval(this.countdownInterval);
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
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
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
    filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
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
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  .auth-subtitle {
    font-size: 16px;
    color: #666;
    margin: 0;
  }

  .auth-form {
    margin-bottom: 25px;
  }

  .otp-container {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
    gap: 10px;
  }

  .otp-input-wrapper {
    flex: 1;
    position: relative;
  }

  .otp-input {
    width: 100%;
    height: 60px;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    text-align: center;
    font-size: 24px;
    font-weight: 600;
    color: #333;
    transition: all 0.3s ease;
    background: #f9fafb;
    position: relative;
    z-index: 1;
  }

  .otp-input:focus {
    outline: none;
    border-color: #667eea;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
  }

  .otp-input.filled {
    border-color: #667eea;
    background: #f0f4ff;
    color: #667eea;
  }

  .otp-input-underline {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 3px;
    transform: scaleX(0);
    transition: transform 0.3s ease;
  }

  .otp-input:focus ~ .otp-input-underline,
  .otp-input.filled ~ .otp-input-underline {
    transform: scaleX(1);
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

  .otp-input.shake {
    animation: shake 0.5s ease-in-out;
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

  .auth-button {
    width: 100%;
    padding: 16px;
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

  .resend-text {
    font-size: 14px;
    color: #666;
    margin-bottom: 10px;
  }

  .resend-button {
    background: none;
    border: none;
    color: #667eea;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    padding: 5px 0;
    transition: all 0.3s ease;
    position: relative;
  }

  .resend-button::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: #667eea;
    transition: width 0.3s ease;
  }

  .resend-button:hover::after {
    width: 100%;
  }

  .resend-button:disabled {
    color: #a5b4fc;
    cursor: not-allowed;
  }

  .resend-button:disabled::after {
    background: #a5b4fc;
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

  .countdown {
    font-weight: 600;
    color: #ef4444;
  }

  @media (max-width: 480px) {
    .auth-card {
      padding: 30px 20px;
    }

    .otp-input {
      height: 50px;
      font-size: 20px;
    }

    .auth-title {
      font-size: 24px;
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
