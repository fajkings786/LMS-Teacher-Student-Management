<template>
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-section">
        <div class="footer-brand">
          <span class="logo">🎓</span>
          <span class="brand-name">LMS</span>
        </div>
        <p class="footer-description">
          Your one-stop solution for online learning and course management.
        </p>
        <div class="social-links">
          <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
          <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>

      <div class="footer-section">
        <h3>Quick Links</h3>
        <ul class="footer-links">
          <li><router-link to="/">Home</router-link></li>
          <li><router-link to="/about">About</router-link></li>
          <li><router-link to="/lectures">Lectures</router-link></li>
          <li><router-link to="/Course">Courses</router-link></li>
          <li><router-link to="/contact">Contact</router-link></li>
          <li><router-link to="/signup">Signup</router-link></li>
        </ul>
      </div>

      <div class="footer-section">
        <h3>Contact Info</h3>
        <ul class="contact-info">
          <li>123 Education St, Learning City</li>
          <li>info@lms.com</li>
          <li>+123 456 7890</li>
        </ul>
      </div>

      <div class="footer-section">
        <h3>Newsletter</h3>
        <p>Subscribe to get updates on new courses</p>
        <div class="newsletter-form">
          <input type="email" placeholder="Your email" />
          <button class="subscribe-btn">Subscribe</button>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2023 LMS. All rights reserved.</p>
    </div>
  </footer>
</template>

<script>
  export default {
    name: "Footer",
  };
</script>

<style scoped>
  .footer {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    padding: 3rem 1rem 1rem;
    margin-top: 3rem;
  }

  .footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
  }

  .footer-section {
    margin-bottom: 1.5rem;
  }

  .footer-brand {
    display: flex;
    align-items: center;
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 1rem;
  }

  .logo {
    font-size: 2rem;
    margin-right: 0.5rem;
  }

  .brand-name {
    background: linear-gradient(to right, #ffffff, #e0e7ff);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  .footer-description {
    margin-bottom: 1.5rem;
    opacity: 0.9;
    line-height: 1.6;
  }

  .social-links {
    display: flex;
    gap: 1rem;
  }

  .social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: white;
    text-decoration: none;
    font-size: 1.2rem;
    transition: all 0.3s ease;
  }

  .social-link:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
  }

  h3 {
    font-size: 1.2rem;
    margin-bottom: 1.2rem;
    position: relative;
    padding-bottom: 0.5rem;
  }

  h3:after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 2px;
    background: rgba(255, 255, 255, 0.5);
  }

  .footer-links {
    list-style: none;
    padding: 0;
  }

  .footer-links li {
    margin-bottom: 0.8rem;
  }

  .footer-links a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
  }

  .footer-links a:hover {
    color: white;
    transform: translateX(5px);
  }

  .contact-info {
    list-style: none;
    padding: 0;
  }

  .contact-info li {
    margin-bottom: 0.8rem;
    display: flex;
    align-items: center;
  }

  .contact-info li:before {
    content: "";
    display: inline-block;
    width: 20px;
  }

  .newsletter-form {
    display: flex;
    margin-top: 1rem;
  }

  .newsletter-form input {
    flex: 1;
    padding: 0.8rem;
    border: none;
    border-radius: 8px 0 0 8px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
  }

  .newsletter-form input::placeholder {
    color: rgba(255, 255, 255, 0.7);
  }

  .subscribe-btn {
    padding: 0.8rem 1.2rem;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 0 8px 8px 0;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .subscribe-btn:hover {
    background: rgba(255, 255, 255, 0.3);
  }

  .footer-bottom {
    text-align: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 0.9rem;
    opacity: 0.8;
  }

  @media (max-width: 768px) {
    .footer-container {
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }

    .newsletter-form {
      flex-direction: column;
    }

    .newsletter-form input,
    .subscribe-btn {
      width: 100%;
      border-radius: 8px;
      margin-bottom: 0.5rem;
    }
  }
</style>
