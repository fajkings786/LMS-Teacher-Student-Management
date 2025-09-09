<script setup lang="ts">
  import Navbar from "./components/Navbar.vue";
  import Footer from "./components/Footer.vue";
  // import Footer from './components/Footer.vue';
</script>

<template>
  <div>
    <!-- Navbar -->
    <Navbar></Navbar>
    <!-- Pages Load Here -->
    <router-view />
    <Footer></Footer>
  </div>
</template>
