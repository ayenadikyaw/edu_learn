<script setup>
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const courses = ref([]);

onMounted(async () => {
   try {
    const response = await axios.get(route('courses.getCourses'));
    courses.value = response.data;
    console.log(courses.value);
   } catch (error) {
    console.error(error);
   }
});

const getCourseBadgeColor = (badge) => {
    if (badge === 'new') {
        return 'from-primary to-primary_light';
    }
    return 'from-secondary to-secondary_light';
}

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
                            <img :src="course.image ? course.image : '/assets/images/defaultCourse1.jpg'" :alt="course.title" class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-500"/>
                            <div v-if="course.badge" class="absolute top-3 right-3 bg-gradient-to-r text-white px-3 py-1 rounded-full text-sm font-medium shadow-lg backdrop-blur-sm" :class="getCourseBadgeColor(course.badge)">
                                {{ course.badge }}
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-6 relative">
                            <div class="flex items-center mb-2 bg-gray-50 w-fit px-3 py-1 rounded-full">
                                <i class="pi pi-book text-primary mr-2"></i>
                                <span class="text-sm font-medium text-gray-600">{{ course.lessons.length }} Lessons</span>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-primary transition-colors duration-200">{{ course.title }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ course.short_description }}</p>
                            <div class="flex justify-between items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Course Fee</span>
                                    <span class="text-xl font-bold text-primary">${{ course.price }}</span>
                                </div>
                                <Link :href="route('courses.show', course.id)" class="bg-primary hover:bg-primary_light text-white px-4 py-2 rounded-full font-medium transition-all duration-200 shadow-md hover:shadow-xl hover:-translate-y-0.5">
                                    View Course
                                </Link>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>

</template>
