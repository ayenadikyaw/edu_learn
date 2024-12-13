<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";
import moment from "moment";
import "../../echo";

//constants
const isSidebarCollapsed = ref(false);
const isDropdownOpen = ref(false);
const showNotifications = ref(false);
const notifications = ref([]);
const error = ref(null);
const user = ref({});

onMounted(() => {
    user.value = usePage().props.auth.user;
});

/**** Functions ****/
//fetch notifications
const fetchNotifications = async () => {
    try {
        const response = await axios.get(`/api/notifications/${user.value.id}`);
        const newNotifications = response.data.notifications;
        //console.log(newNotifications, "newNotifications");
        //transform into proper message
        const transformedNotifications = newNotifications.map(
            (notification) => {
                return {
                    message: notification.data.message,
                    time: moment(notification.created_at).fromNow()
                };
            }
        );
        notifications.value = [
            ...notifications.value,
            ...transformedNotifications,
        ];
        error.value = null;
   
    } catch (err) {
        error.value =
            err.response?.data?.message || "Failed to fetch notifications";
        console.error("Notification fetch error:", err.response?.data || err);
        notifications.value = [];
    }
};

/**
 * Scroll
 */
const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    //get current user
    user.value = usePage().props.auth.user;
    //console.log(user.value, "user");
    fetchNotifications();
});
/**
 * Handle logout
 * @returns void
 */
const handleLogout = () => {
    router.post(
        "/logout",
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                // Force a hard redirect to home
                window.location.href = "/";
            },
        }
    );
};
const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const toggleNotifications = () => {
    showNotifications.value = !showNotifications.value;
};

// Update the Echo usage to use window.Echo
Echo.channel("course-enrolled").listen(".course.enrolled", (e) => {
    //console.log(e.message, "e");
    notifications.value.unshift(e.message);
});
</script>

<template>
    <Head :title="`Admin Dashboard`" />
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div
            class="bg-primary shadow-lg transition-all duration-300"
            :class="[isSidebarCollapsed ? 'w-20' : 'w-64']"
        >
            <div
                class="flex items-center justify-between px-4 py-3 border-b border-primary/20"
            >
                <Link
                    href="/admin"
                    class="flex items-center space-x-3 text-white overflow-hidden"
                >
                    <i class="pi pi-desktop text-xl"></i>
                    <span
                        class="whitespace-nowrap transition-opacity duration-300"
                        :class="{ 'opacity-0': isSidebarCollapsed }"
                        >Admin Dashboard</span
                    >
                </Link>
                <button
                    class="text-white hover:text-gray-200 transition-colors duration-200 focus:outline-none"
                    @click="isSidebarCollapsed = !isSidebarCollapsed"
                >
                    <i
                        class="pi text-xl transition-transform duration-300"
                        :class="[
                            isSidebarCollapsed
                                ? 'pi-angle-right'
                                : 'pi-angle-left',
                        ]"
                    ></i>
                </button>
            </div>
            <nav class="mt-6">
                <div class="px-4 py-3 hover:bg-primary/10 cursor-pointer">
                    <Link
                        href="/admin/manage-courses"
                        class="flex items-center space-x-3 text-white"
                    >
                        <i class="pi pi-book"></i>
                        <span
                            class="whitespace-nowrap transition-opacity duration-300"
                            :class="{ 'opacity-0': isSidebarCollapsed }"
                            >Manage Courses</span
                        >
                    </Link>
                </div>
                <div class="px-4 py-3 hover:bg-primary/10 cursor-pointer">
                    <div class="flex items-center space-x-3 text-white">
                        <i class="pi pi-users"></i>
                        <span
                            class="whitespace-nowrap transition-opacity duration-300"
                            :class="{ 'opacity-0': isSidebarCollapsed }"
                            >Students</span
                        >
                    </div>
                </div>
                <div class="px-4 py-3 hover:bg-primary/10 cursor-pointer">
                    <div class="flex items-center space-x-3 text-white">
                        <i class="pi pi-cog"></i>
                        <span
                            class="whitespace-nowrap transition-opacity duration-300"
                            :class="{ 'opacity-0': isSidebarCollapsed }"
                            >Settings</span
                        >
                    </div>
                </div>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Admin Header -->
            <div class="bg-white shadow-sm">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center">
                            <h1 class="text-xl font-semibold text-gray-800">
                                Dashboard
                            </h1>
                        </div>

                        <div class="flex items-center space-x-4">
                            <!-- Notification Bell -->
                            <div class="relative">
                                <button
                                    class="p-2 text-gray-600 hover:text-gray-900 focus:outline-none"
                                >
                                    <i
                                        @click="toggleNotifications"
                                        class="pi pi-bell text-xl text-gray-600 hover:text-primary cursor-pointer transition-colors duration-200"
                                    ></i>
                                    <span
                                        class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"
                                    ></span>
                                </button>
                            </div>
                            <!-- Notifications Dropdown -->
                            <div
                                v-if="showNotifications"
                                class="absolute top-10 z-50 right-64 mt-2 w-80 bg-white rounded-md shadow-lg py-1 border border-gray-200"
                            >
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <h3 class="font-semibold text-gray-800">
                                        Notifications
                                    </h3>
                                </div>

                                <div class="max-h-96 overflow-y-auto">
                                    <div
                                        v-if="error"
                                        class="px-4 py-3 text-red-600 text-sm"
                                    >
                                        {{ error }}
                                    </div>
                                    <div
                                        v-else-if="notifications.length > 0"
                                        v-for="notification in notifications"
                                        :key="notification.id"
                                        class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100 cursor-pointer"
                                    >
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-2 h-2 mt-2 bg-blue-500 rounded-full"
                                            ></div>
                                            <div>
                                                <p
                                                    class="text-sm text-gray-800"
                                                >
                                                    {{ notification.message }}
                                                </p>
                                                <span
                                                    class="text-xs text-gray-500"
                                                >
                                                    {{ notification.time }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        v-else
                                        class="px-4 py-3 text-gray-500 text-sm"
                                    >
                                        No notifications
                                    </div>
                                </div>

                                <div class="px-4 py-2 border-t border-gray-200">
                                    <button
                                        class="text-sm text-primary hover:text-primary_light"
                                    >
                                        Mark all as read
                                    </button>
                                </div>
                            </div>

                            <!-- Profile Dropdown -->
                            <div class="relative">
                                <button
                                    @click="isDropdownOpen = !isDropdownOpen"
                                    class="flex items-center space-x-3 focus:outline-none"
                                >
                                    <img
                                        :src="`https://ui-avatars.com/api/?name=${
                                            user.name ? user.name : 'Guest'
                                        }`"
                                        alt="Profile Picture"
                                        class="w-10 h-10 rounded-full border-2 border-primary hover:border-primary_light transition-colors duration-200"
                                    />
                                    <span class="text-gray-700"
                                        >Admin User</span
                                    >
                                    <i
                                        class="pi pi-chevron-down text-gray-500"
                                        :class="{
                                            'transform rotate-180':
                                                isDropdownOpen,
                                        }"
                                    ></i>
                                </button>

                                <!-- Dropdown Menu -->
                                <div
                                    v-if="isDropdownOpen"
                                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                                >
                                    <div class="py-1">
                                        <a
                                            href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >
                                            Profile
                                        </a>
                                        <Link
                                            @click.prevent="handleLogout"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >
                                            Logout
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--slot for the main content-->
            <div class="p-8">
                <slot />
            </div>
        </div>
    </div>
</template>
