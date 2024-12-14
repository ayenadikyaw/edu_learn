<script setup>
const testimonials = [
  {
    id: 1,
    name: "Sarah Johnson",
    role: "Web Development Student",
    message: "This course transformed my career path. The hands-on projects and supportive community made learning enjoyable and effective.",
    avatar: "/assets/images/student1.jpg"
  },
  {
    id: 2, 
    name: "Michael Chen",
    role: "Data Science Student",
    message: "The instructors are incredibly knowledgeable and always available to help. I've gained practical skills that I use daily in my new job.",
    avatar: "/assets/images/student2.jpg"
  },
  {
    id: 3,
    name: "Emma Williams",
    role: "UI/UX Design Student", 
    message: "The curriculum is well-structured and up-to-date with industry standards. I feel confident in my abilities after completing this program.",
    avatar: "/assets/images/student3.jpg"
  }
];
</script>

<template>
  <section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-primary mb-4">What Our Students Say</h2>
        <div class="w-24 h-1 bg-primary mx-auto rounded-full"></div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div 
          v-for="testimonial in testimonials" 
          :key="testimonial.id"
          class="relative group"
        >
          <div class="absolute inset-0 bg-primary transform rotate-6 rounded-2xl opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
          <div class="relative p-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center mb-6">
              <img 
                :src="testimonial.avatar" 
                :alt="testimonial.name"
                class="w-16 h-16 rounded-full object-cover border-4 border-primary/20"
              />
              <div class="ml-4">
                <h3 class="text-xl font-semibold text-gray-900">{{ testimonial.name }}</h3>
                <p class="text-primary">{{ testimonial.role }}</p>
              </div>
            </div>
            
            <div class="relative">
              <svg 
                class="absolute -top-4 -left-4 w-8 h-8 text-primary/20 transform -rotate-12"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
              </svg>
              <p class="text-gray-600 italic leading-relaxed">{{ testimonial.message }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

