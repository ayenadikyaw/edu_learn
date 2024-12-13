<script setup lang="ts">
import { ref, onMounted, watch } from "vue";
import AdminLayout from "@/Components/Layouts/adminLayout.vue";
import Chart from "primevue/chart";
import axios from "axios";

const totalStudents = ref(0);
const totalEnrollments = ref(0);
const totalCourses = ref(0);
const totalAdmins = ref(0);
const totalStudentsByMonth = ref([]);
const totalEnrollmentsByMonth = ref([]);
const totalCoursesByCategory = ref([]);
const studentGrowthData = ref([]);
const enrollmentsGrowthData = ref([]);
//fetch dashboard data
onMounted(async () => {
    const totalStudentsResponse = await axios.get(
        route("admin.dashboard.total-students")
    );
    totalStudents.value = totalStudentsResponse.data.totalStudents;

    const totalEnrollmentsResponse = await axios.get(
        route("admin.dashboard.total-enrollments")
    );
    totalEnrollments.value = totalEnrollmentsResponse.data.totalEnrollments;

    const totalCoursesResponse = await axios.get(
        route("admin.dashboard.total-courses")
    );
    totalCourses.value = totalCoursesResponse.data.totalCourses;

    const totalAdminsResponse = await axios.get(
        route("admin.dashboard.total-admins")
    );
    totalAdmins.value = totalAdminsResponse.data.totalAdmins;

    const totalStudentsByMonthResponse = await axios.get(
        route("admin.dashboard.total-students-by-month")
    );
    totalStudentsByMonth.value =
        totalStudentsByMonthResponse.data.totalStudentsByMonth;
    //transform the data
    studentGrowthData.value = new Array(12).fill(0);
    totalStudentsByMonth.value.forEach((item) => {
        studentGrowthData.value[item.month - 1] = item.count;
    });

    const totalEnrollmentsByMonthResponse = await axios.get(
        route("admin.dashboard.total-enrollments-by-month")
    );
    totalEnrollmentsByMonth.value =
        totalEnrollmentsByMonthResponse.data.totalEnrollmentsByMonth;
    //transform the data
    enrollmentsGrowthData.value = new Array(12).fill(0);
    totalEnrollmentsByMonth.value.forEach((item) => {
        enrollmentsGrowthData.value[item.month - 1] = item.count;
    });

    try {
        const totalCoursesByCategoryResponse = await axios.get(
            route("admin.dashboard.total-courses-by-category")
        );
        totalCoursesByCategory.value =
            totalCoursesByCategoryResponse.data.totalCoursesByCategory;
    } catch (error) {
        console.error("Error fetching total courses by category:", error);
    }
});

watch(totalCoursesByCategory, () => {
    piechartData.value.labels = totalCoursesByCategory.value.map(
        (item) => item.category
    );
    piechartData.value.datasets[0].data = totalCoursesByCategory.value.map(
        (item) => item.count
    );
});

//Student Growth Chart
const chartData = ref({
    labels: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ],
    datasets: [
        {
            label: "My First dataset",
            data: studentGrowthData,
            backgroundColor: "#1a69cc",
        },
    ],
});

//Options for Student Growth Chart
const barchartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
});

//Course Distribution Chart
const piechartData = ref({
    labels: [],
    datasets: [
        {
            data: [],
            backgroundColor: [
                "#1a69cc",
                "#7ed957",
                "#ff9900",
                "#e0e0e0",
                "#a3f09d",
                "#0a316a",
                "#1a69cc",
            ],
        },
    ],
});

// Options for Course Distribution Chart
const options = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: "right",
            labels: {
                boxWidth: 10,
                padding: 15,
                font: {
                    size: 12,
                },
            },
        },
        tooltip: {
            enabled: true,
        },
    },
});

//Monthly Enrollments Chart
const linechartData = ref({
    labels: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ],
    datasets: [
        {
            label: "My First dataset",
            data: enrollmentsGrowthData,
            backgroundColor: "#1a69cc",
        },
    ],
});

// options for Monthly Enrollments Chart
const linechartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false,
        },
    },
});
</script>
<template>
    <AdminLayout>
        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Total Students</p>
                        <h3 class="text-2xl font-bold">{{ totalStudents }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center"
                    >
                        <i class="pi pi-users text-xl text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Active Courses</p>
                        <h3 class="text-2xl font-bold">{{ totalCourses }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center"
                    >
                        <i class="pi pi-book text-xl text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Total Enrollments</p>
                        <h3 class="text-2xl font-bold">
                            {{ totalEnrollments }}
                        </h3>
                    </div>
                    <div
                        class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center"
                    >
                        <i class="pi pi-chart-line text-xl text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Total Admins</p>
                        <h3 class="text-2xl font-bold">{{ totalAdmins }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center"
                    >
                        <i class="pi pi-user-plus text-xl text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-semibold mb-4">Student Growth</h4>
                <div class="h-64">
                    <Chart
                        type="bar"
                        :data="chartData"
                        :options="barchartOptions"
                        class="w-full h-full"
                    />
                </div>
            </div>
            <div
                class="bg-white rounded-lg shadow p-6 flex flex-col justify-center items-center"
            >
                <h4 class="text-lg font-semibold mb-4">Course Distribution</h4>
                <div class="h-64 p-4">
                    <Chart
                        type="pie"
                        :data="piechartData"
                        :options="options"
                        class="w-full h-full"
                    />
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h4 class="text-lg font-semibold mb-4">Monthly Enrollments</h4>
            <div class="h-64">
                <Chart
                    type="line"
                    :data="linechartData"
                    :options="linechartOptions"
                    class="w-full h-full"
                />
            </div>
        </div>

        <!-- History Table -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h4 class="text-lg font-semibold mb-4">Recent Activities</h4>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px]">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="pb-3">Date</th>
                                <th class="pb-3">Student</th>
                                <th class="pb-3">Course</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="py-3">2024-02-10</td>
                                <td>John Doe</td>
                                <td>Web Development</td>
                                <td>$299</td>
                                <td>
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-800 rounded"
                                        >Completed</span
                                    >
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-3">2024-02-09</td>
                                <td>Jane Smith</td>
                                <td>UI/UX Design</td>
                                <td>$199</td>
                                <td>
                                    <span
                                        class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded"
                                        >Pending</span
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
