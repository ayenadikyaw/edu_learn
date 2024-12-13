<script setup>
import { ref, onMounted, watch } from "vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import axios from "axios";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
import { router } from "@inertiajs/vue3";
import { useConfirm } from "primevue/useconfirm";
import ConfirmDialog from "primevue/confirmdialog";
import AdminLayout from "@/Components/Layouts/adminLayout.vue";

// Props
const props = defineProps({
    course: Object,
});

const confirmation = useConfirm();
// Toast for notifications
const toast = useToast();

// Reactive variables
const previewUrl = ref("");
const content = ref(""); // For Quill content
const courseCategories = ref([]);
const courseLevels = ref([]);

// Form data for course
const courseData = useForm({
    title: props.course.title || "",
    description: props.course.description || "",
    category_id: props.course.category_id || "",
    level_id: props.course.level_id || "",
    duration: props.course.duration || 0,
    price: props.course.price || 0,
    image: null, // Image file
    short_description: props.course.short_description || "",
    learning_points: props.course.learning_points || [" "],
    _method: "PUT",
    contentType: "multipart/form-data",
});

// Form data for lesson
const lessonData = useForm({
    title: "",
    content: "",
});

// Set initial preview URL
onMounted(() => {
    previewUrl.value = props.course.profile_image || ""; // Initial image
});

// Watch for course prop updates
watch(
    () => props.course,
    (newCourse) => {
        courseData.title = newCourse.title || "";
        courseData.description = newCourse.description || "";
        courseData.category_id = newCourse.category_id || "";
        courseData.level_id = newCourse.level_id || "";
        courseData.duration = newCourse.duration || 0;
        courseData.price = newCourse.price || 0;
        previewUrl.value = newCourse.profile_image || "";
        courseData.short_description = newCourse.short_description || "";
        courseData.learning_points = newCourse.learning_points || [" "];
    }
);

/**
 * Handle Image Upload
 * @param {Event} event - The event object
 */
const handleImageUpload = (event) => {
    const fileInput = event.target;
    const file = fileInput.files[0]; // Get the selected file

    if (file) {
        const validTypes = ["image/jpeg", "image/png", "image/gif"];
        if (!validTypes.includes(file.type) || file.size > 10 * 1024 * 1024) {
            toast.add({
                severity: "error",
                summary: "Invalid Image",
                detail: "Please select a valid image file (PNG, JPG, GIF) under 10MB.",
                life: 3000,
            });
            fileInput.value = ""; // Reset input
            return;
        }

        // Preview the image
        const reader = new FileReader();
        reader.onload = (e) => {
            previewUrl.value = e.target.result; // Update the preview
        };
        reader.readAsDataURL(file);

        // Bind file to form data
        courseData.image = file;
    }

    // Clear the file input to allow re-selection
    fileInput.value = "";
};
/******* Course Functions End *******/
// Quill editor options
const editorOptions = {
    modules: {
        toolbar: [
            ["bold", "italic", "underline", "strike"],
            ["blockquote", "code-block"],
            [{ header: 1 }, { header: 2 }],
            [{ list: "ordered" }, { list: "bullet" }],
            [{ script: "sub" }, { script: "super" }],
            [{ indent: "-1" }, { indent: "+1" }],
            ["link", "image", "video"],
            ["clean"],
        ],
    },
    placeholder: "Write lesson content here...",
};
// Key for re-rendering Quill Editor
const editorKey = ref(0);

// Fetch course categories and levels
onMounted(async () => {
    try {
        const [categories, levels] = await Promise.all([
            axios.get("/api/course_categories"),
            axios.get("/api/course_levels"),
        ]);
        courseCategories.value = categories.data;
        courseLevels.value = levels.data;
    } catch (error) {
        console.error("API Error:", error);
        toast.add({
            severity: "error",
            summary: "Error",
            detail: "Failed to fetch course data. Please try again.",
            life: 3000,
        });
    }
});

// Update course function
const updateCourse = () => {
    courseData.post('/admin/update-course/'+props.course.id, {
        onFinish: () => {
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Course updated successfully!',
                life: 3000,
            });
        },
        onError: (errors) => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Failed to update course. Please check your inputs.',
                life: 3000,
            });
        },
        onSuccess: () => {
            courseData.reset();
            content.value = '';
            previewUrl.value = null;
        }   
    });
};

/******* Lesson Functions *******/

/**
 * Add Lesson
 * @param {Object} lessonData - The lesson data to be added
 */
const addLesson = () => {
    lessonData.post(route('admin.add-lesson', props.course.id), {
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Lesson added successfully!',
                life: 3000,
            });
            lessonData.reset();
            lessonData.content = '';
            editorKey.value++;
        },
        onError: (errors) => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Failed to add lesson. Please check your inputs.',
                life: 3000,
            });
        }
    });
};

/**
 * Edit Lesson
 * @param {Number} lessonId - The lesson ID to be edited
 */
const editLesson = (lessonId) => {
  router.visit(route('admin.edit-lesson', lessonId));
};

/**
 * Delete Lesson
 * @param {Number} lessonId - The lesson ID to be deleted
 */
const deleteLesson = (lessonId) => {
    confirmation.require({
        group: "headless",
        header: "Are you sure?",
        message: "Please confirm to proceed.",
        accept: () => {
            toast.add({
                severity: "info",
                summary: "Confirmed",
                detail: "You have accepted",
                life: 3000,
            });
            router.delete(route("admin.delete-lesson", { lesson: lessonId }));
        },
        reject: () => {
            toast.add({
                severity: "error",
                summary: "Rejected",
                detail: "You have rejected",
                life: 3000,
            });
        },
    });
};
/**
 * Publish Course
 */
const publishCourse = () => {
    courseData.post(route('admin.publish-course', props.course.id), {
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Course published successfully!',
                life: 3000,
            });
        }
    });
};

/**
 * Add Learning Point
 */
const addLearningPoint = () => {
    courseData.learning_points.push("");
};

/**
 * Remove Learning Point
 * @param {Number} index - The index of the learning point to be removed
 */
const removeLearningPoint = (index) => {
    courseData.learning_points.splice(index, 1);
};  

</script>

<template>
    <AdminLayout>
     <ConfirmDialog group="headless">
        <template #container="{ message, acceptCallback, rejectCallback }">
            <div
                class="flex flex-col items-center p-6 bg-white rounded-lg shadow-lg"
            >
                <div
                    class="rounded-full bg-red-500 text-white inline-flex justify-center items-center h-16 w-16 -mt-14"
                >
                    <i class="pi pi-exclamation-triangle text-3xl"></i>
                </div>
                <span class="font-bold text-xl text-gray-800 block mb-3 mt-4">{{
                    message.header
                }}</span>
                <p class="text-gray-600 mb-4 text-center">
                    {{ message.message }}
                </p>
                <div class="flex items-center gap-3 mt-2">
                    <Button
                        label="Delete"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md"
                        @click="acceptCallback"
                        >Yes</Button
                    >
                    <Button
                        label="Cancel"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md"
                        @click="rejectCallback"
                        >No</Button
                    >
                </div>
            </div>
        </template>
    </ConfirmDialog>
    <!-- <adminLayout> -->
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Edit Course</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column - Basic Info -->
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
                                        :src="previewUrl"
                                        :key="previewUrl"
                                        class="h-48 w-full rounded-lg object-cover"
                                    />
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
                      <!-- Course Short Description -->
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
                    <!-- Learning Points -->
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
                        @click="updateCourse"
                        class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90 flex items-center gap-2"
                    >
                        <i class="pi pi-check"></i>
                        Update Course
                    </button>
                </div>
            </div>

            <!-- Right Column - Add Lessons -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-6">Add Lessons</h2>
                <div class="space-y-4">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Lesson Title</label
                        >
                        <input
                            v-model="lessonData.title"
                            type="text"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20"
                        />
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Lesson Content</label
                        >
                        <QuillEditor
                            v-model:content="lessonData.content"
                            :options="editorOptions"
                            :key="editorKey"
                            theme="snow"
                            contentType="html"
                            class="!h-96 text-sm mb-12 overflow-scroll"
                        />
                    </div>
                    <button 
                        @click="addLesson"
                        class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90 flex items-center gap-2 mt-6 relative z-10"
                    >
                        <i class="pi pi-plus"></i>
                        Add Lesson
                    </button>
                </div>
            </div>
        </div>

        <!-- Lessons List -->
        <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-6">Course Lessons</h2>
            <div class="space-y-4">
                <!-- Sample Lesson Card -->
                <div v-if="props.course.lessons.length > 0" v-for="(lesson, index) in props.course.lessons" class="border rounded-lg p-4">
                    <div  class="flex justify-between items-center">
                        <h3 class="font-medium">Lesson {{index+1}}: {{lesson.title}}</h3>
                        <div class="flex gap-2">
                            <Button @click="editLesson(lesson.id)" class="text-blue-600 hover:text-blue-800">
                                <i class="pi pi-pencil"></i>
                            </Button>
                            <button @click="deleteLesson(lesson.id)" class="text-red-600 hover:text-red-800">
                                <i class="pi pi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button @click="publishCourse"
        class="bg-primary text-white ml-8 px-4 py-2 rounded-md hover:bg-primary/90 flex items-center gap-2"
    >
        <i class="pi pi-check"></i>
        Publish Course
    </button>
    <!-- </adminLayout> -->
    <Toast />
</AdminLayout>
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
