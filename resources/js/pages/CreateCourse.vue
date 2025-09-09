<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-100 p-4 md:p-12">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-indigo-800 mb-6">Create New Lecture</h1>

        <form @submit.prevent="submitLecture">
          <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2" for="name">
              Lecture Name
            </label>
            <input
              id="name"
              v-model="lecture.name"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              required
            />
          </div>

          <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2" for="description">
              Description
            </label>
            <textarea
              id="description"
              v-model="lecture.description"
              rows="4"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
            ></textarea>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label class="block text-gray-700 font-medium mb-2" for="video_path">
                Video Path (Optional)
              </label>
              <input
                id="video_path"
                v-model="lecture.video_path"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>

            <div>
              <label class="block text-gray-700 font-medium mb-2" for="youtube_url">
                YouTube URL (Optional)
              </label>
              <input
                id="youtube_url"
                v-model="lecture.youtube_url"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label class="block text-gray-700 font-medium mb-2" for="duration">
                Duration (Optional)
              </label>
              <input
                id="duration"
                v-model="lecture.duration"
                type="text"
                placeholder="e.g., 45:30"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>

            <div>
              <label class="block text-gray-700 font-medium mb-2" for="category">
                Category
              </label>
              <select
                id="category"
                v-model="lecture.category"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              >
                <option value="General">General</option>
                <option value="Frontend">Frontend</option>
                <option value="Backend">Backend</option>
                <option value="Database">Database</option>
                <option value="DevOps">DevOps</option>
              </select>
            </div>
          </div>

          <div class="flex justify-end">
            <button
              type="button"
              @click="goBack"
              class="mr-4 px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="isSubmitting"
              class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center"
            >
              <svg
                v-if="isSubmitting"
                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
              {{ isSubmitting ? "Creating..." : "Create Lecture" }}
            </button>
          </div>
        </form>

        <div
          v-if="successMessage"
          class="mt-6 p-4 bg-green-100 text-green-700 rounded-lg"
        >
          {{ successMessage }}
        </div>

        <div v-if="errorMessage" class="mt-6 p-4 bg-red-100 text-red-700 rounded-lg">
          {{ errorMessage }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { ref, reactive } from "vue";
  import { useRouter } from "vue-router";
  import axios from "axios";

  const router = useRouter();
  const isSubmitting = ref(false);
  const successMessage = ref("");
  const errorMessage = ref("");

  const lecture = reactive({
    name: "",
    description: "",
    video_path: "",
    youtube_url: "",
    duration: "",
    category: "General",
  });

  const submitLecture = async () => {
    isSubmitting.value = true;
    successMessage.value = "";
    errorMessage.value = "";

    try {
      const token = localStorage.getItem("userToken");

      if (!token) {
        throw new Error("No authentication token found");
      }

      const response = await axios.post("/courses/store", lecture, {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
          "Content-Type": "application/json",
        },
      });

      if (response.data.success) {
        successMessage.value = "Lecture created successfully!";

        // Reset form
        Object.keys(lecture).forEach((key) => {
          if (key !== "category") {
            lecture[key] = "";
          }
        });

        // Redirect after a short delay
        setTimeout(() => {
          router.push("/lectures");
        }, 2000);
      } else {
        errorMessage.value = response.data.message || "Failed to create lecture";
      }
    } catch (error) {
      console.error("Error creating lecture:", error);

      if (error.response?.status === 401) {
        errorMessage.value = "Authentication failed. Please login again.";
        setTimeout(() => {
          router.push("/Login");
        }, 2000);
      } else {
        errorMessage.value =
          error.response?.data?.message || "Failed to create lecture. Please try again.";
      }
    } finally {
      isSubmitting.value = false;
    }
  };

  const goBack = () => {
    router.back();
  };
</script>
