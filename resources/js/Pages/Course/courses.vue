<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import DefaultLayout from "@/Components/Layouts/default.vue";
import AuthenticatedLayout from "@/Components/Layouts/authenticated.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, onMounted } from "vue";
import axios from "axios";

//set layout
const role = usePage().props?.auth?.user?.role || "guest";
const layout = computed(() => {
    if (role && role === "user") {
        return AuthenticatedLayout;
    } else {
        return DefaultLayout;
    }
});

//props
const props = defineProps({
    courses: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
});

console.log(props.courses);

// State for filters
const search = ref(props.filters?.search || "");
const selectedCategories = ref(props.filters?.category || []);
const selectedLevels = ref(props.filters?.level || []);
const selectedDurations = ref(props.filters?.duration || []);

// Fetch categories and levels
const categories = ref([]);
const levels = ref([]);

onMounted(async () => {
    try {
        const { data } = await axios.get("/api/course_categories");
        categories.value = data;
        const { data: levelsData } = await axios.get("/api/course_levels");
        levels.value = levelsData;
    } catch (error) {
        console.error("Failed to fetch categories or levels", error);
    }
});

// Utility function to sync all filters to the query
const updateFilters = () => {
    router.get(
        route("courses.index"),
        {
            search: search.value,
            category: selectedCategories.value,
            level: selectedLevels.value,
            duration: selectedDurations.value,
        },
        { preserveState: true, preserveScroll: true }
    );
};

// Watchers to update filters dynamically
watch(search, updateFilters);
watch(selectedCategories, updateFilters);
watch(selectedLevels, updateFilters);
watch(selectedDurations, updateFilters);

// Debugging: Log filter changes
watch(
    [search, selectedCategories, selectedLevels, selectedDurations],
    ([newSearch, newCategories, newLevels, newDurations]) => {
        console.log("Search:", newSearch);
        console.log("Categories:", newCategories);
        console.log("Levels:", newLevels);
        console.log("Duration:", newDurations);
    }
);
</script>
<template>
    <component :is="layout">
        <Head title="Courses" />
        <h1>Courses</h1>
        <div class="min-h-screen bg-gray-50 py-8 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Filter Section - Left Sidebar -->
                    <div
                        class="w-full md:w-1/4 bg-white p-6 rounded-lg shadow-sm h-fit"
                    >
                        <h2 class="text-xl font-bold text-gray-800 mb-4">
                            Filters
                        </h2>

                        <!-- Price Range -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-700 mb-2">
                                Course Category
                            </h3>
                            <div class="space-y-2">
                                <label
                                    v-for="category in categories"
                                    class="flex items-center"
                                >
                                    <input
                                        v-model="selectedCategories"
                                        :value="category.id"
                                        :key="category.id"
                                        type="checkbox"
                                        class="form-checkbox text-primary rounded"
                                    />
                                    <span class="ml-2 text-gray-600">{{
                                        category.name
                                    }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Course Level -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-700 mb-2">
                                Level
                            </h3>
                            <div class="space-y-2">
                                <label
                                    v-for="level in levels"
                                    class="flex items-center"
                                >
                                    <input
                                        v-model="selectedLevels"
                                        :value="level.id"
                                        :key="level.id"
                                        type="checkbox"
                                        class="form-checkbox text-primary rounded"
                                    />
                                    <span class="ml-2 text-gray-600">{{
                                        level.name
                                    }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-700 mb-2">
                                Duration
                            </h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input
                                        v-model="selectedDurations"
                                        :value="1"
                                        type="checkbox"
                                        class="form-checkbox text-primary rounded"
                                    />
                                    <span class="ml-2 text-gray-600"
                                        >0-2 Hours</span
                                    >
                                </label>
                                <label class="flex items-center">
                                    <input
                                        v-model="selectedDurations"
                                        :value="2"
                                        type="checkbox"
                                        class="form-checkbox text-primary rounded"
                                    />
                                    <span class="ml-2 text-gray-600"
                                        >3-6 Hours</span
                                    >
                                </label>
                                <label class="flex items-center">
                                    <input
                                        v-model="selectedDurations"
                                        :value="3"
                                        type="checkbox"
                                        class="form-checkbox text-primary rounded"
                                    />
                                    <span class="ml-2 text-gray-600"
                                        >7+ Hours</span
                                    >
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Courses Section - Right Side -->
                    <div class="w-full md:w-3/4">
                        <!-- Search Bar -->
                        <div class="mb-6">
                            <div class="relative">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Search courses..."
                                    class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                />
                                <div class="absolute right-3 top-2.5">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Course Grid -->
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                        >
                        
                            <Link
                                :href="`/courses/${course.id}`"
                                v-for="course in courses.data"
                                :key="course.id"
                                class="group bg-white rounded-xl shadow-sm hover:shadow-xl overflow-hidden transition-all duration-300 border border-gray-100"
                            >
                                <!-- Course Image with Overlay -->
                                <div class="relative overflow-hidden">
                                    <img
                                        :src="course.profile_image ? course.profile_image : '/assets/images/defaultCourse1.jpg'"
                                        :alt="course.title"
                                        class="w-full h-52 object-cover transform group-hover:scale-105 transition-transform duration-300"
                                    />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <!-- Badge -->
                                    <div
                                        v-if="course.badge"
                                        class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-semibold text-white backdrop-blur-sm shadow-lg"
                                        :class="`${
                                            course.badge == 'new'
                                                ? 'from-primary to-primary_light'
                                                : 'from-secondary to-secondary_light'
                                        }`"
                                    >
                                        {{ course.badge }}
                                    </div>
                                    
                                    <!-- Quick Stats Overlay -->
                                    <div class="absolute bottom-4 left-4 right-4 flex justify-between items-center text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            {{ course.lessons.length }} lessons
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ course.duration }} Hours
                                        </span>
                                    </div>
                                </div>

                                <!-- Course Content -->
                                <div class="p-6">
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="px-2 py-1 bg-primary/10 rounded-full text-xs font-medium text-primary">
                                            {{ categories.find((category) => category.id === course.category_id)?.name }}
                                        </span>
                                        <span class="px-2 py-1 bg-secondary/10 rounded-full text-xs font-medium text-secondary">
                                            {{ levels.find((level) => level.id === course.level_id)?.name }}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-primary transition-colors duration-300">
                                        {{ course.title }}
                                    </h3>
                                    
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ course.short_description }}
                                    </p>

                                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                        <span class="text-xl font-bold text-primary">${{ course.price }}</span>
                                        <span class="text-sm text-gray-500 group-hover:text-primary transition-colors duration-300 animate-bounce">
                                            View Course →
                                        </span>
                                    </div>
                                </div>
                            </Link>
                        </div>
                        <div class="mt-8">
                            <Component
                                v-if="courses.links"
                                :is="Link"
                                v-for="link in courses.links"
                                :key="link.url"
                                :href="link.url"
                                v-html="link.label"
                                class="px-4 py-2 mx-1 border rounded-lg hover:bg-primary hover:text-white transition-colors duration-200"
                                :class="{
                                    'text-gray-500 border-gray-300': !link.url,
                                    'bg-primary text-white border-primary':
                                        link.active,
                                    'text-primary border-primary':
                                        !link.active && link.url,
                                }"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </component>
</template>
