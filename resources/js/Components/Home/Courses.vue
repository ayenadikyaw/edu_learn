<script setup>
import { Link } from '@inertiajs/vue3';
//demo data
const courses = [
    {
        id: 1,
        title: 'Web Development Fundamentals',
        description: 'Learn the core concepts of web development from scratch',
        image: 'https://placehold.co/600x400',
        lessons: 12,
        price: 99.99,
        badge: 'Popular',
        badgeColor: 'from-primary to-primary_light'
    },
    {
        id: 2,
        title: 'Advanced JavaScript Mastery',
        description: 'Deep dive into modern JavaScript concepts and frameworks',
        image: 'https://placehold.co/600x400',
        lessons: 15,
        price: 129.99,
        badge: 'New',
        badgeColor: 'from-green-400 to-green-600'
    },
    {
        id: 3,
        title: 'UI/UX Design Principles',
        description: 'Master the art of creating beautiful and functional user interfaces',
        image: 'https://placehold.co/600x400',
        lessons: 10,
        price: 89.99,
        badge: 'Popular',
        badgeColor: 'from-primary to-primary_light'
    }
]
</script>

<template>
    <div>
        <div class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <!-- Section Header -->
                <div class="text-center mb-12 animate-fade-in">
                    <h2 class="text-4xl font-bold text-primary mb-4">Our Featured Courses</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Discover our carefully curated selection of courses designed to help you achieve your learning goals</p>
                </div>
                <!-- Course Cards Container -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Course Card -->
                    <Link :href="route('courses.show', course.id)" v-for="course in courses" :key="course.id" 
                        class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300 border border-gray-100 hover:shadow-xl group">
                        <div class="relative">
                            <img :src="course.image" :alt="course.title" class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-500"/>
                            <div class="absolute top-3 right-3 bg-gradient-to-r text-white px-3 py-1 rounded-full text-sm font-medium shadow-lg backdrop-blur-sm" :class="course.badgeColor">
                                {{ course.badge }}
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-6 relative">
                            <div class="flex items-center mb-2 bg-gray-50 w-fit px-3 py-1 rounded-full">
                                <i class="pi pi-book text-primary mr-2"></i>
                                <span class="text-sm font-medium text-gray-600">{{ course.lessons }} Lessons</span>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-primary transition-colors duration-200">{{ course.title }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ course.description }}</p>
                            <div class="flex justify-between items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Course Fee</span>
                                    <span class="text-xl font-bold text-primary">${{ course.price }}</span>
                                </div>
                                <button class="bg-primary hover:bg-primary_light text-white px-4 py-2 rounded-full font-medium transition-all duration-200 shadow-md hover:shadow-xl hover:-translate-y-0.5">
                                    Enroll Now
                                </button>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>

</template>
