<script setup>
import { ref, onMounted } from "vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import axios from "axios";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
import AdminLayout from "@/Components/Layouts/adminLayout.vue";
//variables
const previewUrl = ref("");
const content = ref("");
const courseCategories = ref([]);
const courseLevels = ref([]);
const isDone = ref(false);
const toast = useToast();

//model data for course
const courseData = useForm({
    title: "",
    description: "",
    category_id: "",
    level_id: "",
    duration: "",
    price: "",
    image: null,
    short_description: "",
    learning_points: [" "],
});

//props after course is created
const props = defineProps({
    course: Object,
});

/**
 * handle image upload
 * @param event
 */
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        previewUrl.value = URL.createObjectURL(file);
        courseData.image = file;
    }
};

//fetch course categories and levels
onMounted(async () => {
    try {
        const response = await axios.get("/api/course_categories");
        courseCategories.value = response.data;

        const responseLevels = await axios.get("/api/course_levels");
        courseLevels.value = responseLevels.data;

        //console.log(courseCategories.value);
        //console.log(courseLevels.value);
    } catch (error) {
        console.error(
            "API Error:",
            error.response?.status,
            error.response?.data
        );
        console.error("Full error:", error);
    }
});

/**
 * create course
 * @
 */
const createCourse = () => {
    courseData.post("/admin/add-course", {
        onSuccess: () => {
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "Course created successfully! You can now add lessons to this course.",
                life: 3000,
                styleClass: "custom-toast",
                contentStyleClass: "custom-toast-content",
            });
            // Disable the button while creating lessons
            isDone.value = true;
            courseData.reset();
            content.value = "";
            previewUrl.value = null;
        },
        onError: (errors) => {
            toast.add({
                severity: "error",
                summary: "Error",
                detail: "Failed to create course. Please check your inputs.",
                life: 3000,
                styleClass: "custom-toast",
                contentStyleClass: "custom-toast-content",
            });
        },
    });
};

//add learning point
const addLearningPoint = () => {
    courseData.learning_points.push("");
};

//remove learning point
const removeLearningPoint = (index) => {
    courseData.learning_points.splice(index, 1);
};
</script>
<template>
    <AdminLayout>
        <div class="p-4">
            <h1 class="text-2xl font-bold text-gray-800 mb-8">
                Add New Course
            </h1>
            <!--  Basic Info -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-6">Basic Information</h2>
                <div class="space-y-4">
                    <!-- Course Image -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Course Image</label
                        >
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary transition-colors"
                        >
                            <div class="space-y-2 text-center">
                                <div
                                    class="mx-auto h-48 w-full text-gray-400 flex items-center justify-center"
                                >
                                    <img
                                        v-if="previewUrl"
                                        :src="previewUrl"
                                        class="h-48 w-full rounded-lg object-cover"
                                    />
                                    <i v-else class="pi pi-image text-5xl"></i>
                                </div>
                                <div
                                    class="flex items-center justify-center text-sm text-gray-600"
                                >
                                    <label
                                        for="course-image"
                                        class="relative cursor-pointer rounded-md font-medium text-primary hover:text-primary/90"
                                    >
                                        <span>Upload a file</span>
                                        <input
                                            id="course-image"
                                            name="course-image"
                                            type="file"
                                            class="sr-only"
                                            @change="handleImageUpload"
                                            accept="image/*"
                                        />
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF up to 10MB
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Course Title -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Course Title</label
                        >
                        <input
                            v-model="courseData.title"
                            type="text"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20"
                        />
                    </div>
                    <!-- Short Description -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Short Description</label
                        >
                        <input
                            v-model="courseData.short_description"
                            type="text"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20"
                        />
                    </div>
                    <!-- Course Description -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Description</label
                        >
                        <textarea
                            v-model="courseData.description"
                            rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20"
                        ></textarea>
                    </div>
                    <!-- Course Category and Level -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Category</label
                            >
                            <select
                                v-model="courseData.category_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20"
                            >
                                <option
                                    v-for="category in courseCategories"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Level</label
                            >
                            <select
                                v-model="courseData.level_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20"
                            >
                                <option
                                    v-for="level in courseLevels"
                                    :value="level.id"
                                >
                                    {{ level.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <!-- Course Duration and Price -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Duration (in hours)</label
                            >
                            <input
                                v-model="courseData.duration"
                                type="number"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Price ($)</label
                            >
                            <input
                                v-model="courseData.price"
                                type="number"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20"
                            />
                        </div>
                    </div>
                    <!-- What You Will Learn Section -->
                    <div class="mb-4">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >What You Will Learn</label
                        >
                        <div
                            v-for="(item, index) in courseData.learning_points"
                            :key="'learn-' + index"
                            class="flex gap-2 mb-2"
                        >
                            <input
                                v-model="courseData.learning_points[index]"
                                type="text"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20"
                                placeholder="Enter a learning point..."
                            />
                            <button
                                @click="removeLearningPoint(index)"
                                class="px-2 py-1 text-red-600 hover:text-red-800"
                                v-if="courseData.learning_points.length > 1"
                            >
                                <i class="pi pi-times"></i>
                            </button>
                        </div>
                        <button
                            @click="addLearningPoint"
                            class="text-primary hover:text-primary/80 flex items-center gap-1"
                        >
                            <i class="pi pi-plus"></i>
                            Add Learning Point
                        </button>
                    </div>

                    <button
                        @click="createCourse"
                        :disabled="isDone"
                        class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90 flex items-center gap-2"
                        :class="{ 'opacity-50 cursor-not-allowed': isDone }"
                    >
                        <i class="pi pi-check"></i>
                        Create
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
    <Toast position="top-right" />
</template>

<style>
.ql-editor {
    min-height: 600px;
}

.ql-container {
    font-size: 16px;
}

/* Custom Toast Styling */
.p-toast {
    opacity: 1 !important;
}

.p-toast .p-toast-message {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.p-toast .p-toast-message.p-toast-message-success {
    background: #ecfdf5;
    border-left: 6px solid #10b981;
    color: #064e3b;
}

.p-toast .p-toast-message.p-toast-message-error {
    background: #fef2f2;
    border-left: 6px solid #ef4444;
    color: #7f1d1d;
}

.p-toast .p-toast-message .p-toast-message-content {
    padding: 1rem;
}

.p-toast .p-toast-message .p-toast-summary {
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.p-toast .p-toast-message .p-toast-detail {
    font-size: 0.875rem;
}

.p-toast .p-toast-icon-close {
    width: 2rem;
    height: 2rem;
    border-radius: 4px;
    background: transparent;
    color: currentColor;
    transition: background-color 0.2s;
}

.p-toast .p-toast-icon-close:hover {
    background: rgba(0, 0, 0, 0.05);
}
</style>
