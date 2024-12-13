<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

const isScrolled = ref(false);

const handleScroll = () => {
  isScrolled.value = window.scrollY > 0;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
const handleLogin = () => {
  window.location.href = '/login';
};

const handleRegister = () => {
  window.location.href = '/register';
};
</script>

<template>
  <div
    :class="[
      'transition-all duration-300 ease-in-out fixed top-0 left-0 w-full h-20 z-50',
      isScrolled ? 'bg-white shadow-md' : 'bg-white'
    ]"
  >
    <div class="flex items-center justify-between">
      <!-- Logo -->
      <ApplicationLogo class="ml-4 w-24" />

      <!-- Navigation Menu -->
      <div class="flex items-center gap-6 text-md font-semibold text-primary">
        <Link href="/" class="menu-item hover:text-primary_light transition-colors duration-200">Home</Link>
        <Link href="/about-us" class="menu-item hover:text-primary_light transition-colors duration-200">About Us</Link>
        <Link href="/courses" class="menu-item hover:text-primary_light transition-colors duration-200">Courses</Link>
        <Link href="/contact-us" class="menu-item hover:text-primary_light transition-colors duration-200">Contact Us</Link>
      </div>

      <!-- Buttons -->
      <div class="flex items-center gap-4">
        <button @click="handleLogin" class="bg-primary hover:bg-primary_light text-white px-3 py-1.5 rounded-md text-sm transition-colors duration-200 shadow-sm hover:shadow-md">
          Login
        </button>
        <button @click="handleRegister" class="bg-secondary hover:bg-secondary_light text-white px-3 py-1.5 rounded-md text-sm transition-colors duration-200 shadow-sm hover:shadow-md">
          Register
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.menu-item {
  position: relative;
  overflow: hidden;
}

.menu-item::v-deep::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 0;
  background-color: #7ed957;
  transition: width 0.3s ease;
}

.menu-item:hover::v-deep::after {
  width: 100%;
}
</style>
