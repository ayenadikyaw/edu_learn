<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import "../../echo";
import axios from "axios";
import moment from "moment";

const isScrolled = ref(false);
const isDropdownOpen = ref(false);
const showNotifications = ref(false);
const notifications = ref([]);
const error = ref(null);

//fetch notifications
const fetchNotifications = async () => {
    try {
        const response = await axios.get(`/api/notifications/${user.value.id}`);
        const newNotifications = response.data.notifications;
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
const user = ref({});
onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    //get current user
    user.value = usePage().props.auth.user;
    //console.log(user.value, "user");
    fetchNotifications();
    console.log(notifications.value, "notifications");
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

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

const toggleNotifications = () => {
    showNotifications.value = !showNotifications.value;
};

// Update the Echo usage to use window.Echo
Echo.channel("courses").listen(".course.create", (e) => {
    console.log(e.message, "e");
    notifications.value.unshift(e.message);
});
</script>

<template>
    <div
        :class="[
            'transition-all duration-300 ease-in-out fixed top-0 left-0 w-full z-50',
            isScrolled ? 'bg-white shadow-md' : 'bg-white',
        ]"
    >
        <div class="p-2 flex items-center justify-between">
            <!-- Logo -->
            <ApplicationLogo class="ml-4 w-24" @click="router.visit('/')" />

            <!-- Navigation Menu -->
            <div
                class="flex items-center gap-4 text-md font-semibold text-primary"
            >
                <Link
                    href="/"
                    class="menu-item hover:text-primary_light transition-colors duration-200"
                    >Home</Link
                >
                <Link
                    href="/about-us"
                    class="menu-item hover:text-primary_light transition-colors duration-200"
                    >About Us</Link
                >
                <Link
                    href="/courses"
                    class="menu-item hover:text-primary_light transition-colors duration-200"
                    >Courses</Link
                >
                <Link
                    href="/contact-us"
                    class="menu-item hover:text-primary_light transition-colors duration-200"
                    >Contact Us</Link
                >
            </div>

            <!-- User Profile Section -->
            <div class="flex items-center gap-6">
                <!-- Notification Icon -->
                <div class="relative">
                    <i
                        @click="toggleNotifications"
                        class="pi pi-bell text-xl text-gray-600 hover:text-primary cursor-pointer transition-colors duration-200"
                    ></i>
                    <div
                        class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"
                    ></div>

                    <!-- Notifications Dropdown -->
                    <div
                        v-if="showNotifications"
                        class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 border border-gray-200"
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
                                        <p class="text-sm text-gray-800">
                                            {{ notification.message }}
                                        </p>
                                        <span class="text-xs text-gray-500">
                                            {{ notification.time }}
                                        </span>
                                        
                                    </div>
                                </div>
                            </div>
                            <div v-else class="px-4 py-3 text-gray-500 text-sm">
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
                </div>

                <!-- User Profile -->
                <div class="relative">
                    <div
                        @click="toggleDropdown"
                        class="flex items-center gap-3 cursor-pointer"
                    >
                        <div class="flex flex-col justify-center items-center">
                            <p class="text-sm font-semibold text-gray-800">
                                {{ user.name ? user.name : "Guest" }}
                            </p>
                            <p class="text-xs text-gray-500">Student</p>
                        </div>
                        <img
                            :src="`https://ui-avatars.com/api/?name=${
                                user.name ? user.name : 'Guest'
                            }`"
                            alt="Profile Picture"
                            class="w-10 h-10 rounded-full border-2 border-primary hover:border-primary_light transition-colors duration-200"
                        />
                    </div>

                    <!-- Dropdown Menu -->
                    <div
                        v-if="isDropdownOpen"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1"
                    >
                        <Link
                            href="/user"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            My Dashboard
                        </Link>
                        <Link
                            @click.prevent="handleLogout"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Logout
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.menu-item {
    position: relative;
    overflow: hidden;
}

.menu-item::v-deep::after {
    content: "";
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 0;
    background-color: #7ed957;
    transition: width 0.3s ease;
}

.menu-item:hover::v-deep::after {
    width: 100%;
}
</style>
