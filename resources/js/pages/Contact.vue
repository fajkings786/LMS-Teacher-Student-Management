<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-100 p-4 md:p-12">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-indigo-800 mb-6">Contact Us</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Get in Touch</h2>
            <p class="text-gray-600 mb-6">
              Have questions or feedback? We'd love to hear from you. Fill out the form and our team will get back to you as soon as possible.
            </p>
            
            <div class="space-y-4">
              <div class="flex items-start">
                <svg class="h-6 w-6 text-indigo-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <div>
                  <h3 class="font-medium text-gray-800">Address</h3>
                  <p class="text-gray-600">123 Education Street, Learning City, LC 12345</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <svg class="h-6 w-6 text-indigo-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <div>
                  <h3 class="font-medium text-gray-800">Phone</h3>
                  <p class="text-gray-600">+1 (555) 123-4567</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <svg class="h-6 w-6 text-indigo-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <div>
                  <h3 class="font-medium text-gray-800">Email</h3>
                  <p class="text-gray-600">support@learningmanagementsystem.com</p>
                </div>
              </div>
            </div>
          </div>
          
          <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Send us a Message</h2>
            
            <form @submit.prevent="submitForm">
              <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="name">
                  Your Name
                </label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  required
                />
              </div>
              
              <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="email">
                  Your Email
                </label>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  required
                />
              </div>
              
              <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="subject">
                  Subject
                </label>
                <input
                  id="subject"
                  v-model="form.subject"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  required
                />
              </div>
              
              <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="message">
                  Message
                </label>
                <textarea
                  id="message"
                  v-model="form.message"
                  rows="4"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  required
                ></textarea>
              </div>
              
              <button
                type="submit"
                :disabled="isSubmitting"
                class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center justify-center"
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
                {{ isSubmitting ? 'Sending...' : 'Send Message' }}
              </button>
            </form>
            
            <div
              v-if="successMessage"
              class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg"
            >
              {{ successMessage }}
            </div>
            
            <div
              v-if="errorMessage"
              class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg"
            >
              {{ errorMessage }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import axios from 'axios';

const isSubmitting = ref(false);
const successMessage = ref('');
const errorMessage = ref('');

const form = reactive({
  name: '',
  email: '',
  subject: '',
  message: ''
});

const submitForm = async () => {
  isSubmitting.value = true;
  successMessage.value = '';
  errorMessage.value = '';
  
  try {
    // This is a placeholder - you would need to create a contact endpoint in your Laravel backend
    const response = await axios.post('/api/contact', form, {
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
      },
    });
    
    if (response.data.success) {
      successMessage.value = 'Your message has been sent successfully!';
      
      // Reset form
      Object.keys(form).forEach(key => {
        form[key] = '';
      });
    } else {
      errorMessage.value = response.data.message || 'Failed to send message';
    }
  } catch (error) {
    console.error('Error sending message:', error);
    errorMessage.value = 'Failed to send message. Please try again later.';
  } finally {
    isSubmitting.value = false;
  }
};
</script>