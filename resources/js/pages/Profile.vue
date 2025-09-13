<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <Navbar />
    <div class="profile-container">
      <!-- Profile Header -->
      <div class="profile-header">
        <div class="relative">
          <div class="header-background"></div>
          <div class="header-content">
            <div class="avatar-section">
              <div class="avatar-container">
                <img
                  v-if="userProfile.picture"
                  :src="userProfile.picture"
                  :key="imageKey"
                  alt="Profile"
                  class="avatar"
                  @error="handleImageError"
                />
                <div v-else class="avatar-placeholder">{{ userInitials }}</div>
                <div class="avatar-upload" @click="triggerFileUpload">
                  <i class="fas fa-camera"></i>
                  <input
                    type="file"
                    ref="fileInput"
                    @change="handleFileUpload"
                    style="display: none"
                    accept="image/*"
                  />
                </div>
              </div>
              <div class="profile-info">
                <h1 class="profile-name">{{ userProfile.name || "User" }}</h1>
                <p class="profile-email">{{ userProfile.email || "" }}</p>
                <div class="profile-badges">
                  <span class="badge badge-role">{{
                    userProfile.role || "Student"
                  }}</span>
                  <span class="badge" :class="getStatusBadgeClass(userProfile.status)">
                    {{ userProfile.status || "Pending" }}
                  </span>
                </div>
              </div>
            </div>
            <div class="profile-stats">
              <div class="stat-card">
                <div class="stat-icon">
                  <i class="fas fa-book"></i>
                </div>
                <div class="stat-content">
                  <div class="stat-value">{{ stats.courses }}</div>
                  <div class="stat-label">Courses</div>
                </div>
              </div>
              <div class="stat-card">
                <div class="stat-icon">
                  <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                  <div class="stat-value">{{ stats.hours }}</div>
                  <div class="stat-label">Hours</div>
                </div>
              </div>
              <div class="stat-card">
                <div class="stat-icon">
                  <i class="fas fa-certificate"></i>
                </div>
                <div class="stat-content">
                  <div class="stat-value">{{ stats.certificates }}</div>
                  <div class="stat-label">Certificates</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Profile Content -->
      <div class="profile-content">
        <div class="profile-sidebar">
          <div class="sidebar-section">
            <h3 class="sidebar-title">Quick Actions</h3>
            <div class="action-list">
              <button
                class="action-btn"
                :class="{ active: activeTab === 'account' }"
                @click="setActiveTab('account')"
              >
                <i class="fas fa-user"></i>
                <span>Account Settings</span>
              </button>
              <button
                class="action-btn"
                :class="{ active: activeTab === 'security' }"
                @click="setActiveTab('security')"
              >
                <i class="fas fa-lock"></i>
                <span>Security</span>
              </button>
              <button
                class="action-btn"
                :class="{ active: activeTab === 'courses' }"
                @click="setActiveTab('courses')"
              >
                <i class="fas fa-book-open"></i>
                <span>My Courses</span>
              </button>
              <button
                class="action-btn"
                :class="{ active: activeTab === 'achievements' }"
                @click="setActiveTab('achievements')"
              >
                <i class="fas fa-trophy"></i>
                <span>Achievements</span>
              </button>
              <button
                class="action-btn"
                :class="{ active: activeTab === 'chat' }"
                @click="setActiveTab('chat')"
              >
                <i class="fas fa-comments"></i>
                <span>Chat</span>
              </button>
            </div>
          </div>
          <div class="sidebar-section">
            <h3 class="sidebar-title">Account</h3>
            <div class="action-list">
              <button class="action-btn action-btn-danger" @click="confirmDeleteAccount">
                <i class="fas fa-trash-alt"></i>
                <span>Delete Account</span>
              </button>
            </div>
          </div>
        </div>
        <div class="profile-main">
          <!-- Tab Navigation -->
          <div class="tab-navigation">
            <div
              v-for="tab in tabs"
              :key="tab.id"
              class="tab-item"
              :class="{ active: activeTab === tab.id }"
              @click="setActiveTab(tab.id)"
            >
              <i :class="tab.icon"></i>
              <span>{{ tab.name }}</span>
            </div>
          </div>
          <!-- Tab Content -->
          <div class="tab-content">
            <!-- Account Tab -->
            <div v-if="activeTab === 'account'" class="tab-pane">
              <div class="form-container">
                <h2 class="form-title">Account Information</h2>
                <form @submit.prevent="updateAccount">
                  <div class="form-row">
                    <div class="form-group">
                      <label class="form-label">First Name</label>
                      <input
                        type="text"
                        class="form-input"
                        v-model="accountForm.firstName"
                        required
                      />
                    </div>
                    <div class="form-group">
                      <label class="form-label">Last Name</label>
                      <input
                        type="text"
                        class="form-input"
                        v-model="accountForm.lastName"
                        required
                      />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Email</label>
                    <input
                      type="email"
                      class="form-input"
                      v-model="accountForm.email"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="tel" class="form-input" v-model="accountForm.phone" />
                  </div>
                  <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea
                      class="form-textarea"
                      rows="4"
                      v-model="accountForm.bio"
                      placeholder="Tell us about yourself..."
                    ></textarea>
                  </div>
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <!-- Security Tab -->
            <div v-if="activeTab === 'security'" class="tab-pane">
              <div class="form-container">
                <h2 class="form-title">Security Settings</h2>
                <!-- Password Change Section -->
                <div class="security-section">
                  <h3 class="security-title">Change Password</h3>
                  <form @submit.prevent="changePassword">
                    <div class="form-actions">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        @click="goToForgotPassword"
                      >
                        <i class="fas fa-key mr-2"></i> Forgot Password
                      </button>
                    </div>
                  </form>
                </div>
                <!-- Two-Factor Authentication Section -->
                <div class="security-section">
                  <h3 class="security-title">Two-Factor Authentication</h3>
                  <div class="security-card security-card-info">
                    <div class="security-info">
                      <h4 class="security-card-title">Add an extra layer of security</h4>
                      <p class="security-card-description">
                        Protect your account with two-factor authentication.
                      </p>
                    </div>
                    <div>
                      <button
                        class="btn"
                        :class="twoFactorEnabled ? 'btn-secondary' : 'btn-primary'"
                        @click="toggleTwoFactor"
                      >
                        {{ twoFactorEnabled ? "Disable" : "Enable" }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- My Courses Tab -->
            <div v-if="activeTab === 'courses'" class="tab-pane">
              <div class="courses-container">
                <h2 class="form-title">My Courses</h2>
                <div v-if="courses.length === 0" class="empty-state">
                  <div class="empty-icon">
                    <i class="fas fa-book-open"></i>
                  </div>
                  <h3 class="empty-title">No courses yet</h3>
                  <p class="empty-description">
                    You haven't enrolled in any courses yet. Browse our catalog to get
                    started.
                  </p>
                  <router-link to="/courses" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i> Browse Courses
                  </router-link>
                </div>
                <div v-else class="courses-grid">
                  <div v-for="course in courses" :key="course.id" class="course-card">
                    <div class="course-thumbnail">
                      <img :src="course.thumbnail" alt="Course thumbnail" />
                      <div class="course-progress-overlay">
                        <div class="course-progress-text">{{ course.progress }}%</div>
                      </div>
                    </div>
                    <div class="course-content">
                      <h3 class="course-title">{{ course.title }}</h3>
                      <p class="course-instructor">{{ course.instructor }}</p>
                      <div class="course-progress-bar">
                        <div
                          class="course-progress-fill"
                          :style="{ width: course.progress + '%' }"
                        ></div>
                      </div>
                      <div class="course-meta">
                        <span class="course-duration"
                          ><i class="fas fa-clock mr-1"></i> {{ course.duration }}</span
                        >
                        <span class="course-lessons"
                          ><i class="fas fa-book-reader mr-1"></i>
                          {{ course.lessons }} lessons</span
                        >
                      </div>
                      <div class="course-actions">
                        <button
                          class="btn btn-primary"
                          @click="viewCourseLectures(course.id)"
                        >
                          <i class="fas fa-play-circle mr-2"></i> View Lectures
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Lectures Modal -->
            <div
              v-if="showLecturesModal"
              class="modal-overlay"
              @click.self="showLecturesModal = false"
            >
              <div class="modal-container modal-large">
                <div class="modal-header">
                  <h3 class="modal-title">
                    {{ selectedCourse?.title || "Course Lectures" }}
                  </h3>
                  <button class="modal-close" @click="showLecturesModal = false">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <div class="modal-body">
                  <div v-if="lecturesLoading" class="loading-container">
                    <div class="loading-spinner"></div>
                    <p>Loading lectures...</p>
                  </div>
                  <div v-else-if="lectures.length === 0" class="empty-state">
                    <div class="empty-icon">
                      <i class="fas fa-video"></i>
                    </div>
                    <h3 class="empty-title">No lectures available</h3>
                    <p class="empty-description">
                      This course doesn't have any lectures yet.
                    </p>
                  </div>
                  <div v-else class="lectures-list">
                    <div
                      v-for="lecture in lectures"
                      :key="lecture.id"
                      class="lecture-item"
                    >
                      <div class="lecture-info">
                        <h4 class="lecture-title">{{ lecture.title }}</h4>
                        <p class="lecture-description">{{ lecture.description }}</p>
                        <div class="lecture-meta">
                          <span class="lecture-duration"
                            ><i class="fas fa-clock mr-1"></i>
                            {{ lecture.duration }}</span
                          >
                          <span class="lecture-date"
                            ><i class="fas fa-calendar mr-1"></i>
                            {{ formatDate(lecture.created_at) }}</span
                          >
                        </div>
                      </div>
                      <button class="btn btn-primary" @click="watchLecture(lecture.id)">
                        <i class="fas fa-play mr-2"></i> Watch
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Achievements Tab -->
            <div v-if="activeTab === 'achievements'" class="tab-pane">
              <div class="achievements-container">
                <h2 class="form-title">Achievements</h2>
                <div class="achievements-grid">
                  <div
                    v-for="achievement in achievements"
                    :key="achievement.id"
                    class="achievement-card"
                  >
                    <div
                      class="achievement-icon"
                      :class="{ 'achievement-unlocked': achievement.unlocked }"
                    >
                      <i :class="achievement.icon"></i>
                    </div>
                    <h3 class="achievement-title">{{ achievement.title }}</h3>
                    <p class="achievement-description">{{ achievement.description }}</p>
                    <div
                      class="achievement-date"
                      v-if="achievement.unlocked && achievement.date"
                    >
                      Earned on {{ formatDate(achievement.date) }}
                    </div>
                    <div class="achievement-status" v-else>
                      <div class="achievement-progress">
                        <div
                          class="achievement-progress-fill"
                          :style="{ width: achievement.progress + '%' }"
                        ></div>
                      </div>
                      <span class="achievement-progress-text"
                        >{{ achievement.progress }}% complete</span
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Chat Tab -->
            <div v-if="activeTab === 'chat'" class="tab-pane">
              <div class="chat-container">
                <h2 class="form-title">Messages</h2>
                <div class="chat-layout">
                  <!-- Chat Contacts -->
                  <div class="chat-contacts">
                    <div class="chat-search">
                      <input
                        type="text"
                        class="form-input"
                        placeholder="Search contacts..."
                        v-model="chatSearchQuery"
                      />
                    </div>
                    <div class="contacts-list">
                      <div
                        v-for="contact in filteredContacts"
                        :key="contact.id"
                        class="contact-item"
                        :class="{ active: selectedContact?.id === contact.id }"
                        @click="selectContact(contact)"
                      >
                        <div class="contact-avatar">
                          <img
                            v-if="contact.picture"
                            :src="contact.picture"
                            alt="Contact"
                          />
                          <div v-else class="contact-avatar-placeholder">
                            {{ getContactInitials(contact.name) }}
                          </div>
                        </div>
                        <div class="contact-info">
                          <div class="contact-name">{{ contact.name }}</div>
                          <div class="contact-preview">
                            {{ contact.lastMessage || "No messages yet" }}
                          </div>
                        </div>
                        <div class="contact-time" v-if="contact.lastMessageTime">
                          {{ formatTime(contact.lastMessageTime) }}
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Chat Messages -->
                  <div class="chat-messages">
                    <div v-if="!selectedContact" class="empty-state">
                      <div class="empty-icon">
                        <i class="fas fa-comments"></i>
                      </div>
                      <h3 class="empty-title">Select a contact</h3>
                      <p class="empty-description">
                        Choose a contact from the list to start chatting
                      </p>
                    </div>
                    <div v-else class="chat-conversation">
                      <div class="chat-header">
                        <div class="chat-contact-info">
                          <div class="contact-avatar">
                            <img
                              v-if="selectedContact.picture"
                              :src="selectedContact.picture"
                              alt="Contact"
                            />
                            <div v-else class="contact-avatar-placeholder">
                              {{ getContactInitials(selectedContact.name) }}
                            </div>
                          </div>
                          <div>
                            <div class="contact-name">{{ selectedContact.name }}</div>
                            <div class="contact-status">
                              {{ selectedContact.online ? "Online" : "Offline" }}
                            </div>
                          </div>
                        </div>
                        <button class="btn btn-icon" @click="clearChat">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>
                      <div class="messages-container" ref="messagesContainer">
                        <div v-if="messages.length === 0" class="empty-state">
                          <p>No messages yet. Start a conversation!</p>
                        </div>
                        <div v-else>
                          <div
                            v-for="(message, index) in messages"
                            :key="index"
                            class="message"
                            :class="{
                              'message-sent': message.sent,
                              'message-received': !message.sent,
                            }"
                          >
                            <div class="message-content">
                              <div class="message-text">{{ message.text }}</div>
                              <div class="message-time">
                                {{ formatTime(message.timestamp) }}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="chat-input-container">
                        <form @submit.prevent="sendMessage">
                          <div class="chat-input-wrapper">
                            <input
                              type="text"
                              class="chat-input"
                              placeholder="Type a message..."
                              v-model="newMessage"
                              @keydown.enter.prevent="sendMessage"
                            />
                            <button type="submit" class="btn btn-primary btn-icon">
                              <i class="fas fa-paper-plane"></i>
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Forgot Password Modal -->
    <div
      v-if="showForgotPasswordModal"
      class="modal-overlay"
      @click.self="showForgotPasswordModal = false"
    >
      <div class="modal-container">
        <div class="modal-header">
          <h3 class="modal-title">Reset Password</h3>
          <button class="modal-close" @click="showForgotPasswordModal = false">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="resetPassword">
            <div class="form-group">
              <label class="form-label">Email Address</label>
              <input
                type="email"
                class="form-input"
                v-model="forgotPasswordForm.email"
                required
                placeholder="Enter your email address"
              />
            </div>
            <div class="form-actions">
              <button
                type="button"
                class="btn btn-secondary"
                @click="showForgotPasswordModal = false"
              >
                Cancel
              </button>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane mr-2"></i> Send Reset Link
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Delete Account Confirmation Modal -->
    <div
      v-if="showDeleteAccountModal"
      class="modal-overlay"
      @click.self="showDeleteAccountModal = false"
    >
      <div class="modal-container">
        <div class="modal-header">
          <h3 class="modal-title">Delete Account</h3>
          <button class="modal-close" @click="showDeleteAccountModal = false">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            This action cannot be undone. All your data will be permanently deleted.
          </div>
          <p class="modal-description">
            Are you sure you want to delete your account? This will remove all your
            courses, progress, and personal information.
          </p>
          <div class="form-actions">
            <button
              type="button"
              class="btn btn-secondary"
              @click="showDeleteAccountModal = false"
            >
              Cancel
            </button>
            <button type="button" class="btn btn-danger" @click="deleteAccount">
              <i class="fas fa-trash-alt mr-2"></i> Delete Account
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-if="showVideoModal" class="modal-overlay" @click.self="closeVideoModal">
      <div class="modal-container modal-large">
        <div class="modal-header">
          <h3 class="modal-title">
            {{ selectedVideo?.title || "Video Player" }}
          </h3>
          <button class="modal-close" @click="closeVideoModal">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="video-container">
            <div v-if="selectedVideo?.youtube_url" class="video-embed">
              <iframe
                :src="`https://www.youtube.com/embed/${getYoutubeVideoId(
                  selectedVideo.youtube_url
                )}`"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
              >
              </iframe>
            </div>
            <div v-else-if="selectedVideo?.video_path" class="video-player">
              <video controls autoplay class="video-element">
                <source
                  :src="`http://localhost:8000/storage/${selectedVideo.video_path}`"
                  type="video/mp4"
                />
                Your browser does not support the video tag.
              </video>
            </div>
            <div v-else class="video-error">
              <div class="empty-icon">
                <i class="fas fa-exclamation-triangle"></i>
              </div>
              <h3 class="empty-title">Video Not Available</h3>
              <p class="empty-description">
                This lecture doesn't have a video source available.
              </p>
            </div>
          </div>
          <div class="video-info">
            <h4 class="video-title">{{ selectedVideo?.title || "Untitled Video" }}</h4>
            <p class="video-description">
              {{ selectedVideo?.description || "No description available." }}
            </p>
            <div class="video-meta">
              <span class="video-date"
                ><i class="fas fa-calendar mr-1"></i>
                {{ formatDate(selectedVideo?.created_at) }}</span
              >
              <span class="video-status"
                ><i class="fas fa-info-circle mr-1"></i> Status:
                {{ selectedVideo?.status || "Unknown" }}</span
              >
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Beautiful Notification Container -->
    <div class="notification-container">
      <transition-group name="notification-list" tag="div">
        <div
          v-for="(notification, index) in notifications"
          :key="notification.id"
          :class="[
            'notification-toast',
            `notification-${notification.type}`,
            `notification-position-${notification.position || 'top-right'}`,
          ]"
          :style="{ zIndex: 1001 + index }"
          @click="removeNotification(notification.id)"
        >
          <div class="notification-content">
            <div class="notification-icon">
              <i
                :class="[
                  'fas',
                  notification.type === 'success'
                    ? 'fa-check-circle'
                    : notification.type === 'error'
                    ? 'fa-exclamation-circle'
                    : notification.type === 'warning'
                    ? 'fa-exclamation-triangle'
                    : 'fa-info-circle',
                ]"
              ></i>
            </div>
            <div class="notification-message">
              {{ notification.message }}
            </div>
            <button
              class="notification-close"
              @click.stop="removeNotification(notification.id)"
            >
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="notification-progress"></div>
        </div>
      </transition-group>
    </div>
  </div>
</template>

<script>
  import { ref, computed, onMounted, nextTick } from "vue";
  import { useRouter } from "vue-router";
  import axios from "axios";

  export default {
    name: "ProfilePage",
    components: {
      Navbar: () => import("../components/Navbar.vue"),
    },
    setup() {
      const router = useRouter();
      // User state
      const userProfile = ref({
        name: "John Doe",
        email: "john.doe@example.com",
        role: "Student",
        status: "approved",
        picture: null,
      });
      // UI state
      const activeTab = ref("account");
      const showForgotPasswordModal = ref(false);
      const showDeleteAccountModal = ref(false);
      const showLecturesModal = ref(false);
      const showVideoModal = ref(false);
      const fileInput = ref(null);
      const twoFactorEnabled = ref(false);
      const messagesContainer = ref(null);
      // Image key for forcing reload
      const imageKey = ref(0);
      // Stats
      const stats = ref({
        courses: 0,
        hours: 0,
        certificates: 0,
      });
      // Form data
      const accountForm = ref({
        firstName: "John",
        lastName: "Doe",
        email: "john.doe@example.com",
        phone: "+1234567890",
        bio:
          "I am a student passionate about learning new things and expanding my knowledge.",
      });
      const passwordForm = ref({
        currentPassword: "",
        newPassword: "",
        confirmPassword: "",
      });
      const forgotPasswordForm = ref({
        email: "john.doe@example.com",
      });
      // Password strength
      const passwordStrengthClass = ref("");
      const passwordStrengthText = ref("");
      const passwordStrengthTextColor = ref("");
      // Tabs
      const tabs = ref([
        { id: "account", name: "Account", icon: "fas fa-user" },
        { id: "security", name: "Security", icon: "fas fa-lock" },
        { id: "courses", name: "My Courses", icon: "fas fa-book-open" },
        { id: "achievements", name: "Achievements", icon: "fas fa-trophy" },
        { id: "chat", name: "Chat", icon: "fas fa-comments" },
      ]);
      // Courses data
      const courses = ref([]);
      const coursesLoading = ref(false);
      // Lectures data
      const selectedCourse = ref(null);
      const selectedVideo = ref(null);
      const lectures = ref([]);
      const lecturesLoading = ref(false);
      // Achievements data
      const achievements = ref([
        {
          id: 1,
          title: "Quick Learner",
          description: "Complete your first course in under a week",
          icon: "fas fa-bolt",
          unlocked: true,
          date: new Date("2023-05-15"),
          progress: 100,
        },
        {
          id: 2,
          title: "Course Explorer",
          description: "Enroll in 5 different courses",
          icon: "fas fa-compass",
          unlocked: false,
          progress: 60,
        },
        {
          id: 3,
          title: "Knowledge Seeker",
          description: "Complete 10 courses",
          icon: "fas fa-graduation-cap",
          unlocked: false,
          progress: 30,
        },
        {
          id: 4,
          title: "Night Owl",
          description: "Study for 5 consecutive nights",
          icon: "fas fa-moon",
          unlocked: true,
          date: new Date("2023-06-20"),
          progress: 100,
        },
      ]);
      // Chat data
      const chatSearchQuery = ref("");
      const selectedContact = ref(null);
      const contacts = ref([
        {
          id: 1,
          name: "Dr. Sarah Johnson",
          picture: "https://picsum.photos/seed/sarah/100/100.jpg",
          lastMessage: "See you in class tomorrow!",
          lastMessageTime: new Date(Date.now() - 1000 * 60 * 5),
          online: true,
        },
        {
          id: 2,
          name: "Prof. Michael Chen",
          picture: "https://picsum.photos/seed/michael/100/100.jpg",
          lastMessage: "The assignment is due next week",
          lastMessageTime: new Date(Date.now() - 1000 * 60 * 60 * 2),
          online: false,
        },
        {
          id: 3,
          name: "Emily Rodriguez",
          picture: "https://picsum.photos/seed/emily/100/100.jpg",
          lastMessage: "Thanks for your help!",
          lastMessageTime: new Date(Date.now() - 1000 * 60 * 60 * 24),
          online: true,
        },
        {
          id: 4,
          name: "Study Group",
          picture: null,
          lastMessage: "John: Anyone up for a study session?",
          lastMessageTime: new Date(Date.now() - 1000 * 60 * 60 * 3),
          online: false,
        },
      ]);
      const messages = ref([]);
      const newMessage = ref("");

      // Beautiful notifications state
      const notifications = ref([]);
      let notificationId = 0;

      // API base URL
      const API_BASE_URL = "http://localhost:8000/api";

      // Computed properties
      const userInitials = computed(() => {
        if (!userProfile.value.name) return "U";
        return userProfile.value.name
          .split(" ")
          .map((part) => part.charAt(0))
          .join("")
          .substring(0, 2)
          .toUpperCase();
      });

      const filteredContacts = computed(() => {
        if (!chatSearchQuery.value) return contacts.value;
        const query = chatSearchQuery.value.toLowerCase();
        return contacts.value.filter((contact) =>
          contact.name.toLowerCase().includes(query)
        );
      });

      // Methods
      const setActiveTab = (tabId) => {
        activeTab.value = tabId;
        if (tabId === "courses" && courses.value.length === 0) {
          fetchUserCourses();
        }
      };

      const getStatusBadgeClass = (status) => {
        switch (status) {
          case "approved":
            return "badge-success";
          case "pending":
            return "badge-warning";
          case "rejected":
            return "badge-danger";
          default:
            return "badge-secondary";
        }
      };

      const triggerFileUpload = () => {
        fileInput.value.click();
      };

      // Force image reload
      const forceImageReload = () => {
        imageKey.value += 1;
      };

      // Handle image error
      const handleImageError = (event) => {
        console.error(
          "Failed to load profile image reload again please :",
          event.target.src
        );
        // Fallback to placeholder
        userProfile.value.picture = null;
      };

      // Profile.vue mein handleFileUpload function mein yeh code add karein
      const handleFileUpload = async (event) => {
        const file = event.target.files[0];
        if (file) {
          try {
            const formData = new FormData();
            formData.append("profile_picture", file);
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const response = await axios.post(
              `${API_BASE_URL}/profile/picture`,
              formData,
              {
                headers: {
                  "X-CSRF-TOKEN": csrfToken,
                  "Content-Type": "multipart/form-data",
                },
                withCredentials: true,
              }
            );
            console.log("Server response:", response.data);
            if (response.data.picture_url) {
              // Add timestamp to prevent caching
              const timestamp = new Date().getTime();
              const pictureUrl = `${response.data.picture_url}?t=${timestamp}`;
              console.log("Updated picture URL:", pictureUrl);
              // Update local state
              userProfile.value.picture = pictureUrl;
              // Update localStorage
              const userData = JSON.parse(localStorage.getItem("userData") || "{}");
              userData.picture = pictureUrl;
              localStorage.setItem("userData", JSON.stringify(userData));
              // Emit event to update navbar
              window.dispatchEvent(
                new CustomEvent("userProfileUpdated", {
                  detail: { picture: pictureUrl },
                })
              );
              // Force image reload
              forceImageReload();
              // Check if the image is accessible
              const img = new Image();
              img.onload = function () {
                console.log("Image loaded successfully");
              };
              img.onerror = function () {
                console.error("Failed to load image from URL:", pictureUrl);
              };
              img.src = pictureUrl;
              addNotification("Profile picture updated successfully", "success");
            }
          } catch (error) {
            console.error("Error uploading profile picture:", error);
            addNotification("Failed to upload profile picture", "error");
          }
        }
      };

      const updateAccount = async () => {
        try {
          const token = localStorage.getItem("token") || "";
          // Get CSRF token from meta tag
          const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
          const csrfToken = csrfTokenElement
            ? csrfTokenElement.getAttribute("content")
            : "";
          console.log("Sending update request with data:", {
            name: `${accountForm.value.firstName} ${accountForm.value.lastName}`,
            email: accountForm.value.email,
            phone: accountForm.value.phone,
            bio: accountForm.value.bio,
          });
          const response = await axios.post(
            `${API_BASE_URL}/profile/update`,
            {
              name: `${accountForm.value.firstName} ${accountForm.value.lastName}`,
              email: accountForm.value.email,
              phone: accountForm.value.phone,
              bio: accountForm.value.bio,
            },
            {
              headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
              },
              withCredentials: true,
            }
          );
          console.log("Update response:", response.data);
          if (response.data.user) {
            // Update the user profile in the frontend
            userProfile.value = {
              ...userProfile.value,
              name: response.data.user.name,
              email: response.data.user.email,
              phone: response.data.user.phone,
              bio: response.data.user.bio,
            };
            // Update localStorage
            const userData = JSON.parse(localStorage.getItem("userData") || "{}");
            userData.name = response.data.user.name;
            userData.email = response.data.user.email;
            userData.phone = response.data.user.phone;
            userData.bio = response.data.user.bio;
            localStorage.setItem("userData", JSON.stringify(userData));
            addNotification("Account information updated successfully", "success");
          }
        } catch (error) {
          console.error("Error updating account:", error);
          // More detailed error logging
          if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            console.error("Error response data:", error.response.data);
            console.error("Error response status:", error.response.status);
            console.error("Error response headers:", error.response.headers);
            if (error.response.data && error.response.data.message) {
              addNotification(error.response.data.message, "error");
            } else if (error.response.data && error.response.data.errors) {
              // Handle validation errors
              const errorMessages = Object.values(error.response.data.errors).flat();
              addNotification(errorMessages.join(", "), "error");
            } else {
              addNotification(`Server error: ${error.response.status}`, "error");
            }
          } else if (error.request) {
            // The request was made but no response was received
            console.error("Error request:", error.request);
            addNotification(
              "No response from server. Please check your connection.",
              "error"
            );
          } else {
            // Something happened in setting up the request that triggered an Error
            console.error("Error message:", error.message);
            addNotification("Error updating account: " + error.message, "error");
          }
        }
      };

      const checkPasswordStrength = () => {
        const password = passwordForm.value.newPassword;
        let strength = 0;
        if (password.length >= 8) strength += 1;
        if (password.match(/[a-z]+/)) strength += 1;
        if (password.match(/[A-Z]+/)) strength += 1;
        if (password.match(/[0-9]+/)) strength += 1;
        if (password.match(/[$@#&!]+/)) strength += 1;
        if (strength <= 2) {
          passwordStrengthClass.value = "strength-weak";
          passwordStrengthText.value = "Weak password";
          passwordStrengthTextColor.value = "text-red-500";
        } else if (strength <= 3) {
          passwordStrengthClass.value = "strength-medium";
          passwordStrengthText.value = "Medium password";
          passwordStrengthTextColor.value = "text-yellow-500";
        } else {
          passwordStrengthClass.value = "strength-strong";
          passwordStrengthText.value = "Strong password";
          passwordStrengthTextColor.value = "text-green-500";
        }
      };

      const changePassword = async () => {
        if (passwordForm.value.newPassword !== passwordForm.value.confirmPassword) {
          addNotification("Passwords do not match", "error");
          return;
        }
        try {
          const token = localStorage.getItem("token") || "";
          const response = await axios.post(
            `${API_BASE_URL}/change-password`,
            {
              currentPassword: passwordForm.value.currentPassword,
              newPassword: passwordForm.value.newPassword,
            },
            {
              headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/json",
              },
            }
          );
          if (response.data.success) {
            passwordForm.value = {
              currentPassword: "",
              newPassword: "",
              confirmPassword: "",
            };
            addNotification("Password changed successfully", "success");
          } else {
            addNotification(
              response.data.message || "Failed to change password",
              "error"
            );
          }
        } catch (error) {
          console.error("Error changing password:", error);
          if (error.response && error.response.data) {
            addNotification(
              error.response.data.message || "Failed to change password",
              "error"
            );
          } else {
            addNotification("Network error. Please try again later.", "error");
          }
        }
      };

      const goToForgotPassword = () => {
        window.location.href = "http://localhost:8000/forgot-password";
      };

      const toggleTwoFactor = () => {
        twoFactorEnabled.value = !twoFactorEnabled.value;
        addNotification(
          `Two-factor authentication ${
            twoFactorEnabled.value ? "enabled" : "disabled"
          } successfully`,
          "success"
        );
      };

      const resetPassword = () => {
        showForgotPasswordModal.value = false;
        addNotification("Password reset link sent to your email", "success");
      };

      const fetchUserCourses = async () => {
        coursesLoading.value = true;
        try {
          const token = localStorage.getItem("token") || "";
          // Use the correct endpoint - /api/courses
          const response = await axios.get(`${API_BASE_URL}/courses`, {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          console.log("Courses API response:", response.data);
          if (response.data && Array.isArray(response.data)) {
            courses.value = response.data.map((course) => ({
              id: course.id,
              title: course.name,
              instructor: course.admin?.name || "Unknown Instructor",
              thumbnail: course.youtube_url
                ? `https://img.youtube.com/vi/${getYoutubeVideoId(
                    course.youtube_url
                  )}/0.jpg`
                : course.video_path
                ? `https://via.placeholder.com/300x160?text=Course+Video`
                : "https://picsum.photos/300/160?text=No+Thumbnail",
              progress:
                course.progress?.status === "completed"
                  ? 100
                  : course.progress?.status === "in-progress"
                  ? 50
                  : 0,
              duration: course.duration || "N/A",
              lessons: 1,
              video_path: course.video_path,
              youtube_url: course.youtube_url,
              status: course.progress?.status || "pending",
              created_at: course.created_at,
            }));
            // Update stats
            stats.value.courses = courses.value.length;
            stats.value.hours = courses.value.reduce(
              (total, course) => total + (course.duration_hours || 0),
              0
            );
            stats.value.certificates = courses.value.filter(
              (course) => course.progress === 100
            ).length;
          } else {
            console.error("Unexpected courses response format:", response.data);
            courses.value = [];
            addNotification("Failed to fetch courses", "error");
          }
        } catch (error) {
          console.error("Error fetching courses:", error);
          if (error.response && error.response.data) {
            addNotification(
              error.response.data.message || "Failed to fetch courses",
              "error"
            );
          } else {
            addNotification("Network error. Please try again later.", "error");
          }
        } finally {
          coursesLoading.value = false;
        }
      };

      const getYoutubeVideoId = (url) => {
        if (!url) return "";
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        const match = url.match(regExp);
        return match && match[2].length === 11 ? match[2] : "";
      };

      const viewCourseLectures = async (courseId) => {
        selectedCourse.value = courses.value.find((c) => c.id === courseId);
        showLecturesModal.value = true;
        lecturesLoading.value = true;
        try {
          const token = localStorage.getItem("token") || "";
          // Fetch lectures for this course
          const response = await axios.get(
            `${API_BASE_URL}/courses/${courseId}/lectures`,
            {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            }
          );
          console.log("Lectures API response:", response.data);
          if (response.data && Array.isArray(response.data)) {
            lectures.value = response.data.map((lecture) => ({
              id: lecture.id,
              title: lecture.name,
              description: lecture.description || "No description available",
              duration: lecture.duration || "N/A",
              created_at: lecture.created_at,
              video_path: lecture.video_path,
              youtube_url: lecture.youtube_url,
              status: lecture.progress?.status || "pending",
            }));
          } else {
            console.error("Unexpected lectures response format:", response.data);
            lectures.value = [];
          }
        } catch (error) {
          console.error("Error fetching lectures:", error);
          // Fallback to using selected course data
          if (selectedCourse.value) {
            lectures.value = [
              {
                id: selectedCourse.value.id,
                title: selectedCourse.value.title,
                description: "Course content",
                duration: selectedCourse.value.duration,
                created_at: selectedCourse.value.created_at,
                video_path: selectedCourse.value.video_path,
                youtube_url: selectedCourse.value.youtube_url,
                status: selectedCourse.value.status,
              },
            ];
          } else {
            lectures.value = [];
          }
          if (error.response && error.response.data) {
            addNotification(
              error.response.data.message || "Failed to fetch lectures",
              "error"
            );
          } else {
            addNotification("Network error. Please try again later.", "error");
          }
        } finally {
          lecturesLoading.value = false;
        }
      };

      const watchLecture = (lectureId) => {
        const lecture = lectures.value.find((l) => l.id === lectureId);
        if (lecture) {
          selectedVideo.value = lecture;
          showVideoModal.value = true;
          console.log("Selected video:", lecture);
        } else {
          addNotification("Lecture not found", "error");
        }
      };

      const closeVideoModal = () => {
        showVideoModal.value = false;
        selectedVideo.value = null;
      };

      // Chat methods
      const selectContact = (contact) => {
        selectedContact.value = contact;
        loadMessages(contact.id);
      };

      const loadMessages = (contactId) => {
        messages.value = [
          {
            text: "Hello there!",
            sent: false,
            timestamp: new Date(Date.now() - 1000 * 60 * 60 * 2),
          },
          {
            text: "Hi! How can I help you today?",
            sent: true,
            timestamp: new Date(Date.now() - 1000 * 60 * 60 * 2 + 1000 * 30),
          },
          {
            text: "I have a question about the assignment",
            sent: false,
            timestamp: new Date(Date.now() - 1000 * 60 * 60),
          },
        ];
        nextTick(() => {
          if (messagesContainer.value) {
            messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
          }
        });
      };

      const sendMessage = () => {
        if (!newMessage.value.trim() || !selectedContact.value) return;
        messages.value.push({
          text: newMessage.value,
          sent: true,
          timestamp: new Date(),
        });
        newMessage.value = "";
        nextTick(() => {
          if (messagesContainer.value) {
            messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
          }
        });
        setTimeout(() => {
          messages.value.push({
            text: "Thanks for your message! I'll get back to you soon.",
            sent: false,
            timestamp: new Date(),
          });
          const contactIndex = contacts.value.findIndex(
            (c) => c.id === selectedContact.value.id
          );
          if (contactIndex !== -1) {
            contacts.value[contactIndex].lastMessage =
              "Thanks for your message! I'll get back to you soon.";
            contacts.value[contactIndex].lastMessageTime = new Date();
          }
          nextTick(() => {
            if (messagesContainer.value) {
              messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
            }
          });
        }, 1000);
      };

      const clearChat = () => {
        if (confirm("Are you sure you want to clear this conversation?")) {
          messages.value = [];
          addNotification("Chat cleared", "success");
        }
      };

      const getContactInitials = (name) => {
        if (!name) return "U";
        return name
          .split(" ")
          .map((part) => part.charAt(0))
          .join("")
          .substring(0, 2)
          .toUpperCase();
      };

      const confirmDeleteAccount = () => {
        showDeleteAccountModal.value = true;
      };

      const deleteAccount = () => {
        showDeleteAccountModal.value = false;
        addNotification(
          "Account deletion initiated. You will receive a confirmation email.",
          "success"
        );
        setTimeout(() => {
          localStorage.removeItem("userData");
          router.push("/login");
        }, 2000);
      };

      const formatDate = (date) => {
        return new Date(date).toLocaleDateString("en-US", {
          year: "numeric",
          month: "long",
          day: "numeric",
        });
      };

      const formatTime = (date) => {
        const now = new Date();
        const messageDate = new Date(date);
        const diffMs = now - messageDate;
        const diffMins = Math.floor(diffMs / 60000);
        if (diffMins < 1) return "Just now";
        if (diffMins < 60) return `${diffMins}m ago`;
        const diffHours = Math.floor(diffMins / 60);
        if (diffHours < 24) return `${diffHours}h ago`;
        const diffDays = Math.floor(diffHours / 24);
        if (diffDays < 7) return `${diffDays}d ago`;
        return formatDate(messageDate);
      };

      // Beautiful notification functions
      const addNotification = (
        message,
        type = "success",
        position = "top-right",
        duration = 3000
      ) => {
        const id = ++notificationId;
        notifications.value.push({
          id,
          message,
          type,
          position,
          duration,
        });

        // Auto remove after duration
        setTimeout(() => {
          removeNotification(id);
        }, duration);
      };

      const removeNotification = (id) => {
        const index = notifications.value.findIndex((n) => n.id === id);
        if (index !== -1) {
          notifications.value.splice(index, 1);
        }
      };

      // Load user data on component mount
      onMounted(() => {
        const userData = localStorage.getItem("userData");
        if (userData) {
          try {
            const parsedData = JSON.parse(userData);
            userProfile.value = {
              name: parsedData.name || "User",
              email: parsedData.email || "",
              role: parsedData.role || "Student",
              status: parsedData.status || "pending",
              picture: parsedData.picture || null,
              phone: parsedData.phone || "",
              bio: parsedData.bio || "",
            };
            const nameParts = userProfile.value.name.split(" ");
            accountForm.value = {
              firstName: nameParts[0] || "",
              lastName: nameParts.slice(1).join(" ") || "",
              email: userProfile.value.email || "",
              phone: userProfile.value.phone || "",
              bio: userProfile.value.bio || "",
            };
            forgotPasswordForm.value.email = userProfile.value.email || "";
          } catch (e) {
            console.error("Failed to parse user data:", e);
          }
        }
        fetchUserCourses();
      });

      return {
        userProfile,
        activeTab,
        showForgotPasswordModal,
        showDeleteAccountModal,
        showLecturesModal,
        showVideoModal,
        selectedCourse,
        selectedVideo,
        lectures,
        lecturesLoading,
        fileInput,
        twoFactorEnabled,
        imageKey,
        stats,
        accountForm,
        passwordForm,
        forgotPasswordForm,
        passwordStrengthClass,
        passwordStrengthText,
        passwordStrengthTextColor,
        tabs,
        courses,
        coursesLoading,
        achievements,
        chatSearchQuery,
        selectedContact,
        contacts,
        filteredContacts,
        messages,
        newMessage,
        messagesContainer,
        notifications,
        userInitials,
        setActiveTab,
        getStatusBadgeClass,
        triggerFileUpload,
        handleFileUpload,
        updateAccount,
        checkPasswordStrength,
        changePassword,
        goToForgotPassword,
        toggleTwoFactor,
        resetPassword,
        viewCourseLectures,
        watchLecture,
        closeVideoModal,
        selectContact,
        sendMessage,
        clearChat,
        getContactInitials,
        confirmDeleteAccount,
        deleteAccount,
        formatDate,
        formatTime,
        getYoutubeVideoId,
        forceImageReload,
        handleImageError,
        addNotification,
        removeNotification,
      };
    },
  };
</script>

<style scoped>
  .profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
  }

  /* Profile Header Styles */
  .profile-header {
    position: relative;
    margin-bottom: 2rem;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .header-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    z-index: 1;
  }

  .header-background::before {
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
    animation: pulse 4s infinite ease-in-out;
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

  .header-content {
    position: relative;
    z-index: 2;
    padding: 2rem;
    color: white;
  }

  .avatar-section {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
  }

  .avatar-container {
    position: relative;
    width: 120px;
    height: 120px;
    margin-right: 2rem;
  }

  .avatar,
  .avatar-placeholder {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .avatar-placeholder {
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: bold;
    color: white;
  }

  .avatar-upload {
    position: absolute;
    bottom: 0;
    right: 0;
    background: white;
    color: #667eea;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
  }

  .avatar-upload:hover {
    background: #f3f4f6;
    transform: scale(1.1);
  }

  .profile-info {
    flex: 1;
  }

  .profile-name {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }

  .profile-email {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 1rem;
  }

  .profile-badges {
    display: flex;
    gap: 0.5rem;
  }

  .badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    font-size: 0.875rem;
    font-weight: 500;
  }

  .badge-role {
    background: rgba(255, 255, 255, 0.2);
  }

  .badge-success {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
  }

  .badge-warning {
    background: rgba(245, 158, 11, 0.2);
    color: #f59e0b;
  }

  .badge-danger {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
  }

  .badge-secondary {
    background: rgba(107, 114, 128, 0.2);
    color: #6b7280;
  }

  .profile-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
  }

  .stat-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 0.75rem;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
  }

  .stat-card:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
  }

  .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 0.75rem;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 1rem;
  }

  .stat-content {
    flex: 1;
  }

  .stat-value {
    font-size: 1.75rem;
    font-weight: bold;
    margin-bottom: 0.25rem;
  }

  .stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
  }

  /* Profile Content Styles */
  .profile-content {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 2rem;
  }

  .profile-sidebar {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
    height: fit-content;
  }

  .sidebar-section {
    margin-bottom: 2rem;
  }

  .sidebar-section:last-child {
    margin-bottom: 0;
  }

  .sidebar-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #1f2937;
  }

  .action-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .action-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    background: transparent;
    border: none;
    color: #4b5563;
    font-weight: 500;
    text-align: left;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .action-btn:hover {
    background: #f3f4f6;
    color: #4f46e5;
  }

  .action-btn.active {
    background: #ede9fe;
    color: #7c3aed;
  }

  .action-btn-danger {
    color: #ef4444;
  }

  .action-btn-danger:hover {
    background: #fee2e2;
    color: #ef4444;
  }

  .profile-main {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    overflow: hidden;
  }

  /* Tab Navigation Styles */
  .tab-navigation {
    display: flex;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
  }

  .tab-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    font-weight: 500;
    color: #6b7280;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
  }

  .tab-item:hover {
    color: #4f46e5;
  }

  .tab-item.active {
    color: #4f46e5;
    border-bottom-color: #4f46e5;
  }

  /* Tab Content Styles */
  .tab-content {
    padding: 0 1.5rem 1.5rem;
  }

  .tab-pane {
    animation: fadeIn 0.3s ease;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .form-container {
    max-width: 800px;
    margin: 0 auto;
  }

  .form-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: #1f2937;
  }

  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-label {
    display: block;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #374151;
  }

  .form-input,
  .form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
  }

  .form-input:focus,
  .form-textarea:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
  }

  .form-textarea {
    resize: vertical;
    min-height: 100px;
  }

  .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    margin-top: 1rem;
  }

  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
  }

  .btn-primary {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #4338ca, #6d28d9);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
  }

  .btn-secondary {
    background: #f3f4f6;
    color: #4b5563;
  }

  .btn-secondary:hover {
    background: #e5e7eb;
  }

  .btn-danger {
    background: #fee2e2;
    color: #ef4444;
  }

  .btn-danger:hover {
    background: #fecaca;
  }

  .btn-icon {
    padding: 0.5rem;
    border-radius: 50%;
    width: 36px;
    height: 36px;
  }

  .btn-block {
    width: 100%;
  }

  /* Security Section Styles */
  .security-section {
    margin-bottom: 2rem;
  }

  .security-section:last-child {
    margin-bottom: 0;
  }

  .security-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #1f2937;
  }

  .security-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-radius: 0.75rem;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
  }

  .security-card-info {
    background: #eff6ff;
    border-color: #bfdbfe;
  }

  .security-info {
    flex: 1;
  }

  .security-card-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #1f2937;
  }

  .security-card-description {
    color: #6b7280;
    font-size: 0.875rem;
  }

  /* Password Strength Styles */
  .password-strength {
    height: 4px;
    border-radius: 2px;
    margin-top: 0.5rem;
    background: #e5e7eb;
    overflow: hidden;
  }

  .password-strength-meter {
    height: 100%;
    width: 0;
    transition: width 0.3s ease, background-color 0.3s ease;
  }

  .strength-weak {
    background: #ef4444;
    width: 33.33%;
  }

  .strength-medium {
    background: #f59e0b;
    width: 66.66%;
  }

  .strength-strong {
    background: #10b981;
    width: 100%;
  }

  .password-strength-text {
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }

  /* Courses Section Styles */
  .courses-container {
    max-width: 100%;
  }

  .courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
  }

  .course-card {
    background: white;
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
  }

  .course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  }

  .course-thumbnail {
    position: relative;
    height: 160px;
    overflow: hidden;
  }

  .course-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .course-progress-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
    padding: 0.75rem;
    color: white;
    font-weight: 500;
    font-size: 0.875rem;
  }

  .course-content {
    padding: 1.5rem;
  }

  .course-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #1f2937;
  }

  .course-instructor {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 1rem;
  }

  .course-progress-bar {
    height: 6px;
    background: #e5e7eb;
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 1rem;
  }

  .course-progress-fill {
    height: 100%;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border-radius: 3px;
  }

  .course-meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    color: #6b7280;
  }

  .course-actions {
    display: flex;
    justify-content: center;
  }

  /* Lectures Modal Styles */
  .modal-large {
    max-width: 800px;
    width: 90%;
  }

  .loading-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
  }

  .loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f4f6;
    border-top: 4px solid #4f46e5;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 1rem;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }

  .lectures-list {
    max-height: 400px;
    overflow-y: auto;
  }

  .lecture-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
  }

  .lecture-item:last-child {
    border-bottom: none;
  }

  .lecture-info {
    flex: 1;
  }

  .lecture-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #1f2937;
  }

  .lecture-description {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
  }

  .lecture-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.75rem;
    color: #6b7280;
  }

  /* Empty State Styles */
  .empty-state {
    text-align: center;
    padding: 3rem 1rem;
  }

  .empty-icon {
    font-size: 3rem;
    color: #d1d5db;
    margin-bottom: 1rem;
  }

  .empty-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #4b5563;
  }

  .empty-description {
    color: #6b7280;
    margin-bottom: 1.5rem;
  }

  /* Achievements Section Styles */
  .achievements-container {
    max-width: 100%;
  }

  .achievements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
  }

  .achievement-card {
    background: white;
    border-radius: 0.75rem;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    text-align: center;
    transition: all 0.3s ease;
  }

  .achievement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  }

  .achievement-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #9ca3af;
    margin: 0 auto 1rem;
  }

  .achievement-unlocked {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
  }

  .achievement-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #1f2937;
  }

  .achievement-description {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 1rem;
  }

  .achievement-date {
    font-size: 0.75rem;
    color: #10b981;
    font-weight: 500;
  }

  .achievement-progress {
    height: 6px;
    background: #e5e7eb;
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 0.5rem;
  }

  .achievement-progress-fill {
    height: 100%;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border-radius: 3px;
  }

  .achievement-progress-text {
    font-size: 0.75rem;
    color: #6b7280;
  }

  /* Chat Styles */
  .chat-container {
    max-width: 100%;
  }

  .chat-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 1.5rem;
    height: 600px;
  }

  .chat-contacts {
    background: #f9fafb;
    border-radius: 0.75rem;
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }

  .chat-search {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
  }

  .contacts-list {
    flex: 1;
    overflow-y: auto;
  }

  .contact-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }

  .contact-item:hover {
    background: #f3f4f6;
  }

  .contact-item.active {
    background: #ede9fe;
  }

  .contact-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 1rem;
  }

  .contact-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .contact-avatar-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
  }

  .contact-info {
    flex: 1;
    min-width: 0;
  }

  .contact-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .contact-preview {
    font-size: 0.875rem;
    color: #6b7280;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .contact-time {
    font-size: 0.75rem;
    color: #9ca3af;
    margin-left: 0.5rem;
  }

  .chat-messages {
    background: white;
    border-radius: 0.75rem;
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }

  .chat-conversation {
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .chat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
  }

  .chat-contact-info {
    display: flex;
    align-items: center;
  }

  .contact-status {
    font-size: 0.75rem;
    color: #6b7280;
  }

  .messages-container {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
  }

  .message {
    display: flex;
    margin-bottom: 1rem;
  }

  .message-sent {
    justify-content: flex-end;
  }

  .message-received {
    justify-content: flex-start;
  }

  .message-content {
    max-width: 70%;
  }

  .message-sent .message-content {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    border-radius: 1rem 1rem 0 1rem;
    padding: 0.75rem 1rem;
  }

  .message-received .message-content {
    background: #f3f4f6;
    color: #1f2937;
    border-radius: 1rem 1rem 1rem 0;
    padding: 0.75rem 1rem;
  }

  .message-text {
    margin-bottom: 0.25rem;
  }

  .message-time {
    font-size: 0.75rem;
    opacity: 0.7;
  }

  .chat-input-container {
    padding: 1rem;
    border-top: 1px solid #e5e7eb;
  }

  .chat-input-wrapper {
    display: flex;
    align-items: center;
    background: #f9fafb;
    border-radius: 2rem;
    padding: 0.5rem 1rem;
  }

  .chat-input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-size: 1rem;
  }

  /* Modal Styles */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
  }

  .modal-container {
    background: white;
    border-radius: 1rem;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    animation: modalFadeIn 0.3s ease;
  }

  @keyframes modalFadeIn {
    from {
      transform: translateY(-50px);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
  }

  .modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
  }

  .modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #6b7280;
    cursor: pointer;
    transition: color 0.3s ease;
  }

  .modal-close:hover {
    color: #1f2937;
  }

  .modal-body {
    padding: 1.5rem;
  }

  .modal-description {
    color: #4b5563;
    margin-bottom: 1.5rem;
  }

  .alert {
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
  }

  .alert-warning {
    background: #fffbeb;
    color: #92400e;
    border-left: 4px solid #f59e0b;
  }

  /* Beautiful Notification Toast Styles */
  .notification-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 0;
    z-index: 9999;
    pointer-events: none;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .notification-toast {
    position: absolute;
    padding: 1.25rem 1.75rem;
    border-radius: 1rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 10px 25px rgba(0, 0, 0, 0.1);
    z-index: 9999;
    display: flex;
    align-items: center;
    min-width: 320px;
    max-width: 480px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    overflow: hidden;
    pointer-events: all;
    backdrop-filter: blur(16px);
    transform-origin: top center;
  }

  /* Position classes */
  .notification-position-top-right {
    top: 20px;
    right: 20px;
  }

  .notification-position-top-left {
    top: 20px;
    left: 20px;
  }

  .notification-position-top-center {
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
  }

  /* Type classes */
  .notification-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 50%, #6ee7b7 100%);
    color: #064e3b;
    border: 1px solid rgba(16, 185, 129, 0.3);
    box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3), 0 10px 25px rgba(16, 185, 129, 0.2);
  }

  .notification-error {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 50%, #fca5a5 100%);
    color: #7f1d1d;
    border: 1px solid rgba(239, 68, 68, 0.3);
    box-shadow: 0 20px 40px rgba(239, 68, 68, 0.3), 0 10px 25px rgba(239, 68, 68, 0.2);
  }

  .notification-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 50%, #fcd34d 100%);
    color: #78350f;
    border: 1px solid rgba(245, 158, 11, 0.3);
    box-shadow: 0 20px 40px rgba(245, 158, 11, 0.3), 0 10px 25px rgba(245, 158, 11, 0.2);
  }

  .notification-info {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 50%, #93c5fd 100%);
    color: #1e3a8a;
    border: 1px solid rgba(59, 130, 246, 0.3);
    box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3), 0 10px 25px rgba(59, 130, 246, 0.2);
  }

  /* Animations */
  .notification-list-enter-active,
  .notification-list-leave-active {
    transition: all 0.5s ease;
  }

  .notification-list-enter-from {
    transform: translateY(-100%) scale(0.8) rotate(-2deg);
    opacity: 0;
    filter: blur(10px);
  }

  .notification-list-leave-to {
    transform: translateY(-100%) scale(0.8) rotate(2deg);
    opacity: 0;
    filter: blur(5px);
  }

  /* Decorative elements */
  .notification-toast::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -30%;
    width: 150%;
    height: 150%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 60%);
    animation: rotate 25s linear infinite;
    z-index: -1;
  }

  @keyframes rotate {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(360deg);
    }
  }

  /* Icon styling */
  .notification-content {
    display: flex;
    align-items: center;
    width: 100%;
    position: relative;
    z-index: 1;
  }

  .notification-icon {
    margin-right: 1.25rem;
    font-size: 1.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    animation: iconBounce 0.6s ease-out;
  }

  @keyframes iconBounce {
    0% {
      transform: scale(0) rotate(-45deg);
    }
    50% {
      transform: scale(1.2) rotate(5deg);
    }
    100% {
      transform: scale(1) rotate(0deg);
    }
  }

  .notification-icon::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
      45deg,
      transparent 30%,
      rgba(255, 255, 255, 0.3) 50%,
      transparent 70%
    );
    transform: translateX(-100%);
    animation: shimmer 2.5s infinite;
  }

  @keyframes shimmer {
    100% {
      transform: translateX(100%);
    }
  }

  .notification-success .notification-icon {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    box-shadow: 0 10px 20px rgba(16, 185, 129, 0.4),
      inset 0 2px 4px rgba(255, 255, 255, 0.3);
  }

  .notification-error .notification-icon {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    box-shadow: 0 10px 20px rgba(239, 68, 68, 0.4),
      inset 0 2px 4px rgba(255, 255, 255, 0.3);
  }

  .notification-warning .notification-icon {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    box-shadow: 0 10px 20px rgba(245, 158, 11, 0.4),
      inset 0 2px 4px rgba(255, 255, 255, 0.3);
  }

  .notification-info .notification-icon {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4),
      inset 0 2px 4px rgba(255, 255, 255, 0.3);
  }

  /* Message styling */
  .notification-message {
    font-weight: 700;
    font-size: 1rem;
    line-height: 1.5;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    animation: messageSlide 0.8s ease-out;
  }

  @keyframes messageSlide {
    from {
      transform: translateX(-20px);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  /* Close button */
  .notification-close {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: inherit;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0.7;
    transition: all 0.2s ease;
    font-size: 14px;
    z-index: 2;
  }

  .notification-close:hover {
    opacity: 1;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
  }

  /* Progress bar */
  .notification-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 100%;
    background: rgba(255, 255, 255, 0.3);
    animation: progressBar 3s linear forwards;
    border-radius: 0 0 1rem 1rem;
  }

  @keyframes progressBar {
    from {
      width: 100%;
    }
    to {
      width: 0%;
    }
  }

  /* Enhanced animations for success notifications */
  .notification-success {
    animation: iconBounce 0.6s ease-out, successGlow 4s ease-in-out infinite 1.5s,
      gentleFloat 8s ease-in-out infinite 2.5s;
  }

  @keyframes successGlow {
    0%,
    100% {
      box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3), 0 10px 25px rgba(16, 185, 129, 0.2);
    }
    50% {
      box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4), 0 10px 25px rgba(16, 185, 129, 0.3),
        0 0 40px rgba(16, 185, 129, 0.4);
    }
  }

  @keyframes gentleFloat {
    0%,
    100% {
      transform: translateY(0);
    }
    50% {
      transform: translateY(-8px);
    }
  }

  /* Mobile responsiveness */
  @media (max-width: 768px) {
    .notification-toast {
      min-width: auto;
      max-width: none;
      padding: 1rem 1.25rem;
      margin: 10px;
    }

    .notification-icon {
      width: 40px;
      height: 40px;
      font-size: 1.5rem;
      margin-right: 1rem;
    }

    .notification-message {
      font-size: 0.9rem;
    }

    .notification-position-top-right,
    .notification-position-top-left {
      top: 10px;
      right: 10px;
      left: 10px;
    }

    .notification-position-top-center {
      top: 10px;
      left: 50%;
      transform: translateX(-50%);
    }
  }

  /* Other existing styles */
  @media (max-width: 768px) {
    .profile-container {
      padding: 1rem;
    }
    .avatar-section {
      flex-direction: column;
      text-align: center;
    }
    .avatar-container {
      margin-right: 0;
      margin-bottom: 1rem;
    }
    .profile-stats {
      grid-template-columns: repeat(2, 1fr);
    }
    .form-row {
      grid-template-columns: 1fr;
    }
    .courses-grid,
    .achievements-grid {
      grid-template-columns: 1fr;
    }
    .security-card {
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }
    .chat-layout {
      grid-template-columns: 1fr;
      height: auto;
    }
    .chat-contacts {
      border-radius: 0.75rem 0.75rem 0 0;
    }
    .chat-messages {
      border-radius: 0 0.75rem 0.75rem 0;
    }
  }

  .video-container {
    width: 100%;
    margin-bottom: 1.5rem;
  }

  .video-embed {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
    border-radius: 0.75rem;
  }

  .video-embed iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
  }

  .video-player {
    width: 100%;
    border-radius: 0.75rem;
    overflow: hidden;
  }

  .video-element {
    width: 100%;
    height: auto;
    max-height: 70vh;
  }

  .video-error {
    text-align: center;
    padding: 3rem 1rem;
  }

  .video-info {
    padding: 1rem;
    background: #f9fafb;
    border-radius: 0.75rem;
  }

  .video-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #1f2937;
  }

  .video-description {
    color: #6b7280;
    margin-bottom: 1rem;
  }

  .video-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    color: #6b7280;
  }

  .modal-large {
    max-width: 900px;
    width: 90%;
  }
</style>
