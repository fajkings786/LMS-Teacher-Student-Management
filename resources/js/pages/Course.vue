<template>
  <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
    <!-- Hero Section -->
    <div
      class="relative bg-gradient-to-r from-indigo-900 to-purple-800 text-white py-20 px-4"
    >
      <div class="absolute inset-0 bg-black opacity-30"></div>
      <div class="relative max-w-6xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">Explore Our Courses</h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-10">
          Discover world-class courses taught by industry experts and advance your career
        </p>

        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto">
          <div class="relative">
            <input
              type="text"
              placeholder="Search for courses..."
              class="w-full py-4 px-6 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-white"
              v-model="searchQuery"
            />
            <button
              class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-full"
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
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter and Sort Section -->
    <div class="py-8 bg-white shadow-sm">
      <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
          <div class="flex flex-wrap gap-2">
            <button
              v-for="category in categories"
              :key="category"
              @click="selectedCategory = category"
              :class="[
                'px-4 py-2 rounded-full text-sm font-medium transition-colors',
                selectedCategory === category
                  ? 'bg-indigo-600 text-white'
                  : 'bg-gray-200 text-gray-700 hover:bg-gray-300',
              ]"
            >
              {{ category }}
            </button>
          </div>

          <div class="flex items-center gap-2">
            <span class="text-gray-700">Sort by:</span>
            <select
              class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
              v-model="sortBy"
            >
              <option value="popular">Most Popular</option>
              <option value="newest">Newest</option>
              <option value="rating">Highest Rated</option>
              <option value="price-low">Price: Low to High</option>
              <option value="price-high">Price: High to Low</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Courses Grid -->
    <div class="py-12">
      <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Course Card 1 -->
          <div
            class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300"
          >
            <div class="relative">
              <!-- Video Thumbnail -->
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                  alt="Course thumbnail"
                  class="w-full h-full object-cover"
                />
                <div
                  class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300"
                >
                  <button
                    class="bg-white bg-opacity-90 rounded-full p-3 transform hover:scale-110 transition-transform"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-8 w-8 text-indigo-600"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </div>
                <div
                  class="absolute top-4 right-4 bg-indigo-600 text-white text-xs font-bold px-2.5 py-1 rounded"
                >
                  BESTSELLER
                </div>
              </div>
            </div>

            <div class="p-6">
              <div class="flex justify-between items-start mb-2">
                <h3 class="text-xl font-bold text-gray-800">
                  Complete Web Development Bootcamp
                </h3>
                <span class="text-yellow-500 flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>
                  4.8
                </span>
              </div>

              <p class="text-gray-600 mb-4">
                Learn HTML, CSS, JavaScript, React, Node.js and more by building
                real-world projects
              </p>

              <div class="flex items-center text-sm text-gray-500 mb-4">
                <div class="flex items-center mr-4">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                  52 hours
                </div>
                <div class="flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                  Dr. Angela Yu
                </div>
              </div>

              <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-800">$89.99</div>
                <button
                  class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors"
                >
                  Enroll Now
                </button>
              </div>
            </div>
          </div>

          <!-- Course Card 2 -->
          <div
            class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300"
          >
            <div class="relative">
              <!-- Video Thumbnail -->
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                  alt="Course thumbnail"
                  class="w-full h-full object-cover"
                />
                <div
                  class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300"
                >
                  <button
                    class="bg-white bg-opacity-90 rounded-full p-3 transform hover:scale-110 transition-transform"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-8 w-8 text-indigo-600"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <div class="p-6">
              <div class="flex justify-between items-start mb-2">
                <h3 class="text-xl font-bold text-gray-800">Machine Learning A-Z</h3>
                <span class="text-yellow-500 flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>
                  4.7
                </span>
              </div>

              <p class="text-gray-600 mb-4">
                Hands-On Python & R In Data Science, Learn to build Machine Learning
                models
              </p>

              <div class="flex items-center text-sm text-gray-500 mb-4">
                <div class="flex items-center mr-4">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                  44 hours
                </div>
                <div class="flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                  Kirill Eremenko
                </div>
              </div>

              <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-800">$94.99</div>
                <button
                  class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors"
                >
                  Enroll Now
                </button>
              </div>
            </div>
          </div>

          <!-- Course Card 3 -->
          <div
            class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300"
          >
            <div class="relative">
              <!-- Video Thumbnail -->
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://images.unsplash.com/photo-1551739440-5dd934d3a94a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                  alt="Course thumbnail"
                  class="w-full h-full object-cover"
                />
                <div
                  class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300"
                >
                  <button
                    class="bg-white bg-opacity-90 rounded-full p-3 transform hover:scale-110 transition-transform"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-8 w-8 text-indigo-600"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </div>
                <div
                  class="absolute top-4 right-4 bg-red-600 text-white text-xs font-bold px-2.5 py-1 rounded"
                >
                  HOT
                </div>
              </div>
            </div>

            <div class="p-6">
              <div class="flex justify-between items-start mb-2">
                <h3 class="text-xl font-bold text-gray-800">
                  iOS 15 & Swift 5 - The Complete iOS App Development
                </h3>
                <span class="text-yellow-500 flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>
                  4.6
                </span>
              </div>

              <p class="text-gray-600 mb-4">
                Xcode 13, Swift 5, iOS 15, UIKit, Swift UI, ARKit, Core ML and more
              </p>

              <div class="flex items-center text-sm text-gray-500 mb-4">
                <div class="flex items-center mr-4">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                  54 hours
                </div>
                <div class="flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                  Angela Yu
                </div>
              </div>

              <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-800">$84.99</div>
                <button
                  class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors"
                >
                  Enroll Now
                </button>
              </div>
            </div>
          </div>

          <!-- Course Card 4 -->
          <div
            class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300"
          >
            <div class="relative">
              <!-- Video Thumbnail -->
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                  alt="Course thumbnail"
                  class="w-full h-full object-cover"
                />
                <div
                  class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300"
                >
                  <button
                    class="bg-white bg-opacity-90 rounded-full p-3 transform hover:scale-110 transition-transform"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-8 w-8 text-indigo-600"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <div class="p-6">
              <div class="flex justify-between items-start mb-2">
                <h3 class="text-xl font-bold text-gray-800">
                  UI/UX Design Specialization
                </h3>
                <span class="text-yellow-500 flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>
                  4.8
                </span>
              </div>

              <p class="text-gray-600 mb-4">
                Design Led Strategy, Wireframes, Prototyping, and User Research
              </p>

              <div class="flex items-center text-sm text-gray-500 mb-4">
                <div class="flex items-center mr-4">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                  6 months
                </div>
                <div class="flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                  California Institute of the Arts
                </div>
              </div>

              <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-800">$79.99</div>
                <button
                  class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors"
                >
                  Enroll Now
                </button>
              </div>
            </div>
          </div>

          <!-- Course Card 5 -->
          <div
            class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300"
          >
            <div class="relative">
              <!-- Video Thumbnail -->
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://images.unsplash.com/photo-1614064641938-3bbee52942c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                  alt="Course thumbnail"
                  class="w-full h-full object-cover"
                />
                <div
                  class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300"
                >
                  <button
                    class="bg-white bg-opacity-90 rounded-full p-3 transform hover:scale-110 transition-transform"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-8 w-8 text-indigo-600"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <div class="p-6">
              <div class="flex justify-between items-start mb-2">
                <h3 class="text-xl font-bold text-gray-800">
                  The Complete Cyber Security Course
                </h3>
                <span class="text-yellow-500 flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>
                  4.5
                </span>
              </div>

              <p class="text-gray-600 mb-4">
                Network Security, WiFi Security, Firewalls, Cryptography and more
              </p>

              <div class="flex items-center text-sm text-gray-500 mb-4">
                <div class="flex items-center mr-4">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                  12 hours
                </div>
                <div class="flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                  Nathan House
                </div>
              </div>

              <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-800">$89.99</div>
                <button
                  class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors"
                >
                  Enroll Now
                </button>
              </div>
            </div>
          </div>

          <!-- Course Card 6 -->
          <div
            class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300"
          >
            <div class="relative">
              <!-- Video Thumbnail -->
              <div class="relative h-48 overflow-hidden">
                <img
                  src="https://images.unsplash.com/photo-1557868923-058aa731a955?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                  alt="Course thumbnail"
                  class="w-full h-full object-cover"
                />
                <div
                  class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300"
                >
                  <button
                    class="bg-white bg-opacity-90 rounded-full p-3 transform hover:scale-110 transition-transform"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-8 w-8 text-indigo-600"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </div>
                <div
                  class="absolute top-4 right-4 bg-green-600 text-white text-xs font-bold px-2.5 py-1 rounded"
                >
                  NEW
                </div>
              </div>
            </div>

            <div class="p-6">
              <div class="flex justify-between items-start mb-2">
                <h3 class="text-xl font-bold text-gray-800">
                  Digital Marketing Specialization
                </h3>
                <span class="text-yellow-500 flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>
                  4.7
                </span>
              </div>

              <p class="text-gray-600 mb-4">
                SEO, Social Media, Content Marketing, PPC, Email & more
              </p>

              <div class="flex items-center text-sm text-gray-500 mb-4">
                <div class="flex items-center mr-4">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                  8 months
                </div>
                <div class="flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                  University of Illinois
                </div>
              </div>

              <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-800">$79.99</div>
                <button
                  class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors"
                >
                  Enroll Now
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12">
          <button
            class="bg-white border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-50 font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105"
          >
            Load More Courses
          </button>
        </div>
      </div>
    </div>

    <!-- Featured Instructor Section -->
    <div class="py-16 bg-gradient-to-r from-indigo-700 to-purple-800 text-white">
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
          <h2 class="text-3xl md:text-4xl font-bold mb-4">Learn From Industry Experts</h2>
          <p class="text-indigo-200 max-w-2xl mx-auto">
            Our instructors are professionals from top companies and institutions
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <div class="text-center">
            <div
              class="w-24 h-24 rounded-full bg-white bg-opacity-20 mx-auto mb-4 overflow-hidden"
            >
              <img
                src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                alt="Instructor"
                class="w-full h-full object-cover"
              />
            </div>
            <h3 class="font-bold">Sarah Johnson</h3>
            <p class="text-indigo-200 text-sm">Google</p>
          </div>

          <div class="text-center">
            <div
              class="w-24 h-24 rounded-full bg-white bg-opacity-20 mx-auto mb-4 overflow-hidden"
            >
              <img
                src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                alt="Instructor"
                class="w-full h-full object-cover"
              />
            </div>
            <h3 class="font-bold">Michael Chen</h3>
            <p class="text-indigo-200 text-sm">Microsoft</p>
          </div>

          <div class="text-center">
            <div
              class="w-24 h-24 rounded-full bg-white bg-opacity-20 mx-auto mb-4 overflow-hidden"
            >
              <img
                src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                alt="Instructor"
                class="w-full h-full object-cover"
              />
            </div>
            <h3 class="font-bold">Emily Rodriguez</h3>
            <p class="text-indigo-200 text-sm">Apple</p>
          </div>

          <div class="text-center">
            <div
              class="w-24 h-24 rounded-full bg-white bg-opacity-20 mx-auto mb-4 overflow-hidden"
            >
              <img
                src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                alt="Instructor"
                class="w-full h-full object-cover"
              />
            </div>
            <h3 class="font-bold">David Wilson</h3>
            <p class="text-indigo-200 text-sm">Amazon</p>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 bg-white">
      <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
          Ready to Start Learning?
        </h2>
        <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
          Join millions of learners from around the world already learning on our platform
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <router-link
            to="/signup"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg"
          >
            Sign Up For Free
          </router-link>
          <router-link
            to="/about"
            class="bg-transparent border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-50 font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105"
          >
            Learn More
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "Courses",
    data() {
      return {
        searchQuery: "",
        selectedCategory: "All",
        sortBy: "popular",
        categories: [
          "All",
          "Development",
          "Business",
          "Design",
          "Marketing",
          "IT & Software",
          "Personal Development",
        ],
      };
    },
  };
</script>

<style scoped>
  /* Custom animations and transitions */
  .course-card {
    transition: all 0.3s ease;
  }

  .course-card:hover {
    transform: translateY(-5px);
  }
</style>
