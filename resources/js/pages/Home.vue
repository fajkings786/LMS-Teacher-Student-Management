<template>
  <div class="min-h-screen">
    <!-- Hero Section with Video Background -->
    <div class="relative h-screen flex items-center justify-center overflow-hidden">
      <!-- Video Background -->
      <div class="absolute inset-0 z-0">
        <video autoplay muted loop class="w-full h-full object-cover">
          <source
            src="https://assets.mixkit.co/videos/preview/mixkit-group-of-friends-taking-a-selfie-4276-large.mp4"
            type="video/mp4"
          />
        </video>
        <div
          class="absolute inset-0 bg-gradient-to-r from-indigo-900/90 to-purple-900/90"
        ></div>
      </div>

      <!-- Hero Content -->
      <div class="relative z-10 text-center text-white px-4 max-w-4xl">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-fade-in">
          Transform Your Future with
          <span
            class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500"
            >LMS</span
          >
        </h1>
        <p class="text-xl md:text-2xl mb-10 max-w-2xl mx-auto animate-fade-in-up">
          Unlock your potential with world-class courses, expert instructors, and flexible
          learning paths.
        </p>

        <div
          class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up-delay"
        >
          <router-link
            to="/course"
            class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-indigo-900 font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-xl flex items-center justify-center"
          >
            <span class="mr-2">🚀</span> Explore Courses
          </router-link>
          <router-link
            to="/dashboard"
            class="bg-transparent border-2 border-white hover:bg-white hover:text-indigo-900 font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 flex items-center justify-center"
          >
            <span class="mr-2">👤</span> Get started Free
          </router-link>
        </div>

        <!-- Scroll Indicator -->
        <div
          class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-8 w-8 text-white"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 14l-7 7m0 0l-7-7m7 7V3"
            />
          </svg>
        </div>
      </div>
    </div>

    <!-- Statistics Section with Animation -->
    <div class="py-16 bg-gradient-to-r from-indigo-700 to-purple-800 text-white">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
          <div class="p-4 transform transition-transform duration-500 hover:scale-110">
            <div class="text-4xl font-bold mb-2 counter" data-target="500">0</div>
            <div class="text-indigo-200">Courses</div>
          </div>
          <div class="p-4 transform transition-transform duration-500 hover:scale-110">
            <div class="text-4xl font-bold mb-2 counter" data-target="10000">0</div>
            <div class="text-indigo-200">Students</div>
          </div>
          <div class="p-4 transform transition-transform duration-500 hover:scale-110">
            <div class="text-4xl font-bold mb-2 counter" data-target="200">0</div>
            <div class="text-indigo-200">Instructors</div>
          </div>
          <div class="p-4 transform transition-transform duration-500 hover:scale-110">
            <div class="text-4xl font-bold mb-2 counter" data-target="98">0</div>
            <div class="text-indigo-200">Satisfaction %</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Features Section with Icons -->
    <div class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose Our LMS?</h2>
          <div
            class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mb-4"
          ></div>
          <p class="text-gray-600 max-w-2xl mx-auto">
            We provide the best learning experience with our innovative platform
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
          <div
            class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
          >
            <div
              class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl mb-6 mx-auto"
            >
              📚
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Rich Content</h3>
            <p class="text-gray-600 text-center">
              Access a wide range of courses with high-quality materials and resources.
            </p>
          </div>

          <div
            class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
          >
            <div
              class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-2xl mb-6 mx-auto"
            >
              👨‍🏫
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">
              Expert Instructors
            </h3>
            <p class="text-gray-600 text-center">
              Learn from industry experts with years of experience in their fields.
            </p>
          </div>

          <div
            class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
          >
            <div
              class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 text-2xl mb-6 mx-auto"
            >
              🏆
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">
              Certification
            </h3>
            <p class="text-gray-600 text-center">
              Earn recognized certificates upon completion of your courses.
            </p>
          </div>

          <div
            class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
          >
            <div
              class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-2xl mb-6 mx-auto"
            >
              📱
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">
              Mobile Learning
            </h3>
            <p class="text-gray-600 text-center">
              Learn on the go with our mobile-friendly platform and apps.
            </p>
          </div>

          <div
            class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
          >
            <div
              class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center text-red-600 text-2xl mb-6 mx-auto"
            >
              🌐
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">
              Global Community
            </h3>
            <p class="text-gray-600 text-center">
              Connect with learners from around the world and expand your network.
            </p>
          </div>

          <div
            class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
          >
            <div
              class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl mb-6 mx-auto"
            >
              💼
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">
              Career Support
            </h3>
            <p class="text-gray-600 text-center">
              Get career guidance and job placement assistance after course completion.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Popular Categories with Hover Effects -->
    <div class="py-20 bg-white">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold text-gray-800 mb-4">Popular Categories</h2>
          <div
            class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mb-4"
          ></div>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Explore our most popular course categories
          </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div
            class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2"
          >
            <div
              class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-600 opacity-80 group-hover:opacity-90 transition-opacity duration-300"
            ></div>
            <div class="relative p-6 text-white text-center">
              <div class="text-5xl mb-3">💻</div>
              <h3 class="text-xl font-bold">Programming</h3>
              <p class="text-sm mt-1 opacity-90">120 Courses</p>
              <div
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50"
              >
                <span class="text-lg font-semibold">Explore</span>
              </div>
            </div>
          </div>

          <div
            class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2"
          >
            <div
              class="absolute inset-0 bg-gradient-to-br from-purple-600 to-pink-600 opacity-80 group-hover:opacity-90 transition-opacity duration-300"
            ></div>
            <div class="relative p-6 text-white text-center">
              <div class="text-5xl mb-3">📊</div>
              <h3 class="text-xl font-bold">Data Science</h3>
              <p class="text-sm mt-1 opacity-90">85 Courses</p>
              <div
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50"
              >
                <span class="text-lg font-semibold">Explore</span>
              </div>
            </div>
          </div>

          <div
            class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2"
          >
            <div
              class="absolute inset-0 bg-gradient-to-br from-blue-600 to-cyan-600 opacity-80 group-hover:opacity-90 transition-opacity duration-300"
            ></div>
            <div class="relative p-6 text-white text-center">
              <div class="text-5xl mb-3">🎨</div>
              <h3 class="text-xl font-bold">Design</h3>
              <p class="text-sm mt-1 opacity-90">65 Courses</p>
              <div
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50"
              >
                <span class="text-lg font-semibold">Explore</span>
              </div>
            </div>
          </div>

          <div
            class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2"
          >
            <div
              class="absolute inset-0 bg-gradient-to-br from-green-600 to-teal-600 opacity-80 group-hover:opacity-90 transition-opacity duration-300"
            ></div>
            <div class="relative p-6 text-white text-center">
              <div class="text-5xl mb-3">📈</div>
              <h3 class="text-xl font-bold">Business</h3>
              <p class="text-sm mt-1 opacity-90">95 Courses</p>
              <div
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50"
              >
                <span class="text-lg font-semibold">Explore</span>
              </div>
            </div>
          </div>

          <div
            class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2"
          >
            <div
              class="absolute inset-0 bg-gradient-to-br from-yellow-600 to-orange-600 opacity-80 group-hover:opacity-90 transition-opacity duration-300"
            ></div>
            <div class="relative p-6 text-white text-center">
              <div class="text-5xl mb-3">📱</div>
              <h3 class="text-xl font-bold">Mobile Dev</h3>
              <p class="text-sm mt-1 opacity-90">45 Courses</p>
              <div
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50"
              >
                <span class="text-lg font-semibold">Explore</span>
              </div>
            </div>
          </div>

          <div
            class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2"
          >
            <div
              class="absolute inset-0 bg-gradient-to-br from-red-600 to-pink-600 opacity-80 group-hover:opacity-90 transition-opacity duration-300"
            ></div>
            <div class="relative p-6 text-white text-center">
              <div class="text-5xl mb-3">🔒</div>
              <h3 class="text-xl font-bold">Security</h3>
              <p class="text-sm mt-1 opacity-90">35 Courses</p>
              <div
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50"
              >
                <span class="text-lg font-semibold">Explore</span>
              </div>
            </div>
          </div>

          <div
            class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2"
          >
            <div
              class="absolute inset-0 bg-gradient-to-br from-teal-600 to-green-600 opacity-80 group-hover:opacity-90 transition-opacity duration-300"
            ></div>
            <div class="relative p-6 text-white text-center">
              <div class="text-5xl mb-3">📷</div>
              <h3 class="text-xl font-bold">Photography</h3>
              <p class="text-sm mt-1 opacity-90">30 Courses</p>
              <div
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50"
              >
                <span class="text-lg font-semibold">Explore</span>
              </div>
            </div>
          </div>

          <div
            class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2"
          >
            <div
              class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-blue-600 opacity-80 group-hover:opacity-90 transition-opacity duration-300"
            ></div>
            <div class="relative p-6 text-white text-center">
              <div class="text-5xl mb-3">🎵</div>
              <h3 class="text-xl font-bold">Music</h3>
              <p class="text-sm mt-1 opacity-90">25 Courses</p>
              <div
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50"
              >
                <span class="text-lg font-semibold">Explore</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Featured Courses Section -->
    <div class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold text-gray-800 mb-4">Featured Courses</h2>
          <div
            class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mb-4"
          ></div>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Explore our most popular courses and start learning today
          </p>
        </div>

        <!-- Enhanced Carousel Component -->
        <Carousel :cards="courses" />

        <div class="text-center mt-12">
          <router-link
            to="/courses"
            class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold"
          >
            View All Courses
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5 ml-1"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                clip-rule="evenodd"
              />
            </svg>
          </router-link>
        </div>
      </div>
    </div>

    <!-- Learning Path Section with Timeline -->
    <!-- Learning Path Section with Enhanced Timeline -->
    <div
      class="py-20 bg-gradient-to-br from-gray-50 via-white to-gray-100 relative overflow-hidden"
    >
      <!-- Background decoration -->
      <div class="absolute inset-0 z-0">
        <div
          class="absolute top-0 left-0 w-64 h-64 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"
        ></div>
        <div
          class="absolute top-0 right-0 w-64 h-64 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"
        ></div>
        <div
          class="absolute bottom-0 left-1/2 w-64 h-64 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"
        ></div>
      </div>

      <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
          <div
            class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 mb-6 shadow-lg"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-10 w-10 text-white"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
              />
            </svg>
          </div>
          <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            Your Learning Path
          </h2>
          <div
            class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mb-4"
          ></div>
          <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Follow our structured learning paths to achieve your goals and transform your
            career
          </p>
        </div>

        <div class="relative max-w-6xl mx-auto">
          <!-- Timeline -->
          <div
            class="hidden md:block absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-indigo-200 via-purple-200 to-blue-200"
          ></div>

          <div class="space-y-16 md:space-y-24">
            <!-- Step 1 -->
            <div class="flex flex-col md:flex-row items-center group">
              <div
                class="md:w-1/2 md:pr-12 text-right order-2 md:order-1 transform transition-all duration-500 group-hover:translate-x-4"
              >
                <div
                  class="bg-gradient-to-br from-indigo-50 to-white p-8 rounded-2xl shadow-lg border border-indigo-100 hover:shadow-xl transition-all duration-300"
                >
                  <div class="flex items-center justify-end mb-4">
                    <div
                      class="w-12 h-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-xl mr-4"
                    >
                      1
                    </div>
                    <h3 class="text-2xl font-bold text-indigo-800">Choose Your Path</h3>
                  </div>
                  <p class="text-gray-600 mb-4">
                    Select from our wide range of learning paths tailored to your career
                    goals and interests.
                  </p>
                  <ul class="text-gray-600 space-y-2">
                    <li class="flex items-center justify-end">
                      <span class="ml-2"
                        >Personalized recommendations based on your goals</span
                      >
                      <span class="text-indigo-500">✓</span>
                    </li>
                    <li class="flex items-center justify-end">
                      <span class="ml-2">Career-aligned learning paths</span>
                      <span class="text-indigo-500">✓</span>
                    </li>
                    <li class="flex items-center justify-end">
                      <span class="ml-2"
                        >Skill assessments to identify your starting point</span
                      >
                      <span class="text-indigo-500">✓</span>
                    </li>
                  </ul>
                  <div class="mt-6 flex justify-end">
                    <span
                      class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium"
                    >
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
                      15-30 minutes
                    </span>
                  </div>
                </div>
              </div>
              <div
                class="md:w-0 md:flex-shrink-0 flex justify-center my-6 md:my-0 order-1 md:order-2"
              >
                <div
                  class="w-16 h-16 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-xl z-10 shadow-lg transform transition-all duration-500 group-hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                    />
                  </svg>
                </div>
              </div>
              <div
                class="md:w-1/2 md:pl-12 order-3 transform transition-all duration-500 group-hover:-translate-x-4"
              >
                <div
                  class="h-80 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 relative"
                >
                  <img
                    src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Choose path"
                    class="w-full h-full object-cover"
                  />
                  <div
                    class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6"
                  >
                    <div class="text-white">
                      <h4 class="text-xl font-bold mb-1">Discover Your Path</h4>
                      <p class="text-sm opacity-80">
                        Find the perfect learning journey for you
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Step 2 -->
            <div class="flex flex-col md:flex-row-reverse items-center group">
              <div
                class="md:w-1/2 md:pl-12 order-2 md:order-3 transform transition-all duration-500 group-hover:-translate-x-4"
              >
                <div
                  class="bg-gradient-to-br from-purple-50 to-white p-8 rounded-2xl shadow-lg border border-purple-100 hover:shadow-xl transition-all duration-300"
                >
                  <div class="flex items-center mb-4">
                    <div
                      class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-xl mr-4"
                    >
                      2
                    </div>
                    <h3 class="text-2xl font-bold text-purple-800">Learn at Your Pace</h3>
                  </div>
                  <p class="text-gray-600 mb-4">
                    Access course materials anytime, anywhere and learn at your own pace
                    with our flexible platform.
                  </p>
                  <ul class="text-gray-600 space-y-2">
                    <li class="flex items-center">
                      <span class="text-purple-500 mr-2">✓</span>
                      <span>Flexible scheduling around your lifestyle</span>
                    </li>
                    <li class="flex items-center">
                      <span class="text-purple-500 mr-2">✓</span>
                      <span>Mobile learning for on-the-go education</span>
                    </li>
                    <li class="flex items-center">
                      <span class="text-purple-500 mr-2">✓</span>
                      <span>Interactive content and hands-on projects</span>
                    </li>
                  </ul>
                  <div class="mt-6">
                    <span
                      class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-medium"
                    >
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
                      Self-paced
                    </span>
                  </div>
                </div>
              </div>
              <div
                class="md:w-0 md:flex-shrink-0 flex justify-center my-6 md:my-0 order-1 md:order-2"
              >
                <div
                  class="w-16 h-16 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-xl z-10 shadow-lg transform transition-all duration-500 group-hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                    />
                  </svg>
                </div>
              </div>
              <div
                class="md:w-1/2 md:pr-12 text-left order-3 md:order-1 transform transition-all duration-500 group-hover:translate-x-4"
              >
                <div
                  class="h-80 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 relative"
                >
                  <img
                    src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Learn at your pace"
                    class="w-full h-full object-cover"
                  />
                  <div
                    class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6"
                  >
                    <div class="text-white">
                      <h4 class="text-xl font-bold mb-1">Flexible Learning</h4>
                      <p class="text-sm opacity-80">
                        Study whenever and wherever you want
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Step 3 -->
            <div class="flex flex-col md:flex-row items-center group">
              <div
                class="md:w-1/2 md:pr-12 text-right order-2 md:order-1 transform transition-all duration-500 group-hover:translate-x-4"
              >
                <div
                  class="bg-gradient-to-br from-blue-50 to-white p-8 rounded-2xl shadow-lg border border-blue-100 hover:shadow-xl transition-all duration-300"
                >
                  <div class="flex items-center justify-end mb-4">
                    <div
                      class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center text-white font-bold text-xl mr-4"
                    >
                      3
                    </div>
                    <h3 class="text-2xl font-bold text-blue-800">Get Certified</h3>
                  </div>
                  <p class="text-gray-600 mb-4">
                    Earn industry-recognized certificates upon successful completion of
                    your learning path.
                  </p>
                  <ul class="text-gray-600 space-y-2">
                    <li class="flex items-center justify-end">
                      <span class="ml-2">Verifiable certificates with unique IDs</span>
                      <span class="text-blue-500">✓</span>
                    </li>
                    <li class="flex items-center justify-end">
                      <span class="ml-2">LinkedIn integration for easy sharing</span>
                      <span class="text-blue-500">✓</span>
                    </li>
                    <li class="flex items-center justify-end">
                      <span class="ml-2">Career advancement opportunities</span>
                      <span class="text-blue-500">✓</span>
                    </li>
                  </ul>
                  <div class="mt-6 flex justify-end">
                    <span
                      class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium"
                    >
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
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                        />
                      </svg>
                      Lifetime valid
                    </span>
                  </div>
                </div>
              </div>
              <div
                class="md:w-0 md:flex-shrink-0 flex justify-center my-6 md:my-0 order-1 md:order-2"
              >
                <div
                  class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center text-white font-bold text-xl z-10 shadow-lg transform transition-all duration-500 group-hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
              </div>
              <div
                class="md:w-1/2 md:pl-12 order-3 transform transition-all duration-500 group-hover:-translate-x-4"
              >
                <div
                  class="h-80 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 relative"
                >
                  <img
                    src="https://images.unsplash.com/photo-1560962024-3d85a756cfc2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Get certified"
                    class="w-full h-full object-cover"
                  />
                  <div
                    class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6"
                  >
                    <div class="text-white">
                      <h4 class="text-xl font-bold mb-1">Earn Recognition</h4>
                      <p class="text-sm opacity-80">
                        Showcase your achievements to employers
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- CTA for Learning Path -->
          <div class="text-center mt-20">
            <div
              class="inline-block bg-gradient-to-r from-indigo-500 to-purple-500 p-1 rounded-full"
            >
              <router-link
                to="/signup"
                class="block bg-white px-8 py-4 rounded-full text-indigo-600 font-bold hover:bg-indigo-50 transition-colors duration-300"
              >
                Start Your Learning Journey Today
              </router-link>
            </div>
            <p class="mt-4 text-gray-600">
              Join over 10,000 students who have transformed their careers
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Testimonials Section -->
    <div class="py-20 bg-gradient-to-br from-indigo-50 to-purple-50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold text-gray-800 mb-4">What Our Students Say</h2>
          <div
            class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mb-4"
          ></div>
          <p class="text-gray-600 max-w-2xl mx-auto">Hear from our successful students</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white p-8 rounded-2xl shadow-lg relative">
            <div
              class="absolute top-0 left-8 transform -translate-y-1/2 bg-indigo-600 text-white p-2 rounded-full"
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
                  d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
            <div class="flex items-center mb-6 mt-4">
              <div
                class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-800 font-bold text-xl mr-4"
              >
                JD
              </div>
              <div>
                <h4 class="font-bold text-gray-800 text-lg">John Doe</h4>
                <p class="text-gray-600">Web Developer</p>
              </div>
            </div>
            <div class="text-yellow-400 mb-4">⭐⭐⭐⭐⭐</div>
            <p class="text-gray-600 italic">
              "This platform has transformed my career. The courses are comprehensive and
              the instructors are top-notch. I landed my dream job after completing the
              web development track!"
            </p>
          </div>

          <div class="bg-white p-8 rounded-2xl shadow-lg relative">
            <div
              class="absolute top-0 left-8 transform -translate-y-1/2 bg-purple-600 text-white p-2 rounded-full"
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
                  d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
            <div class="flex items-center mb-6 mt-4">
              <div
                class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center text-purple-800 font-bold text-xl mr-4"
              >
                SM
              </div>
              <div>
                <h4 class="font-bold text-gray-800 text-lg">Sarah Miller</h4>
                <p class="text-gray-600">Data Scientist</p>
              </div>
            </div>
            <div class="text-yellow-400 mb-4">⭐⭐⭐⭐⭐</div>
            <p class="text-gray-600 italic">
              "I've learned so much in just a few months. The practical approach to
              teaching is amazing. The projects helped me build a portfolio that impressed
              recruiters."
            </p>
          </div>

          <div class="bg-white p-8 rounded-2xl shadow-lg relative">
            <div
              class="absolute top-0 left-8 transform -translate-y-1/2 bg-blue-600 text-white p-2 rounded-full"
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
                  d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
            <div class="flex items-center mb-6 mt-4">
              <div
                class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 font-bold text-xl mr-4"
              >
                RJ
              </div>
              <div>
                <h4 class="font-bold text-gray-800 text-lg">Robert Johnson</h4>
                <p class="text-gray-600">UX Designer</p>
              </div>
            </div>
            <div class="text-yellow-400 mb-4">⭐⭐⭐⭐⭐</div>
            <p class="text-gray-600 italic">
              "The flexibility of learning at my own pace has been a game-changer for my
              busy schedule. The quality of instruction is exceptional, and the community
              support is fantastic."
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Newsletter Section -->
    <div class="py-20 bg-gradient-to-r from-indigo-700 to-purple-800 text-white">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
          <div
            class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white bg-opacity-20 mb-6"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-10 w-10"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
              />
            </svg>
          </div>
          <h2 class="text-4xl font-bold mb-4">Stay Updated</h2>
          <p class="text-xl mb-8">
            Subscribe to our newsletter for the latest courses and updates
          </p>

          <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
            <input
              type="email"
              placeholder="Your email address"
              class="flex-grow px-6 py-4 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white"
            />
            <button
              type="submit"
              class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-indigo-900 font-bold py-4 px-8 rounded-lg transition duration-300 transform hover:scale-105"
            >
              Subscribe
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
      <div class="container mx-auto px-4 text-center">
        <div class="max-w-3xl mx-auto">
          <h2 class="text-4xl font-bold text-gray-800 mb-6">
            Ready to Start Your Learning Journey?
          </h2>
          <p class="text-xl text-gray-600 mb-10">
            Join thousands of students already learning on our platform and transform your
            career
          </p>

          <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <router-link
              to="/dashboard"
              class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 px-10 rounded-full transition-all duration-300 transform hover:scale-105 shadow-xl flex items-center justify-center"
            >
              <span class="mr-2">🚀</span> Get Started Now
            </router-link>
            <router-link
              to="/courses"
              class="bg-white border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-50 font-bold py-4 px-10 rounded-full transition-all duration-300 transform hover:scale-105 flex items-center justify-center"
            >
              <span class="mr-2">📚</span> Browse Courses
            </router-link>
          </div>

          <div class="mt-12 flex justify-center space-x-8">
            <div class="text-center">
              <div class="text-3xl font-bold text-indigo-600">7-Day</div>
              <div class="text-gray-600">Free Trial</div>
            </div>
            <div class="text-center">
              <div class="text-3xl font-bold text-indigo-600">30-Day</div>
              <div class="text-gray-600">Money Back</div>
            </div>
            <div class="text-center">
              <div class="text-3xl font-bold text-indigo-600">24/7</div>
              <div class="text-gray-600">Support</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { onMounted } from "vue";
  import Carousel from "../components/Carousel.vue";

  const courses = [
    {
      title: "Web Development",
      desc: "Master HTML, CSS, JavaScript, and modern frameworks",
      image:
        "https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
      duration: "8 weeks",
      level: "Beginner",
    },
    {
      title: "Data Science",
      desc: "Learn Python, Machine Learning, and AI fundamentals",
      image:
        "https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
      duration: "10 weeks",
      level: "Intermediate",
    },
    {
      title: "Mobile Apps",
      desc: "Build cross-platform apps with Flutter and React Native",
      image:
        "https://images.unsplash.com/photo-1551739440-5dd934d3a94a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
      duration: "12 weeks",
      level: "Intermediate",
    },
    {
      title: "Cyber Security",
      desc: "Protect systems and networks from digital attacks",
      image:
        "https://images.unsplash.com/photo-1614064641938-3bbee52942c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
      duration: "6 weeks",
      level: "Advanced",
    },
    {
      title: "UI/UX Design",
      desc: "Create beautiful and functional user interfaces",
      image:
        "https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
      duration: "8 weeks",
      level: "Beginner",
    },
    {
      title: "Digital Marketing",
      desc: "Master SEO, social media, and content marketing",
      image:
        "https://images.unsplash.com/photo-1557868923-058aa731a955?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
      duration: "6 weeks",
      level: "Beginner",
    },
  ];

  // Animated counter for statistics
  onMounted(() => {
    const counters = document.querySelectorAll(".counter");
    const speed = 200;

    counters.forEach((counter) => {
      const animate = () => {
        const value = +counter.getAttribute("data-target");
        const data = +counter.innerText;
        const time = value / speed;

        if (data < value) {
          counter.innerText = Math.ceil(data + time);
          setTimeout(animate, 1);
        } else {
          counter.innerText = value;
        }
      };

      // Start animation when element is in viewport
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animate();
            observer.unobserve(entry.target);
          }
        });
      });

      observer.observe(counter);
    });
  });
</script>

<style scoped>
  .animate-fade-in {
    animation: fadeIn 1s ease-in-out;
  }

  .animate-fade-in-up {
    animation: fadeInUp 1s ease-in-out;
  }

  .animate-fade-in-up-delay {
    animation: fadeInUp 1s ease-in-out 0.3s;
    animation-fill-mode: both;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>
