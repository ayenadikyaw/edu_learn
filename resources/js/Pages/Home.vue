<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Carousel from "@/Components/Carousel.vue";
import Indicator from "@/Components/Indicator.vue";
import Courses from "@/Components/Home/Courses.vue";
import AboutOurCourse from "@/Components/Home/AboutOurCourse.vue";
import Mission from "@/Components/Home/Mission.vue";
import ContactUs from "@/Components/Home/ContactUs.vue";
import StudentCmts from "@/Components/Home/StudentCmts.vue";
import { Head } from '@inertiajs/vue3';
import DefaultLayout from "@/Components/Layouts/default.vue";
import AuthenticatedLayout from "@/Components/Layouts/authenticated.vue";

const role = usePage().props?.auth?.user?.role || 'guest';
const layout = computed(() => {
    if (role && role === 'user') {
        return AuthenticatedLayout;
    } else {
        return DefaultLayout;
    }
});
</script>

<template>
    <component :is="layout">
        <Head :title="`Home`" />
        <Carousel />
        <Indicator />
        <AboutOurCourse />
        <Courses />
        <Mission />
        <StudentCmts />
        <ContactUs />
    </component>
</template>
