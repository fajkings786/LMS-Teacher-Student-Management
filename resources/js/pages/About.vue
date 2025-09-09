<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <div
      class="relative bg-gradient-to-r from-purple-900 to-indigo-900 text-white py-32 px-4"
    >
      <div class="absolute inset-0 bg-black opacity-30"></div>
      <div class="relative max-w-6xl mx-auto text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
          About Our Learning Platform
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-10 animate-fade-in-up">
          Empowering learners worldwide with innovative education solutions since 2015
        </p>
        <div class="flex justify-center space-x-4 animate-fade-in-up-delay">
          <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-4 text-center">
            <div class="text-3xl font-bold">500+</div>
            <div class="text-sm">Courses</div>
          </div>
          <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-4 text-center">
            <div class="text-3xl font-bold">10,000+</div>
            <div class="text-sm">Students</div>
          </div>
          <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-4 text-center">
            <div class="text-3xl font-bold">200+</div>
            <div class="text-sm">Instructors</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Our Story Section -->
    <div class="py-20 bg-gradient-to-br from-gray-50 to-white">
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Story</h2>
          <div
            class="w-24 h-1 bg-gradient-to-r from-purple-500 to-indigo-500 mx-auto mb-4"
          ></div>
          <p class="text-gray-600 max-w-2xl mx-auto">
            From a simple idea to a global education platform
          </p>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-12">
          <div class="md:w-1/2">
            <div class="relative">
              <img
                src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                alt="Our story"
                class="rounded-2xl shadow-xl"
              />
              <div
                class="absolute -bottom-6 -right-6 bg-purple-600 text-white p-6 rounded-2xl shadow-lg max-w-xs"
              >
                <div class="text-3xl font-bold">2015</div>
                <div>Founded with a vision</div>
              </div>
            </div>
          </div>
          <div class="md:w-1/2">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Journey</h3>
            <p class="text-gray-600 mb-4">
              It all started in 2015 when our founders recognized a gap in the education
              system. They envisioned a platform where anyone, anywhere could access
              quality education without barriers.
            </p>
            <p class="text-gray-600 mb-4">
              Today, we've grown into a global community of learners and educators,
              offering hundreds of courses across various disciplines. Our mission remains
              the same: to make education accessible, engaging, and effective for
              everyone.
            </p>
            <div class="flex items-center mt-6">
              <div
                class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mr-4"
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
                    d="M13 10V3L4 14h7v7l9-11h-7z"
                  />
                </svg>
              </div>
              <div>
                <div class="font-bold text-gray-800">Fast Growing</div>
                <div class="text-gray-600">Expanding to new markets every year</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mission, Vision, Values Section -->
    <div class="py-20 bg-gradient-to-r from-purple-700 to-indigo-800 text-white">
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold mb-4">What Drives Us</h2>
          <div class="w-24 h-1 bg-white mx-auto mb-4"></div>
          <p class="text-purple-200 max-w-2xl mx-auto">
            Our core principles guide everything we do
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          <div
            class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8 shadow-xl hover:bg-opacity-20 transition-all duration-300 transform hover:-translate-y-2"
          >
            <div
              class="w-16 h-16 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-white text-2xl mb-6 mx-auto"
            >
              📘
            </div>
            <h3 class="text-2xl font-bold text-center mb-4">Our Mission</h3>
            <p class="text-center text-purple-100">
              We provide quality education and resources to help students grow
              academically, professionally, and personally. We believe in the
              transformative power of education.
            </p>
          </div>

          <div
            class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8 shadow-xl hover:bg-opacity-20 transition-all duration-300 transform hover:-translate-y-2"
          >
            <div
              class="w-16 h-16 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-white text-2xl mb-6 mx-auto"
            >
              🚀
            </div>
            <h3 class="text-2xl font-bold text-center mb-4">Our Vision</h3>
            <p class="text-center text-purple-100">
              To create a digital platform where learning never stops. We envision a world
              where anyone can learn anything, anywhere, at any time.
            </p>
          </div>

          <div
            class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8 shadow-xl hover:bg-opacity-20 transition-all duration-300 transform hover:-translate-y-2"
          >
            <div
              class="w-16 h-16 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-white text-2xl mb-6 mx-auto"
            >
              🤝
            </div>
            <h3 class="text-2xl font-bold text-center mb-4">Our Values</h3>
            <p class="text-center text-purple-100">
              Commitment to excellence, innovation in education, and integrity in all our
              interactions. We value diversity, inclusion, and the power of community.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Team Section -->
    <div class="py-20 bg-white">
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold text-gray-800 mb-4">Meet Our Team</h2>
          <div
            class="w-24 h-1 bg-gradient-to-r from-purple-500 to-indigo-500 mx-auto mb-4"
          ></div>
          <p class="text-gray-600 max-w-2xl mx-auto">
            The passionate people behind our success
          </p>
        </div>

        <div class="grid md:grid-cols-4 gap-8">
          <div class="text-center group">
            <div class="relative overflow-hidden rounded-2xl mb-4 mx-auto w-48 h-48">
              <img
                src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                alt="Team member"
                class="w-full h-full object-cover"
              />
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4"
              >
                <div class="text-white">
                  <div class="font-bold">CEO & Founder</div>
                </div>
              </div>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Sarah Johnson</h3>
            <p class="text-gray-600">CEO & Founder</p>
            <div class="flex justify-center space-x-3 mt-3">
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    fill-rule="evenodd"
                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                    clip-rule="evenodd"
                  />
                </svg>
              </a>
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"
                  />
                </svg>
              </a>
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    fill-rule="evenodd"
                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                    clip-rule="evenodd"
                  />
                </svg>
              </a>
            </div>
          </div>

          <div class="text-center group">
            <div class="relative overflow-hidden rounded-2xl mb-4 mx-auto w-48 h-48">
              <img
                src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                alt="Team member"
                class="w-full h-full object-cover"
              />
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4"
              >
                <div class="text-white">
                  <div class="font-bold">CTO</div>
                </div>
              </div>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Michael Chen</h3>
            <p class="text-gray-600">CTO</p>
            <div class="flex justify-center space-x-3 mt-3">
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    fill-rule="evenodd"
                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                    clip-rule="evenodd"
                  />
                </svg>
              </a>
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"
                  />
                </svg>
              </a>
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    fill-rule="evenodd"
                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                    clip-rule="evenodd"
                  />
                </svg>
              </a>
            </div>
          </div>

          <div class="text-center group">
            <div class="relative overflow-hidden rounded-2xl mb-4 mx-auto w-48 h-48">
              <img
                src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                alt="Team member"
                class="w-full h-full object-cover"
              />
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4"
              >
                <div class="text-white">
                  <div class="font-bold">Head of Education</div>
                </div>
              </div>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Emily Rodriguez</h3>
            <p class="text-gray-600">Head of Education</p>
            <div class="flex justify-center space-x-3 mt-3">
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    fill-rule="evenodd"
                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                    clip-rule="evenodd"
                  />
                </svg>
              </a>
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"
                  />
                </svg>
              </a>
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    fill-rule="evenodd"
                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                    clip-rule="evenodd"
                  />
                </svg>
              </a>
            </div>
          </div>

          <div class="text-center group">
            <div class="relative overflow-hidden rounded-2xl mb-4 mx-auto w-48 h-48">
              <img
                src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                alt="Team member"
                class="w-full h-full object-cover"
              />
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4"
              >
                <div class="text-white">
                  <div class="font-bold">Marketing Director</div>
                </div>
              </div>
            </div>
            <h3 class="text-xl font-bold text-gray-800">David Wilson</h3>
            <p class="text-gray-600">Marketing Director</p>
            <div class="flex justify-center space-x-3 mt-3">
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    fill-rule="evenodd"
                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                    clip-rule="evenodd"
                  />
                </svg>
              </a>
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"
                  />
                </svg>
              </a>
              <a href="#" class="text-purple-600 hover:text-purple-800">
                <svg
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    fill-rule="evenodd"
                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                    clip-rule="evenodd"
                  />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Achievements Section -->
    <div class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Achievements</h2>
          <div
            class="w-24 h-1 bg-gradient-to-r from-purple-500 to-indigo-500 mx-auto mb-4"
          ></div>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Milestones that mark our journey of excellence
          </p>
        </div>

        <div class="grid md:grid-cols-4 gap-6">
          <div
            class="bg-white p-6 rounded-2xl shadow-lg text-center transform transition-transform duration-300 hover:scale-105"
          >
            <div class="text-4xl text-purple-600 mb-4">🏆</div>
            <div class="text-3xl font-bold text-gray-800 mb-2">25+</div>
            <div class="text-gray-600">Awards Won</div>
          </div>

          <div
            class="bg-white p-6 rounded-2xl shadow-lg text-center transform transition-transform duration-300 hover:scale-105"
          >
            <div class="text-4xl text-purple-600 mb-4">🌍</div>
            <div class="text-3xl font-bold text-gray-800 mb-2">50+</div>
            <div class="text-gray-600">Countries</div>
          </div>

          <div
            class="bg-white p-6 rounded-2xl shadow-lg text-center transform transition-transform duration-300 hover:scale-105"
          >
            <div class="text-4xl text-purple-600 mb-4">💼</div>
            <div class="text-3xl font-bold text-gray-800 mb-2">95%</div>
            <div class="text-gray-600">Job Placement</div>
          </div>

          <div
            class="bg-white p-6 rounded-2xl shadow-lg text-center transform transition-transform duration-300 hover:scale-105"
          >
            <div class="text-4xl text-purple-600 mb-4">⭐</div>
            <div class="text-3xl font-bold text-gray-800 mb-2">4.9/5</div>
            <div class="text-gray-600">User Rating</div>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="py-20 bg-gradient-to-r from-purple-700 to-indigo-800 text-white">
      <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-6">Join Our Learning Community</h2>
        <p class="text-xl mb-10 max-w-2xl mx-auto">
          Become part of a global network of learners and educators transforming their
          futures through education.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <router-link
            to="/signup"
            class="bg-white text-purple-700 hover:bg-gray-100 font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg"
          >
            Get Started
          </router-link>
          <router-link
            to="/courses"
            class="bg-transparent border-2 border-white hover:bg-white hover:text-purple-700 font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105"
          >
            Explore Courses
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "AboutUs",
  };
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
