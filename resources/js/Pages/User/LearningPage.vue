<script setup>
import AuthenticatedLayout from "@/Components/Layouts/authenticated.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";

const course = ref({});
const isCompleted = ref(0);
const props = defineProps({
    course: Object
});
console.log(props.course.is_completed, "course info");

const courseProgress = ref(60);

const toggleCourseComplete = () => {
    axios.post(`/courses/complete/${props.course.course.id}`, {
        completed: isCompleted.value
    })
    .then(response => {
        isCompleted.value = response.data.completed;
    })
    .catch(error => {
        console.error('Error toggling course completion:', error);
        // Handle the error appropriately
    });
};

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Learning Page" />

        <main class="min-h-screen bg-gray-50 mt-24">
            <!-- Course Header -->
            <section class="bg-gradient-to-r from-primary/10 to-primary/5 py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ props.course.course.title }}</h1>
                            <div class="mt-2 flex items-center gap-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="pi pi-clock mr-2"></i>
                                    <span>Progress: {{ courseProgress }}%</span>
                                </div>
                                <div class="w-48 bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-primary h-2.5 rounded-full" :style="`width: ${courseProgress}%`"></div>
                                </div>
                            </div>
                        </div>
                        <button class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                            Next Lesson
                        </button>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Video Player Section -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="aspect-w-16 aspect-h-9 bg-gray-800">
                    
                                <div class="flex items-center justify-center h-full text-white">
                                    Lesson Content
                                </div>
                            </div>
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900">{{ props.course.course.title }}</h2>
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <span class="text-sm text-gray-600">
                                            <i class="pi pi-clock mr-2"></i>
                                            {{ props.course.course.duration }}
                                        </span>
                                    </div>
                                    <button 
                                        @click="toggleCourseComplete"
                                        :class="[
                                            'px-4 py-2 rounded-lg text-sm font-medium',
                                            props.course.is_completed == 1
                                                ? 'bg-green-100 text-green-700' 
                                                : 'bg-primary/10 text-primary hover:bg-primary/20'
                                        ]"
                                    >
                                        {{ props.course.is_completed == 1 ? 'Completed' : 'Mark as Complete' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Content Sidebar -->
                    <div class="bg-white rounded-xl shadow-lg p-6 h-fit">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ props.course.course.title }}</h3>
                        <div class="space-y-3">
                            <div v-if="props.course.course.lessons.length > 0"
                                v-for="(lesson, index) in props.course.course.lessons" 
                                :key="index"
                                class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                :class="{'bg-gray-50': index === 0}"
                            >
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center"
                                        :class="lesson.completed ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600'"
                                    >
                                        <i class="pi" :class="lesson.completed ? 'pi-check' : 'pi-play'"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">{{ lesson.title }}</span>
                                </div>
                                <span class="text-sm text-gray-500">50:00 minutes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>
