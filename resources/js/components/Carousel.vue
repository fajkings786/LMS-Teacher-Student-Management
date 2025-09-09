<template>
  <div class="w-full max-w-6xl mx-auto">
    <div class="relative overflow-hidden rounded-xl">
      <!-- Slides -->
      <div
        class="flex transition-transform duration-500 ease-in-out"
        :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
      >
        <div
          v-for="(card, index) in cards"
          :key="index"
          class="w-full flex-shrink-0 px-4"
        >
          <div
            class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
          >
            <div class="relative">
              <img :src="card.image" alt="Course" class="w-full h-64 object-cover" />
              <div
                class="absolute top-4 right-4 bg-indigo-600 text-white text-sm font-bold py-1 px-3 rounded-full"
              >
                {{ card.level }}
              </div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-start mb-2">
                <h2 class="text-2xl font-bold text-gray-800">{{ card.title }}</h2>
                <span
                  class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded"
                >
                  {{ card.duration }}
                </span>
              </div>
              <p class="text-gray-600 mb-4">{{ card.desc }}</p>
              <button
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300"
              >
                Enroll Now
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Controls -->
      <button
        @click="prevSlide"
        class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 text-indigo-900 p-3 rounded-full shadow-md transition-all duration-300"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7"
          />
        </svg>
      </button>
      <button
        @click="nextSlide"
        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 text-indigo-900 p-3 rounded-full shadow-md transition-all duration-300"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5l7 7-7 7"
          />
        </svg>
      </button>
    </div>

    <!-- Indicators -->
    <div class="flex justify-center mt-6 space-x-2">
      <button
        v-for="(card, index) in cards"
        :key="'dot-' + index"
        @click="goToSlide(index)"
        class="w-3 h-3 rounded-full transition-all duration-300"
        :class="
          currentIndex === index ? 'bg-indigo-600 w-8' : 'bg-gray-300 hover:bg-gray-400'
        "
      ></button>
    </div>
  </div>
</template>

<script setup>
  import { ref, onMounted, onBeforeUnmount } from "vue";

  const props = defineProps({
    cards: {
      type: Array,
      required: true,
    },
  });

  const currentIndex = ref(0);
  let autoplayInterval = null;

  function nextSlide() {
    currentIndex.value = (currentIndex.value + 1) % props.cards.length;
    resetAutoplay();
  }

  function prevSlide() {
    currentIndex.value =
      (currentIndex.value - 1 + props.cards.length) % props.cards.length;
    resetAutoplay();
  }

  function goToSlide(index) {
    currentIndex.value = index;
    resetAutoplay();
  }

  function startAutoplay() {
    autoplayInterval = setInterval(() => {
      nextSlide();
    }, 5000);
  }

  function resetAutoplay() {
    if (autoplayInterval) {
      clearInterval(autoplayInterval);
    }
    startAutoplay();
  }

  onMounted(() => {
    startAutoplay();
  });

  onBeforeUnmount(() => {
    if (autoplayInterval) {
      clearInterval(autoplayInterval);
    }
  });
</script>
