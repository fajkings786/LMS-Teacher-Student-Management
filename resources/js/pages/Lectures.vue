<script setup>
  import { ref, onMounted } from "vue";
  import axios from "axios";

  const lectures = ref([]);
  const loading = ref(true);
  const featuredCourse = ref(null);

  // Modal state
  const showModal = ref(false);
  const selectedVideo = ref(null);

  // Function to get YouTube thumbnail URL - fixed
  const getYoutubeThumbnail = (youtubeUrl) => {
    if (!youtubeUrl) return null;
    // Extract video ID from YouTube URL (both embed and watch URLs)
    let videoId = null;
    // Handle embed URLs like https://www.youtube.com/embed/VIDEO_ID
    if (youtubeUrl.includes("/embed/")) {
      videoId = youtubeUrl.split("/embed/")[1];
    }
    // Handle watch URLs like https://www.youtube.com/watch?v=VIDEO_ID
    else if (youtubeUrl.includes("watch?v=")) {
      videoId = youtubeUrl.split("watch?v=")[1];
    }
    // Remove any additional parameters after the video ID
    if (videoId && videoId.includes("&")) {
      videoId = videoId.split("&")[0];
    }
    if (videoId) {
      return `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`;
    }
    return null;
  };

  // Function to get thumbnail URL for any course
  const getThumbnailUrl = (course) => {
    if (course.youtube_url) {
      const thumbnail = getYoutubeThumbnail(course.youtube_url);
      if (thumbnail) return thumbnail;
    }
    if (course.thumbnail) {
      return course.thumbnail;
    }
    // Fallback to placeholder
    return `https://picsum.photos/seed/${course.id}/800/450.jpg`;
  };

  // Handle image error
  const handleImageError = (event, courseId) => {
    event.target.src = `https://picsum.photos/seed/${courseId}/800/450.jpg`;
  };

  // Dummy courses data with YouTube links
  const freeCourses = ref([
    {
      id: 101,
      name: "HTML5 Fundamentals",
      admin: { name: "Jane Smith" },
      status: "free",
      youtube_url: "https://www.youtube.com/embed/UB1O30fR-EE",
      description: "Learn the building blocks of web development with HTML5",
      duration: "2h 15m",
      level: "Beginner",
    },
    {
      id: 102,
      name: "CSS3 Mastery",
      admin: { name: "Alex Johnson" },
      status: "free",
      youtube_url: "https://www.youtube.com/embed/yfoY53QXEnI",
      description: "Master modern CSS techniques including Flexbox and Grid",
      duration: "3h 30m",
      level: "Intermediate",
    },
    {
      id: 103,
      name: "JavaScript Essentials",
      admin: { name: "Sarah Williams" },
      status: "free",
      youtube_url: "https://www.youtube.com/embed/W6NZfCO5SIk",
      description: "Learn JavaScript programming from scratch",
      duration: "4h 45m",
      level: "Beginner",
    },
    {
      id: 104,
      name: "Node.js Backend Development",
      admin: { name: "Michael Chen" },
      status: "free",
      youtube_url: "https://www.youtube.com/embed/TlB_eWDSMt4",
      description: "Build scalable backend applications with Node.js",
      duration: "5h 20m",
      level: "Intermediate",
    },
    {
      id: 105,
      name: "Laravel Framework",
      admin: { name: "David Miller" },
      status: "free",
      youtube_url: "https://www.youtube.com/embed/MX8qZzIaP3A",
      description: "Build modern web applications with Laravel PHP framework",
      duration: "6h 10m",
      level: "Intermediate",
    },
  ]);

  // Function to open video modal
  const openVideoModal = (video) => {
    selectedVideo.value = video;
    showModal.value = true;
  };

  // Function to close modal
  const closeModal = () => {
    showModal.value = false;
    selectedVideo.value = null;
  };

  const fetchLectures = async () => {
    // Check if user is logged in using userData instead of token
    const userData = localStorage.getItem("userData");
    if (!userData) {
      console.error("No user data found in localStorage!");
      loading.value = false;
      return;
    }

    try {
      // First get CSRF cookie for session authentication
      await axios.get("/sanctum/csrf-cookie", {
        withCredentials: true,
      });

      // Then fetch lectures using session authentication
      const response = await axios.get("/api/lectures", {
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        withCredentials: true,
      });

      lectures.value = response.data;

      // Set the first course as featured if available
      if (lectures.value.length > 0) {
        featuredCourse.value = lectures.value[0];
      }
    } catch (error) {
      console.error("Error fetching lectures:", error.response?.data || error);

      // If API fails, try the web route as a fallback
      try {
        const webResponse = await axios.get("/my-lectures", {
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
          withCredentials: true,
        });

        // If we get HTML instead of JSON, we need to handle it differently
        if (typeof webResponse.data === "string") {
          console.error("Received HTML instead of JSON. User might need to login again.");
          // You could redirect to login page here
          return;
        }

        lectures.value = webResponse.data;

        // Set the first course as featured if available
        if (lectures.value.length > 0) {
          featuredCourse.value = lectures.value[0];
        }
      } catch (webError) {
        console.error(
          "Error fetching lectures from web route:",
          webError.response?.data || webError
        );
      }
    } finally {
      loading.value = false;
    }
  };

  onMounted(fetchLectures);
</script>

<template>
  <div
    class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 py-8"
  >
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1
            class="text-4xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-800"
          >
            Learning Platform
          </h1>
          <p class="text-gray-600 max-w-2xl">
            Expand your knowledge with our expertly curated courses
          </p>
        </div>
        <!-- New button added here -->
        <button
          @click="openVideoModal(freeCourses[0])"
          class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-700 text-white rounded-xl font-semibold hover:from-purple-700 hover:to-indigo-800 transition-all duration-300 shadow-lg flex items-center transform hover:scale-105"
        >
          <svg
            class="w-5 h-5 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
            ></path>
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            ></path>
          </svg>
          Watch Demo Video
        </button>
      </div>

      <!-- Loading state -->
      <div v-if="loading" class="flex justify-center items-center h-64">
        <div
          class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"
        ></div>
      </div>

      <!-- Content -->
      <div v-else>
        <!-- Featured Course Section -->
        <div v-if="featuredCourse" class="mb-16">
          <h2 class="text-2xl font-semibold mb-6 text-indigo-700 flex items-center">
            <svg
              class="w-6 h-6 mr-2 text-purple-600"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
              ></path>
            </svg>
            Featured Course
          </h2>
          <div
            class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl transform hover:-translate-y-1"
          >
            <div class="md:flex">
              <!-- Video Section - Made wider, now with YouTube thumbnail -->
              <div class="md:w-3/4 relative">
                <div class="aspect-video bg-gray-200">
                  <!-- YouTube thumbnail with play icon overlay -->
                  <div class="relative w-full h-full">
                    <img
                      :src="getThumbnailUrl(featuredCourse)"
                      :alt="featuredCourse.name"
                      class="w-full h-full object-cover"
                      @error="handleImageError($event, featuredCourse.id)"
                    />
                    <div
                      class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-center justify-center"
                    >
                      <div
                        class="bg-white/20 backdrop-blur-sm rounded-full p-5 shadow-2xl transform transition-transform duration-300 hover:scale-110"
                      >
                        <svg
                          class="w-16 h-16 text-white"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                          ></path>
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                          ></path>
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Status Badge -->
                <div class="absolute top-4 left-4">
                  <span
                    class="px-4 py-2 rounded-full text-sm font-semibold shadow-lg"
                    :class="{
                      'bg-green-100 text-green-800': featuredCourse.status === 'approved',
                      'bg-yellow-100 text-yellow-800':
                        featuredCourse.status === 'pending',
                      'bg-blue-100 text-blue-800': featuredCourse.status === 'free',
                    }"
                  >
                    {{ featuredCourse.status }}
                  </span>
                </div>
              </div>
              <!-- Content Section - Made smaller -->
              <div
                class="md:w-1/4 p-6 flex flex-col justify-between bg-gradient-to-b from-white to-indigo-50"
              >
                <div>
                  <h3 class="text-2xl font-bold text-gray-800 mb-4">
                    {{ featuredCourse.name }}
                  </h3>
                  <div class="flex items-center mb-6">
                    <div
                      class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center mr-3 text-white font-bold"
                    >
                      {{
                        featuredCourse.admin?.name
                          ? featuredCourse.admin.name.charAt(0)
                          : "A"
                      }}
                    </div>
                    <div>
                      <p class="text-sm text-gray-600">Instructor</p>
                      <p class="font-medium">
                        {{ featuredCourse.admin?.name || "Admin" }}
                      </p>
                    </div>
                  </div>
                  <div class="flex items-center text-gray-500 mb-2">
                    <svg
                      class="w-5 h-5 mr-2 text-purple-500"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                      ></path>
                    </svg>
                    <span>Duration: 3h 45m</span>
                  </div>
                  <div class="flex items-center text-gray-500 mb-6">
                    <svg
                      class="w-5 h-5 mr-2 text-purple-500"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                      ></path>
                    </svg>
                    <span>Certificate included</span>
                  </div>
                </div>
                <button
                  @click="openVideoModal(featuredCourse)"
                  class="w-full py-3 bg-gradient-to-r from-purple-600 to-indigo-700 text-white rounded-xl font-semibold hover:from-purple-700 hover:to-indigo-800 transition-all duration-300 shadow-md flex items-center justify-center transform hover:scale-105"
                >
                  <svg
                    class="w-5 h-5 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                    ></path>
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                  </svg>
                  View Video
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Your Courses Section -->
        <div v-if="lectures.length > 1" class="mb-16">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-indigo-700 flex items-center">
              <svg
                class="w-6 h-6 mr-2 text-purple-600"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                ></path>
              </svg>
              Your Courses
            </h2>
            <button
              class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center"
            >
              View All
              <svg
                class="w-4 h-4 ml-1"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7"
                ></path>
              </svg>
            </button>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
              v-for="lecture in lectures.slice(1)"
              :key="lecture.id"
              class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border border-gray-100"
            >
              <!-- Video section - now with YouTube thumbnail -->
              <div class="relative h-48 overflow-hidden">
                <!-- YouTube thumbnail with play icon overlay -->
                <div class="relative w-full h-full">
                  <img
                    :src="getThumbnailUrl(lecture)"
                    :alt="lecture.name"
                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                    @error="handleImageError($event, lecture.id)"
                  />
                  <div
                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-center justify-center"
                  >
                    <div
                      class="bg-white/20 backdrop-blur-sm rounded-full p-3 shadow-lg transform transition-transform duration-300 hover:scale-110"
                    >
                      <svg
                        class="w-10 h-10 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                        ></path>
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                      </svg>
                    </div>
                  </div>
                </div>
                <!-- Status badge -->
                <div class="absolute top-3 right-3">
                  <span
                    class="px-3 py-1 rounded-full text-xs font-semibold shadow"
                    :class="{
                      'bg-green-100 text-green-800': lecture.status === 'approved',
                      'bg-yellow-100 text-yellow-800': lecture.status === 'pending',
                      'bg-blue-100 text-blue-800': lecture.status === 'free',
                    }"
                  >
                    {{ lecture.status }}
                  </span>
                </div>
              </div>
              <!-- Content section -->
              <div class="p-6">
                <div class="flex justify-between items-start mb-3">
                  <h3 class="text-xl font-bold text-gray-800">{{ lecture.name }}</h3>
                </div>
                <div class="flex items-center mb-4">
                  <div
                    class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center mr-2 text-white font-bold text-sm"
                  >
                    {{ lecture.admin?.name ? lecture.admin.name.charAt(0) : "A" }}
                  </div>
                  <p class="text-sm text-gray-600">
                    By {{ lecture.admin?.name || "Admin" }}
                  </p>
                </div>
                <div class="flex justify-between items-center">
                  <button
                    @click="openVideoModal(lecture)"
                    class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-700 text-white rounded-lg hover:from-purple-700 hover:to-indigo-800 transition-all duration-300 flex items-center transform hover:scale-105"
                  >
                    <svg
                      class="w-4 h-4 mr-1"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                      ></path>
                    </svg>
                    View
                  </button>
                  <div class="flex items-center text-gray-500">
                    <svg
                      class="w-5 h-5 mr-1 text-purple-500"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                      ></path>
                    </svg>
                    <span class="text-sm">2h 30m</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Free Courses Section -->
        <div>
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-indigo-700 flex items-center">
              <svg
                class="w-6 h-6 mr-2 text-purple-600"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                ></path>
              </svg>
              Free Courses
            </h2>
            <button
              class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center"
            >
              View All
              <svg
                class="w-4 h-4 ml-1"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7"
                ></path>
              </svg>
            </button>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
              v-for="course in freeCourses"
              :key="course.id"
              class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border border-gray-100"
            >
              <!-- Video section - now with YouTube thumbnail -->
              <div class="relative h-48 overflow-hidden">
                <!-- YouTube thumbnail with play icon overlay -->
                <div class="relative w-full h-full">
                  <img
                    :src="getThumbnailUrl(course)"
                    :alt="course.name"
                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                    @error="handleImageError($event, course.id)"
                  />
                  <div
                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-center justify-center"
                  >
                    <div
                      class="bg-white/20 backdrop-blur-sm rounded-full p-3 shadow-lg transform transition-transform duration-300 hover:scale-110"
                    >
                      <svg
                        class="w-10 h-10 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                        ></path>
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                      </svg>
                    </div>
                  </div>
                </div>
                <!-- Free badge -->
                <div class="absolute top-3 right-3">
                  <span
                    class="px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow"
                  >
                    Free
                  </span>
                </div>
                <!-- Level badge -->
                <div class="absolute top-3 left-3">
                  <span
                    class="px-3 py-1 rounded-full text-xs font-semibold shadow"
                    :class="{
                      'bg-green-100 text-green-800': course.level === 'Beginner',
                      'bg-purple-100 text-purple-800': course.level === 'Intermediate',
                      'bg-red-100 text-red-800': course.level === 'Advanced',
                    }"
                  >
                    {{ course.level }}
                  </span>
                </div>
              </div>
              <!-- Content section -->
              <div class="p-6">
                <div class="flex justify-between items-start mb-3">
                  <h3 class="text-xl font-bold text-gray-800">{{ course.name }}</h3>
                </div>
                <p class="text-gray-600 mb-4">{{ course.description }}</p>
                <div class="flex items-center mb-4">
                  <div
                    class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center mr-2 text-white font-bold text-sm"
                  >
                    {{ course.admin?.name ? course.admin.name.charAt(0) : "A" }}
                  </div>
                  <p class="text-sm text-gray-600">
                    By {{ course.admin?.name || "Admin" }}
                  </p>
                </div>
                <div class="flex justify-between items-center">
                  <button
                    @click="openVideoModal(course)"
                    class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-700 text-white rounded-lg hover:from-purple-700 hover:to-indigo-800 transition-all duration-300 flex items-center transform hover:scale-105"
                  >
                    <svg
                      class="w-4 h-4 mr-1"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                      ></path>
                    </svg>
                    View
                  </button>
                  <div class="flex items-center text-gray-500">
                    <svg
                      class="w-5 h-5 mr-1 text-purple-500"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                      ></path>
                    </svg>
                    <span class="text-sm">{{ course.duration }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Video Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 p-4 backdrop-blur-sm"
      @click.self="closeModal"
    >
      <div
        class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden transform transition-all duration-300 scale-95 animate-scaleIn"
      >
        <div
          class="flex justify-between items-center p-5 border-b bg-gradient-to-r from-purple-50 to-indigo-50"
        >
          <h3 class="text-2xl font-bold text-gray-800">
            {{ selectedVideo?.name || "Demo Video" }}
          </h3>
          <button
            @click="closeModal"
            class="text-gray-500 hover:text-gray-700 bg-white/80 rounded-full p-2 transition-colors duration-300"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              ></path>
            </svg>
          </button>
        </div>
        <div class="p-1 bg-black">
          <div class="aspect-video bg-black">
            <div v-if="selectedVideo?.youtube_url" class="h-full w-full">
              <iframe
                class="w-full h-full"
                :src="selectedVideo.youtube_url"
                frameborder="0"
                allowfullscreen
              ></iframe>
            </div>
            <div v-else-if="selectedVideo?.video_path" class="h-full w-full">
              <video class="w-full h-full object-cover" controls autoplay>
                <source :src="`/storage/${selectedVideo.video_path}`" type="video/mp4" />
                Your browser does not support the video tag.
              </video>
            </div>
          </div>
        </div>
        <div class="p-5 bg-gradient-to-r from-purple-50 to-indigo-50">
          <p class="text-gray-700 mb-3">
            {{
              selectedVideo?.description ||
              "Watch this demo video to learn more about our platform."
            }}
          </p>
          <div class="flex items-center text-sm text-gray-600">
            <svg
              class="w-4 h-4 mr-1 text-purple-600"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
              ></path>
            </svg>
            <span>Duration: {{ selectedVideo?.duration || "5m 30s" }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
  @keyframes scaleIn {
    from {
      transform: scale(0.95);
      opacity: 0;
    }
    to {
      transform: scale(1);
      opacity: 1;
    }
  }
  .animate-scaleIn {
    animation: scaleIn 0.3s ease-out forwards;
  }
</style>
