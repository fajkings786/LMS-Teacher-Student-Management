<template>
  <nav class="navbar">
    <div class="navbar-container">
      <div class="navbar-brand">
        <span class="logo">🎓</span>
        <span class="brand-name">LMS</span>
      </div>
      <div class="navbar-menu" :class="{ active: isMenuOpen }">
        <router-link to="/" class="navbar-item" @click="closeMenu">
          <span class="icon"><i class="fas fa-home"></i></span>
          <span>Home</span>
        </router-link>
        <router-link to="/about" class="navbar-item" @click="closeMenu">
          <span class="icon"><i class="fas fa-info-circle"></i></span>
          <span>About</span>
        </router-link>
        <router-link to="/lectures" class="navbar-item" @click="closeMenu">
          <span class="icon"><i class="fas fa-book-open"></i></span>
          <span>Lectures</span>
        </router-link>
        <router-link to="/course" class="navbar-item" @click="closeMenu">
          <span class="icon"><i class="fas fa-graduation-cap"></i></span>
          <span>Courses</span>
        </router-link>
        <router-link to="/contact" class="navbar-item" @click="closeMenu">
          <span class="icon"><i class="fas fa-envelope"></i></span>
          <span>Contact</span>
        </router-link>
        <!-- Authentication Section -->
        <div v-if="!isLoggedIn" class="auth-section">
          <router-link to="/login" class="navbar-item login-btn" @click="closeMenu">
            <span class="icon"><i class="fas fa-sign-in-alt"></i></span>
            <span>Login</span>
          </router-link>
        </div>
        <!-- Profile Dropdown for Logged-in Users -->
        <div v-else class="profile-dropdown">
          <div class="profile-trigger" @click="toggleProfileDropdown">
            <!-- Navbar.vue mein profile avatar -->
            <div class="profile-avatar">
              <img 
                v-if="userProfile.picture" 
                :src="getFullImageUrl(userProfile.picture)" 
                alt="Profile" 
                @error="handleImageError"
              />
              <span v-else class="avatar-placeholder">{{ userInitials }}</span>
            </div>
            <span class="profile-name">{{ userProfile.name || "User" }}</span>
            <span class="dropdown-icon"><i class="fas fa-chevron-down"></i></span>
          </div>
          <div v-if="isProfileDropdownOpen" class="dropdown-menu">
            <div class="dropdown-header">
              <div class="dropdown-avatar">
                <img
                  v-if="userProfile.picture"
                  :src="getFullImageUrl(userProfile.picture)"
                  alt="Profile"
                  @error="handleImageError"
                />
                <span v-else class="avatar-placeholder">{{ userInitials }}</span>
              </div>
              <div class="user-info">
                <div class="user-name">{{ userProfile.name || "User" }}</div>
                <div class="user-email">{{ userProfile.email || "" }}</div>
                <div class="user-role">{{ userProfile.role || "Student" }}</div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <router-link to="/profile" class="dropdown-item" @click="closeAllMenus">
              <span class="item-icon"><i class="fas fa-user"></i></span>
              <span>My Profile</span>
            </router-link>
            <router-link to="/my-courses" class="dropdown-item" @click="closeAllMenus">
              <span class="item-icon"><i class="fas fa-book"></i></span>
              <span>My Courses</span>
            </router-link>
            <router-link to="/settings" class="dropdown-item" @click="closeAllMenus">
              <span class="item-icon"><i class="fas fa-cog"></i></span>
              <span>Settings</span>
            </router-link>
            <div class="dropdown-divider"></div>
            <!-- Dashboard link - replaces logout button when user is logged in -->
            <router-link
              v-if="userProfile.status === 'approved'"
              to="/dashboard"
              class="dropdown-item dashboard-item"
              @click="closeAllMenus"
            >
              <span class="item-icon"><i class="fas fa-tachometer-alt"></i></span>
              <span>Dashboard</span>
            </router-link>
            <!-- Logout button - only shown if user is not approved -->
            <a v-else href="#" class="dropdown-item logout" @click.prevent="handleLogout">
              <span class="item-icon"><i class="fas fa-sign-out-alt"></i></span>
              <span>Logout</span>
            </a>
          </div>
        </div>
      </div>
      <div class="hamburger" :class="{ active: isMenuOpen }" @click="toggleMenu">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <!-- Notification Toast -->
    <div v-if="showNotification" class="notification-toast">
      <div class="notification-content">
        <span class="notification-icon"><i class="fas fa-check-circle"></i></span>
        <span class="notification-message">{{ notificationMessage }}</span>
      </div>
    </div>
  </nav>
</template>

<script>
  import { ref, computed, onMounted, onUnmounted, watch } from "vue";
  import { useRouter, useRoute } from "vue-router";
  export default {
    name: "Navbar",
    setup() {
      const router = useRouter();
      const route = useRoute();
      const isMenuOpen = ref(false);
      const isProfileDropdownOpen = ref(false);
      const showNotification = ref(false);
      const notificationMessage = ref("");
      const isCheckingAuth = ref(true);
      // User state
      const userProfile = ref({
        name: "",
        email: "",
        role: "",
        status: "",
        picture: null,
      });
      // Force update key to force re-render when user logs in
      const forceUpdateKey = ref(0);
      
      // Check if user is logged in
      const isLoggedIn = computed(() => {
        const userData = localStorage.getItem("userData");
        console.log("Checking login status. User data exists:", !!userData);
        console.log("Current userProfile:", userProfile.value);
        return userData !== null;
      });
      
      // Check if user data exists (for debugging)
      const hasUserData = computed(() => {
        return localStorage.getItem("userData") !== null;
      });
      
      // Get user initials for avatar placeholder
      const userInitials = computed(() => {
        if (!userProfile.value.name) return "U";
        return userProfile.value.name
          .split(" ")
          .map((part) => part.charAt(0))
          .join("")
          .substring(0, 2)
          .toUpperCase();
      });
      
      // Get full image URL
      const getFullImageUrl = (picture) => {
        if (!picture) return null;
        
        // If it's already a full URL, return as is
        if (picture.startsWith('http://') || picture.startsWith('https://')) {
          return picture;
        }
        
        // If it starts with /storage/, it's already correct
        if (picture.startsWith('/storage/')) {
          return picture;
        }
        
        // If it starts with storage/, add leading slash
        if (picture.startsWith('storage/')) {
          return `/${picture}`;
        }
        
        // If it's a relative path, add /storage/ prefix
        return `/storage/${picture}`;
      };
      
      // Methods
      const toggleMenu = () => {
        isMenuOpen.value = !isMenuOpen.value;
        if (isMenuOpen.value) {
          isProfileDropdownOpen.value = false;
        }
      };
      
      const closeMenu = () => {
        isMenuOpen.value = false;
      };
      
      const toggleProfileDropdown = () => {
        isProfileDropdownOpen.value = !isProfileDropdownOpen.value;
      };
      
      const closeAllMenus = () => {
        isMenuOpen.value = false;
        isProfileDropdownOpen.value = false;
      };
      
      // Show notification
      const showNotificationMessage = (message) => {
        notificationMessage.value = message;
        showNotification.value = true;
        setTimeout(() => {
          showNotification.value = false;
        }, 3000);
      };
      
      const handleLogout = async () => {
        try {
          await fetch("/logout", {
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
              Accept: "application/json",
            },
            credentials: "include",
          });
          // Clear local storage
          localStorage.removeItem("userData");
          sessionStorage.clear();
          // Reset user profile
          userProfile.value = {
            name: "",
            email: "",
            role: "",
            status: "",
            picture: null,
          };
          // Emit logout event
          window.dispatchEvent(new Event("userLoggedOut"));
          showNotificationMessage("Logged out successfully");
          // Redirect to login page
          setTimeout(() => {
            router.push("/login");
          }, 1000);
        } catch (e) {
          console.error("Logout error:", e);
        }
      };
      
      // Load user data from localStorage
      const loadUserData = () => {
        console.log("Loading user data from localStorage");
        const userData = localStorage.getItem("userData");
        console.log("User data from localStorage:", userData);
        if (userData) {
          try {
            // Parse the user data
            const parsedData = JSON.parse(userData);
            console.log("Parsed user data:", parsedData);
            // Update the userProfile reactive object
            userProfile.value = {
              name: parsedData.name || "",
              email: parsedData.email || "",
              role: parsedData.role || "",
              status: parsedData.status || "",
              picture: getFullImageUrl(parsedData.picture),
            };
            console.log("Updated userProfile:", userProfile.value);
            // Force update
            forceUpdateKey.value += 1;
          } catch (e) {
            console.error("Failed to parse user data:", e);
          }
        }
      };
      
      // Check authentication status from server
      const checkAuthStatus = async () => {
        try {
          isCheckingAuth.value = true;
          console.log("Checking auth status from server");
          const response = await fetch("/api/auth/check", {
            method: "GET",
            headers: {
              Accept: "application/json",
              "X-Requested-With": "XMLHttpRequest",
            },
            credentials: "include",
          });
          if (response.ok) {
            const data = await response.json();
            console.log("Auth check response:", data);
            if (data.authenticated && data.user) {
              // Update userProfile reactive object
              userProfile.value = {
                name: data.user.name || "",
                email: data.user.email || "",
                role: data.user.role || "",
                status: data.user.status || "",
                picture: getFullImageUrl(data.user.picture), // Fixed field name
              };
              // Update localStorage with fresh data
              localStorage.setItem("userData", JSON.stringify(userProfile.value));
              console.log("User authenticated from server:", data.user);
            } else {
              // Clear localStorage if not authenticated
              localStorage.removeItem("userData");
              userProfile.value = {
                name: "",
                email: "",
                role: "",
                status: "",
                picture: null,
              };
            }
          } else {
            // If server response is not ok, clear user data
            localStorage.removeItem("userData");
            userProfile.value = {
              name: "",
              email: "",
              role: "",
              status: "",
              picture: null,
            };
          }
        } catch (error) {
          console.error("Error checking auth status:", error);
          // If there's an error, don't clear the user data, just use what's in localStorage
          // The data was already loaded in loadUserData()
        } finally {
          isCheckingAuth.value = false;
        }
      };
      
      // Listen for login event
      const handleUserLoggedIn = (event) => {
        console.log("User logged in event received:", event.detail);
        // Update the userProfile reactive object with the event data
        if (event.detail) {
          userProfile.value = {
            name: event.detail.name || "",
            email: event.detail.email || "",
            role: event.detail.role || "",
            status: event.detail.status || "",
            picture: getFullImageUrl(event.detail.picture),
          };
          // Also save to localStorage
          localStorage.setItem("userData", JSON.stringify(userProfile.value));
          console.log("Updated userProfile from event:", userProfile.value);
          // Show welcome notification
          showNotificationMessage(`Welcome back, ${userProfile.value.name}!`);
          // Force update
          forceUpdateKey.value += 1;
        }
      };
      
      // Listen for logout event
      const handleUserLoggedOut = () => {
        console.log("User logged out event received");
        // Clear all storage
        localStorage.clear();
        sessionStorage.clear();
        // Reset user profile
        userProfile.value = {
          name: "",
          email: "",
          role: "",
          status: "",
          picture: null,
        };
        // Force update
        forceUpdateKey.value += 1;
        // Close menus
        closeAllMenus();
      };
      
      // Listen for profile picture update event
      const handleProfileUpdate = (event) => {
        console.log("Profile update event received:", event.detail);
        if (event.detail && event.detail.picture) {
          userProfile.value.picture = event.detail.picture;
          
          // Update localStorage
          const userData = JSON.parse(localStorage.getItem("userData") || "{}");
          userData.picture = event.detail.picture;
          localStorage.setItem("userData", JSON.stringify(userData));
          
          console.log("Navbar profile picture updated to:", event.detail.picture);
        }
      };
      
      // Handle image loading error
      const handleImageError = (event) => {
        console.error("Failed to load navbar profile image:", event.target.src);
        // Fallback to placeholder
        userProfile.value.picture = null;
      };
      
      // Listen for storage changes
      const handleStorageChange = (event) => {
        console.log("Storage change event:", event);
        if (event.key === "userData" && event.newValue === null) {
          // User logged out in another tab
          window.location.href = "/login";
        }
      };
      
      // Load user data on component mount
      onMounted(async () => {
        console.log("Navbar mounted");
        // First try to load from localStorage immediately
        loadUserData();
        // Then check auth status from server
        await checkAuthStatus();
        // Set up event listeners
        window.addEventListener("userLoggedIn", handleUserLoggedIn);
        window.addEventListener("userLoggedOut", handleUserLoggedOut);
        window.addEventListener("userProfileUpdated", handleProfileUpdate);
        window.addEventListener("storage", handleStorageChange);
      });
      
      // Clean up event listeners
      onUnmounted(() => {
        window.removeEventListener("userLoggedIn", handleUserLoggedIn);
        window.removeEventListener("userLoggedOut", handleUserLoggedOut);
        window.removeEventListener("userProfileUpdated", handleProfileUpdate);
        window.removeEventListener("storage", handleStorageChange);
      });
      
      // Watch for route changes to close mobile menu
      watch(
        () => route.path,
        () => {
          closeMenu();
        }
      );
      
      return {
        isMenuOpen,
        isProfileDropdownOpen,
        isLoggedIn,
        hasUserData,
        userProfile,
        userInitials,
        forceUpdateKey,
        showNotification,
        notificationMessage,
        isCheckingAuth,
        toggleMenu,
        closeMenu,
        toggleProfileDropdown,
        closeAllMenus,
        handleLogout,
        handleImageError,
        getFullImageUrl,
      };
    },
  };
</script>

<style scoped>
  /* Enhanced Navbar Styles */
  .navbar {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    padding: 0.8rem 1rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    position: sticky;
    top: 0;
    z-index: 1000;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }
  .navbar-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .navbar-brand {
    display: flex;
    align-items: center;
    font-size: 1.8rem;
    font-weight: bold;
    letter-spacing: 1px;
  }
  .logo {
    font-size: 2rem;
    margin-right: 0.5rem;
    filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));
    animation: pulse 2s infinite;
  }
  @keyframes pulse {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1);
    }
  }
  .brand-name {
    background: linear-gradient(to right, #ffffff, #e0e7ff);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  .navbar-menu {
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }
  .navbar-item {
    color: white;
    text-decoration: none;
    padding: 0.7rem 1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  .navbar-item::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    transition: width 0.3s ease;
    z-index: -1;
  }
  .navbar-item:hover::before {
    width: 100%;
  }
  .navbar-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  .navbar-item.router-link-active {
    background: rgba(255, 255, 255, 0.2);
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }
  .login-btn {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
  }
  .login-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  }
  .icon {
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
    width: 30px;
    height: 24px;
    position: relative;
  }
  .hamburger span {
    width: 100%;
    height: 3px;
    background: white;
    margin: 3px 0;
    transition: 0.3s;
    border-radius: 3px;
    position: absolute;
    left: 0;
  }
  .hamburger span:nth-child(1) {
    top: 0;
  }
  .hamburger span:nth-child(2) {
    top: 9px;
  }
  .hamburger span:nth-child(3) {
    top: 18px;
  }
  .hamburger.active span:nth-child(2) {
    opacity: 0;
  }
  .hamburger.active span:nth-child(1) {
    transform: translateY(9px) rotate(45deg);
  }
  .hamburger.active span:nth-child(3) {
    transform: translateY(-9px) rotate(-45deg);
  }
  /* Profile Dropdown Styles */
  .profile-dropdown {
    position: relative;
  }
  .profile-trigger {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  .profile-trigger:hover {
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }
  .profile-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  .profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .avatar-placeholder {
    font-weight: bold;
    color: white;
    font-size: 1rem;
  }
  .profile-name {
    font-weight: 500;
    max-width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .dropdown-icon {
    font-size: 0.8rem;
    transition: transform 0.3s ease;
  }
  .dropdown-menu {
    position: absolute;
    top: calc(100% + 0.5rem);
    right: 0;
    min-width: 250px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    z-index: 1000;
    animation: dropdownFadeIn 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
  }
  @keyframes dropdownFadeIn {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  .dropdown-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
  }
  .dropdown-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  .dropdown-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .user-info {
    flex: 1;
  }
  .user-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-size: 1rem;
  }
  .user-email {
    font-size: 0.875rem;
    opacity: 0.9;
  }
  .user-role {
    font-size: 0.75rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.125rem 0.5rem;
    border-radius: 999px;
    display: inline-block;
    margin-top: 0.25rem;
    font-weight: 500;
  }
  .dropdown-divider {
    height: 1px;
    background: #e5e7eb;
    margin: 0.5rem 0;
  }
  .dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: #4b5563;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .dropdown-item:hover {
    background: #f3f4f6;
    color: #4f46e5;
  }
  .dashboard-item {
    color: #4f46e5;
    font-weight: 600;
    background-color: #f5f3ff;
    border-radius: 6px;
    margin: 0 8px;
    padding: 0.75rem 1rem;
    border: 1px solid #e0e7ff;
  }
  .dashboard-item:hover {
    background-color: #ede9fe;
    border-color: #c7d2fe;
  }
  .item-icon {
    font-size: 1.125rem;
    color: #6b7280;
    width: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .dropdown-item:hover .item-icon {
    color: #4f46e5;
  }
  .dashboard-item .item-icon {
    color: #4f46e5;
  }
  .logout {
    color: #ef4444;
    font-weight: 500;
  }
  .logout:hover {
    background: #fee2e2;
    color: #ef4444;
  }
  .logout:hover .item-icon {
    color: #ef4444;
  }
  /* Notification Toast */
  .notification-toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    padding: 1rem;
    display: flex;
    align-items: center;
    z-index: 1001;
    animation: slideIn 0.3s ease, slideOut 0.3s ease 2.7s;
    animation-fill-mode: forwards;
  }
  @keyframes slideIn {
    from {
      transform: translateX(100%);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }
  @keyframes slideOut {
    from {
      transform: translateX(0);
      opacity: 1;
    }
    to {
      transform: translateX(100%);
      opacity: 0;
    }
  }
  .notification-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }
  .notification-icon {
    color: #10b981;
    font-size: 1.5rem;
  }
  .notification-message {
    color: #1f2937;
    font-weight: 500;
  }
  /* Mobile responsiveness */
  @media (max-width: 768px) {
    .hamburger {
      display: flex;
    }
    .navbar-menu {
      position: fixed;
      left: -100%;
      top: 70px;
      flex-direction: column;
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      width: 100%;
      text-align: center;
      transition: 0.3s;
      box-shadow: 0 10px 27px rgba(0, 0, 0, 0.05);
      padding: 2rem 0;
      gap: 0.8rem;
      height: calc(100vh - 70px);
      overflow-y: auto;
    }
    .navbar-menu.active {
      left: 0;
    }
    .navbar-item {
      width: 80%;
      margin: 0 auto;
      justify-content: center;
      padding: 1rem;
    }
    .auth-section {
      width: 80%;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }
    .profile-dropdown {
      width: 80%;
      margin: 0 auto;
    }
    .profile-trigger {
      width: 100%;
      justify-content: center;
    }
    .dropdown-menu {
      position: static;
      margin-top: 0.5rem;
      box-shadow: none;
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      width: 100%;
    }
    .dropdown-header {
      background: rgba(255, 255, 255, 0.1);
    }
    .dropdown-item {
      color: white;
    }
    .dropdown-item:hover {
      background: rgba(255, 255, 255, 0.1);
    }
    .dashboard-item {
      color: white;
      background: rgba(199, 210, 254, 0.2);
      border-color: rgba(199, 210, 254, 0.3);
    }
    .dashboard-item:hover {
      background: rgba(199, 210, 254, 0.3);
    }
    .logout {
      color: #fca5a5;
    }
    .logout:hover {
      background: rgba(239, 68, 68, 0.2);
    }
    .notification-toast {
      bottom: 10px;
      right: 10px;
      left: 10px;
      max-width: none;
    }
  }
</style>