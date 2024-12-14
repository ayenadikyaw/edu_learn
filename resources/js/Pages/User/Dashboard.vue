<script setup>
import AuthenticatedLayout from "@/Components/Layouts/authenticated.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import RecommendedCourses from "@/Components/RecommendedCourses.vue";
import { onMounted, ref } from "vue";
import axios from "axios";
const latestCourse = ref({});
const completedCourses = ref([]);
const enrolledCourses = ref([]);

const props = defineProps({
    enrolledCourses: Object,
});


const navigate = (url) => {
    if (!url) return;
    router.visit(url, {
        preserveScroll: true,
        preserveState: true,
        replace: true
    });
};

//fetch data
onMounted(async () => {
    await axios.get("/student-dashboard/latest-course").then((response) => {
        latestCourse.value = response.data;
        latestCourse.value = latestCourse.value[0];
        console.log(latestCourse.value, "latest course");
    });
    await axios.get("/student-dashboard/completed-courses").then((response) => {
        completedCourses.value = response.data;
    });
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <main class="min-h-screen bg-gray-50">
            <!-- Current Course Section -->
            <section
                class="py-12 bg-gradient-to-b from-primary/5 to-transparent"
            >
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8 mt-16">
                        Continue Learning
                    </h2>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div
                            class="flex flex-col md:flex-row items-center gap-6"
                        >
                            <img
                                :src="`${latestCourse.profile_image?latestCourse.profile_image:'/assets/images/defaultCourse.jpg'}`"
                                alt="Course thumbnail"
                                class="w-full md:w-64 h-40 object-cover rounded-lg"
                            />

                            <div class="flex-1">
                                <h3 class="text-xl font-semibold mb-2">
                                    {{ latestCourse.title }}
                                </h3>
                                <div
                                    class="flex items-center text-sm text-gray-600 mb-4"
                                >
                                    <i class="pi pi-clock mr-2"></i>
                                    <span>Progress: 60%</span>
                                </div>
                                <div
                                    class="w-full bg-gray-200 rounded-full h-2.5 mb-4"
                                >
                                    <div
                                        class="bg-primary h-2.5 rounded-full"
                                        style="width: 60%"
                                    ></div>
                                </div>
                                <Link
                                    :href="`/courses/learn/${latestCourse.id}`"
                                    class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors"
                                >
                                    Go to Course
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Stats Section -->
            <section class="py-12 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-xl p-6 text-center">
                            <div class="text-4xl font-bold text-primary mb-2">
                                {{ completedCourses.length }}
                            </div>
                            <div class="text-gray-600">Courses Completed</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-6 text-center">
                            <div class="text-4xl font-bold text-primary mb-2">
                                {{
                                    completedCourses.reduce(
                                        (total, course) =>
                                            total + course.duration,
                                        0
                                    )
                                }}
                            </div>
                            <div class="text-gray-600">Hours Learned</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-6 text-center">
                            <div class="text-4xl font-bold text-primary mb-2">
                                {{ completedCourses.length }}
                            </div>
                            <div class="text-gray-600">Certificates Earned</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Completed Courses -->
            <section class="py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">
                        Completed Courses
                    </h2>

                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <div
                            v-if="completedCourses.length > 0"
                            v-for="course in completedCourses"
                            class="bg-white rounded-xl shadow-lg p-6"
                        >
                            <img
                                :src="`${course.profile_image?course.profile_image:'/assets/images/defaultCourse.jpg'}`"
                                alt="Course"
                                class="w-full h-48 object-cover rounded-lg mb-4"
                            />
                            <h3 class="text-lg font-semibold mb-2">
                                {{ course.title }}
                            </h3>
                            <div
                                class="flex items-center text-sm text-green-600 mb-4"
                            >
                                <i class="pi pi-check-circle mr-2"></i>
                                <span>Completed</span>
                            </div>
                            <button
                                class="text-primary hover:text-primary/80 font-medium"
                            >
                                View Certificate
                            </button>
                        </div>
                        <div v-else>
                            <p class="text-gray-600">No completed courses yet.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!--Enrolled Courses-->
            <section class="py-12 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">
                        Enrolled Courses
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div
                            v-if="props.enrolledCourses.data.length > 0"
                            v-for="course in props.enrolledCourses.data"
                            class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow"
                        >
                            <img
                                :src="`${course.profile_image?course.profile_image:'/assets/images/defaultCourse.jpg'}`"
                                alt="Course"
                                class="w-full h-48 object-cover rounded-lg mb-4"
                            />
                            <h3 class="text-lg font-semibold mb-2">
                                {{ course.title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4">
                                {{
                                    course.short_description
                                }}
                            </p>
                            <Link
                                :href="`/courses/learn/${course.id}`"
                                class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors w-full"
                            >
                                Go to Course
                            </Link>
                        </div>
                        <div v-else>
                            <p class="text-gray-600">No enrolled courses yet.</p>
                        </div>
                        <!--Pagination-->
                        <div class="col-span-full flex justify-center mt-6">
                            <div class="flex gap-2">
                                <a
                                    v-for="link in props.enrolledCourses.links"
                                    :key="link.url"
                                    :href="link.url"
                                    class="px-4 py-2 border rounded-lg"
                                    :class="{
                                        'bg-primary text-white': link.active,
                                        'text-gray-700 hover:bg-gray-50':
                                            !link.active,
                                        'opacity-50 cursor-not-allowed':
                                            !link.url,
                                    }"
                                    v-html="link.label"
                                    @click="navigate(link.url)"
                                ></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Course Carousel -->
            <section class="py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">
                        Recommended Courses
                    </h2>

                    <RecommendedCourses />
                </div>
            </section>
        </main>
    </AuthenticatedLayout>
</template>
