<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <section class="bg-gray-50 py-20">
    <div class="container mx-auto px-4">
      <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-primary mb-6">Get in Touch</h2>
        <p class="text-gray-600 text-lg mb-10">
          Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
        </p>
        <Link
          href="/contact-us"
          class="inline-flex items-center px-8 py-4 bg-primary hover:bg-primary_light transition-colors duration-300 rounded-full text-white font-semibold text-lg group"
        >
          Contact Us
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            class="h-6 w-6 ml-2 group-hover:translate-x-2 transition-transform duration-300" 
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor"
          >
            <path 
              stroke-linecap="round" 
              stroke-linejoin="round" 
              stroke-width="2" 
              d="M14 5l7 7m0 0l-7 7m7-7H3" 
            />
          </svg>
        </Link>
      </div>
      
      <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto text-center">
        <div class="p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="pi pi-envelope text-xl text-primary"></i>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Email Us</h3>
          <p class="text-gray-600">We're here to help with any questions</p>
        </div>
        
        <div class="p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="w-12 h-12 bg-secondary/60 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="pi pi-phone text-xl text-primary"></i>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Call Us</h3>
          <p class="text-gray-600">Speak directly with our team</p>
        </div>
        
        <div class="p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="pi pi-comments text-xl text-primary"></i>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Live Chat</h3>
          <p class="text-gray-600">Connect with us instantly</p>
        </div>
      </div>
    </div>
  </section>
</template>
