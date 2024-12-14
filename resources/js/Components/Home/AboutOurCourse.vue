<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
const features = [
    {
        icon: 'pi pi-users',
        title: 'Expert Instructors',
        description: 'Learn from industry professionals with years of real-world experience'
    },
    {
        icon: 'pi pi-clock',
        title: 'Flexible Learning',
        description: 'Study at your own pace with lifetime access to course materials'
    },
    {
        icon: 'pi pi-check-circle',
        title: 'Practical Projects',
        description: 'Apply your knowledge through hands-on projects and real-world scenarios'
    }
];

const totalStudents = ref(0);
const totalCourses = ref(0);


onMounted(() => {
    axios.get('/total-students').then(response => {
        totalStudents.value = response.data;
    });
    axios.get('/total-courses').then(response => {
        totalCourses.value = response.data;
    });
});
</script>

<template>
    <div class="relative py-20 overflow-hidden">
        <!-- Decorative Shapes -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-primary/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary/10 rounded-full translate-x-1/2 translate-y-1/2"></div>
        <div class="absolute top-1/2 left-1/2 w-48 h-48 bg-primary/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>

        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Image Section -->
                <div class="lg:w-1/2 relative">
                    <div class="relative z-10">
                        <img 
                            src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3"
                            alt="Students Learning"
                            class="rounded-2xl shadow-2xl w-full object-cover h-[600px]"
                        />
                        <!-- Floating Stats Card -->
                        <div class="absolute -bottom-10 -right-10 bg-white p-6 rounded-xl shadow-xl">
                            <div class="flex gap-8">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-primary">{{ totalCourses }}+</div>
                                    <div class="text-gray-600">Courses</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-primary">{{ totalStudents }}</div>
                                    <div class="text-gray-600">Students</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 left-0 w-full h-full">
                        <div class="absolute -top-4 -left-4 w-24 h-24 bg-secondary/20 rounded-full"></div>
                        <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-primary/20 rounded-full"></div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="lg:w-1/2">
                    <div class="space-y-6">
                        <h2 class="text-4xl font-bold text-gray-800 leading-tight">
                            Transform Your Future with Our 
                            <span class="text-primary">Premium Courses</span>
                        </h2>
                        <p class="text-gray-600 text-lg">
                            We offer cutting-edge courses designed to equip you with the skills needed in today's digital world. 
                            Our comprehensive curriculum combines theoretical knowledge with practical experience.
                        </p>

                        <!-- Features Grid -->
                        <div class="grid gap-6 mt-8">
                            <div v-for="feature in features" :key="feature.title" 
                                class="flex items-start gap-4 p-4 rounded-xl bg-white shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                <div class="bg-primary/10 p-3 rounded-full">
                                    <i :class="feature.icon" class="text-2xl text-primary"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800">{{ feature.title }}</h3>
                                    <p class="text-gray-600">{{ feature.description }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <Link :href="route('courses.index')" class="mt-4 bg-primary hover:bg-primary_light text-white px-8 py-3 rounded-full font-semibold transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                Explore Our Courses
                        </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
