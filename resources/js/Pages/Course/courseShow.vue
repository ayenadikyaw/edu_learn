<script setup>
import { Link, Head } from "@inertiajs/vue3";
import Breadcrumb from "../../Components/Course/Breadcrumb.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import DefaultLayout from "@/Components/Layouts/default.vue";
import AuthenticatedLayout from "@/Components/Layouts/authenticated.vue";
import { computed } from "vue";
import axios from "axios";
import { useToast } from "primevue";

const toast = useToast();
const role = usePage().props?.auth?.user?.role || "guest";
const page = usePage();
const layout = computed(() => {
    if (role && role === "user") {
        return AuthenticatedLayout;
    } else {
        return DefaultLayout;
    }
});

const isEnrolled = ref(false);
const props = defineProps({
    course: Object,
});
console.log(props.course);
//fetch enrolled courses
const enrolledCourses = ref([]);
onMounted(async () => {
    const { data } = await axios.get(
        route("enrolled-courses.check", props.course.id)
    );
    enrolledCourses.value = data;
    if (enrolledCourses.value.id) {
        isEnrolled.value = true;
    }
});
const course_data = {
    id: props.course.id,
    title: props.course.title,
    description: props.course.short_description,
    image: props.course.profile_image,
    lessons: props.course.lessons.length,
    price: props.course.price,
    badge: props.course.badge,
    badgeColor: "from-primary to-primary_light",
    rating: 4.5,
    ratingCount: 100,
    students: 1000,
    duration: props.course.duration,
    level: props.course.level,
    requirements: ["Basic knowledge of HTML, CSS, and JavaScript"],
    whatYouWillLearn: props.course.learning_points,
    includes: [
        "12 hours of video content",
        "10 practical projects",
        "24/7 support",
    ],
    syllabus: props.course.lessons.map((lesson) => ({
        title: lesson.title,
    })),
};

const breadcrumbItems = [
    { label: "Home", url: "/" },
    { label: "Courses", url: "/courses" },
    { label: course_data.title, url: `/courses/${course_data.id}` },
];

const handleEnroll = () => {
    if (page.props.auth.user) {
        console.log("Enroll");
        router.post(
            route("courses.enroll", course_data.id),
            {},
            {
                onSuccess: () => {
                    toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: "You have enrolled in this course successfully!",
                        life: 3000,
                    });
                    isEnrolled.value = true;
                },
                onError: () => {
                    toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "You have already enrolled in this course!",
                        life: 3000,
                    });
                },
            }
        );
    } else {
        toast.add({
            severity: "info",
            summary: "Info", 
            detail: "Please login to enroll in this course",
            life: 3000,
            onClose: () => {
                router.get(route("login"));
            }
        });
    }
};
</script>

<template>
    <component :is="layout">
        <Head :title="`Course ${course_data.id}`" />
        <div class="container mx-auto px-4 mt-24 mb-20">
            <Breadcrumb :items="breadcrumbItems" />
            <!-- Course Header -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <div class="relative">
                    <img
                        :src="course_data.image ? course_data.image : '/assets/images/defaultCourse1.jpg'"
                        :alt="course_data.title"
                        class="w-full h-[400px] object-cover rounded-2xl shadow-lg"
                    />
                    <div v-if="course_data.badge"
                        class="absolute top-4 right-4 bg-gradient-to-r text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg"
                        :class="course_data.badgeColor"
                    >
                        {{ course_data.badge }}
                    </div>
                </div>

                <div class="flex flex-col justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">
                            {{ course_data.title }}
                        </h1>
                        <p class="text-base text-gray-600 mb-6">
                            {{ course_data.description }}
                        </p>

                        <div class="flex items-center gap-6 mb-6">
                            <div class="flex items-center">
                                <i
                                    class="pi pi-star-fill text-yellow-400 mr-2"
                                ></i>
                                <span class="font-semibold">{{
                                    course_data.rating
                                }}</span>
                                <span class="text-gray-500"
                                    >({{
                                        course_data.ratingCount
                                    }}
                                    reviews)</span
                                >
                            </div>
                            <div class="flex items-center">
                                <i class="pi pi-users text-primary mr-2"></i>
                                <span>{{ course_data.students }} students</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-xl shadow-lg border border-gray-100"
                    >
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-3xl font-bold text-primary"
                                >${{ course_data.price }}</span
                            >
                            <div class="flex items-center gap-2">
                                <i class="pi pi-clock text-gray-500"></i>
                                <span>{{ course_data.duration }} hours</span>
                            </div>
                        </div>
                        <button
                            @click="handleEnroll"
                            class="w-full bg-primary hover:bg-primary_light text-white py-4 rounded-xl font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl"
                            :disabled="isEnrolled"
                        >
                            {{ isEnrolled ? "Enrolled" : "Enroll Now" }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Course Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h2 class="text-2xl font-bold mb-6">
                            What You'll Learn
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                v-for="(
                                    item, index
                                ) in course_data.whatYouWillLearn"
                                :key="index"
                                class="flex items-start gap-2"
                            >
                                <i
                                    class="pi pi-check-circle text-primary mt-1"
                                ></i>
                                <span>{{ item }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold mb-6">Course Content</h2>
                        <div class="space-y-4">
                            <div
                                v-for="(section, index) in course_data.syllabus"
                                :key="index"
                                class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                            >
                                <div class="flex justify-between items-center">
                                    <h3 class="font-semibold">
                                        {{ section.title }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold mb-4">
                            This course includes:
                        </h3>
                        <div class="space-y-3">
                            <div
                                v-for="(item, index) in course_data.includes"
                                :key="index"
                                class="flex items-center gap-2"
                            >
                                <i class="pi pi-check text-primary"></i>
                                <span>{{ item }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold mb-4">Requirements</h3>
                        <ul class="list-disc list-inside space-y-2">
                            <li
                                v-for="(req, index) in course_data.requirements"
                                :key="index"
                                class="text-gray-600"
                            >
                                {{ req }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <Toast />
    </component>
</template>

<style scoped>
.course-header {
    background-color: #f0f0f0;
}
/* Custom Toast Styling */
:deep(.p-toast) {
    opacity: 1 !important;
}

:deep(.p-toast .p-toast-message) {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

:deep(.p-toast .p-toast-message.p-toast-message-success) {
    background: #ecfdf5;
    border-left: 6px solid #10b981;
    color: #064e3b;
}

:deep(.p-toast .p-toast-message.p-toast-message-error) {
    background: #fef2f2;
    border-left: 6px solid #ef4444;
    color: #7f1d1d;
}

:deep(.p-toast) .p-toast-message.p-toast-message-info {
    background: #ebf8ff;
    border-left: 6px solid #3b82f6;
    color: #1e40af;
}

:deep(.p-toast .p-toast-message .p-toast-message-content) {
    padding: 1rem;
}

:deep(.p-toast .p-toast-message .p-toast-summary) {
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

:deep(.p-toast .p-toast-message .p-toast-detail) {
    font-size: 0.875rem;
}

:deep(.p-toast .p-toast-icon-close) {
    width: 2rem;
    height: 2rem;
    border-radius: 4px;
    background: transparent;
    color: currentColor;
    transition: background-color 0.2s;
}

:deep(.p-toast .p-toast-icon-close):hover {
    background: rgba(0, 0, 0, 0.05);
}
</style>
