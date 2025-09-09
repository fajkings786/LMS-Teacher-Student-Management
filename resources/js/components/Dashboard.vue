<template>
  <div class="dashboard-container">
    <div class="dashboard-header">
      <h1>Dashboard</h1>
      <p>Welcome back, {{ userProfile.name }}!</p>
    </div>

    <div class="dashboard-content">
      <div class="profile-section">
        <h2>Your Profile</h2>
        <div class="profile-card">
          <div class="profile-avatar">
            <img v-if="userProfile.picture" :src="userProfile.picture" alt="Profile" />
            <span v-else class="avatar-placeholder">{{ userInitials }}</span>
          </div>
          <div class="profile-info">
            <div class="info-item">
              <span class="label">Name:</span>
              <span>{{ userProfile.name }}</span>
            </div>
            <div class="info-item">
              <span class="label">Email:</span>
              <span>{{ userProfile.email }}</span>
            </div>
            <div class="info-item">
              <span class="label">Role:</span>
              <span>{{ userProfile.role }}</span>
            </div>
            <div class="info-item">
              <span class="label">Status:</span>
              <span :class="userProfile.status">{{ userProfile.status }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="dashboard-stats">
        <h2>Your Statistics</h2>
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon">📚</div>
            <div class="stat-info">
              <h3>Courses</h3>
              <p>{{ userStats.courses }}</p>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">📝</div>
            <div class="stat-info">
              <h3>Assignments</h3>
              <p>{{ userStats.assignments }}</p>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
              <h3>Completed</h3>
              <p>{{ userStats.completed }}</p>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">🏆</div>
            <div class="stat-info">
              <h3>Achievements</h3>
              <p>{{ userStats.achievements }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="recent-activity">
        <h2>Recent Activity</h2>
        <div class="activity-list">
          <div
            v-for="(activity, index) in recentActivities"
            :key="index"
            class="activity-item"
          >
            <div class="activity-icon">{{ activity.icon }}</div>
            <div class="activity-details">
              <h3>{{ activity.title }}</h3>
              <p>{{ activity.description }}</p>
              <span class="activity-time">{{ activity.time }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { ref, computed, onMounted } from "vue";

  export default {
    name: "Dashboard",
    setup() {
      const userProfile = ref({
        name: "",
        email: "",
        role: "",
        status: "",
        picture: null,
      });

      const userStats = ref({
        courses: 0,
        assignments: 0,
        completed: 0,
        achievements: 0,
      });

      const recentActivities = ref([
        {
          icon: "📖",
          title: "Completed Lesson",
          description: "Introduction to Programming",
          time: "2 hours ago",
        },
        {
          icon: "✅",
          title: "Submitted Assignment",
          description: "JavaScript Basics",
          time: "1 day ago",
        },
        {
          icon: "🏆",
          title: "Earned Achievement",
          description: "Quick Learner",
          time: "3 days ago",
        },
        {
          icon: "📚",
          title: "Enrolled in Course",
          description: "Advanced Web Development",
          time: "1 week ago",
        },
      ]);

      const userInitials = computed(() => {
        if (!userProfile.value.name) return "U";
        return userProfile.value.name
          .split(" ")
          .map((part) => part.charAt(0))
          .join("")
          .substring(0, 2)
          .toUpperCase();
      });

      const fetchUserData = async () => {
        try {
          const response = await fetch("/api/user", {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("userToken")}`,
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            },
          });

          if (response.ok) {
            const userData = await response.json();
            userProfile.value = userData;

            // Fetch user stats
            fetchUserStats();
          } else {
            console.error("Failed to fetch user data");
          }
        } catch (error) {
          console.error("Error fetching user data:", error);

          // Fallback to localStorage if API fails
          const userData = localStorage.getItem("userData");
          if (userData) {
            try {
              userProfile.value = JSON.parse(userData);
            } catch (e) {
              console.error("Failed to parse user data:", e);
            }
          }
        }
      };

      const fetchUserStats = async () => {
        try {
          // In a real app, you would fetch this from your API
          // For now, we'll use mock data
          userStats.value = {
            courses: 5,
            assignments: 12,
            completed: 8,
            achievements: 3,
          };
        } catch (error) {
          console.error("Error fetching user stats:", error);
        }
      };

      onMounted(() => {
        fetchUserData();
      });

      return {
        userProfile,
        userStats,
        recentActivities,
        userInitials,
      };
    },
  };
</script>

<style scoped>
  .dashboard-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
  }

  .dashboard-header {
    margin-bottom: 2rem;
  }

  .dashboard-header h1 {
    font-size: 2rem;
    color: #4f46e5;
    margin-bottom: 0.5rem;
  }

  .dashboard-header p {
    color: #6b7280;
    font-size: 1.1rem;
  }

  .dashboard-content {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  .profile-section,
  .dashboard-stats,
  .recent-activity {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
  }

  .profile-section h2,
  .dashboard-stats h2,
  .recent-activity h2 {
    font-size: 1.5rem;
    color: #1f2937;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e5e7eb;
  }

  .profile-card {
    display: flex;
    gap: 1.5rem;
  }

  .profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    flex-shrink: 0;
  }

  .profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .avatar-placeholder {
    font-size: 2.5rem;
    font-weight: bold;
    color: white;
  }

  .profile-info {
    flex: 1;
  }

  .info-item {
    display: flex;
    margin-bottom: 1rem;
  }

  .info-item .label {
    font-weight: 600;
    width: 80px;
    color: #4b5563;
  }

  .info-item span:last-child {
    color: #1f2937;
  }

  .info-item span:last-child.approved {
    color: #10b981;
    font-weight: 500;
  }

  .info-item span:last-child.pending {
    color: #f59e0b;
    font-weight: 500;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
  }

  .stat-card {
    background: #f9fafb;
    border-radius: 8px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .stat-icon {
    font-size: 2rem;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border-radius: 8px;
    color: white;
  }

  .stat-info h3 {
    font-size: 1rem;
    color: #4b5563;
    margin: 0;
  }

  .stat-info p {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
  }

  .activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .activity-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 8px;
    transition: transform 0.2s ease;
  }

  .activity-item:hover {
    transform: translateX(5px);
  }

  .activity-icon {
    font-size: 1.5rem;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border-radius: 8px;
    color: white;
    flex-shrink: 0;
  }

  .activity-details h3 {
    font-size: 1rem;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
  }

  .activity-details p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0 0 0.5rem 0;
  }

  .activity-time {
    font-size: 0.75rem;
    color: #9ca3af;
  }

  @media (max-width: 768px) {
    .profile-card {
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .info-item {
      justify-content: center;
    }

    .stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
</style>
