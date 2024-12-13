<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import DefaultLayout from "@/Components/Layouts/default.vue";
import AuthenticatedLayout from "@/Components/Layouts/authenticated.vue";
import { usePage } from '@inertiajs/vue3';


const text = 'Empowering learners worldwide with accessible, high-quality education through our innovative online learning platform.';
const displayText = ref('');

const role = usePage().props?.auth?.user?.role || 'guest';
const layout = computed(() => {
    if (role && role === 'user') {
        return AuthenticatedLayout;
    } else {
        return DefaultLayout;
    }
});
onMounted(() => {
    let index = 0;
    const interval = setInterval(() => {
        if (index < text.length) {
            displayText.value += text[index];
            index++;
        } else {
            clearInterval(interval);
        }
    }, 50); 
});
</script>

<template>
    <component :is="layout">
        <Head :title="`About Us`" />
        <header class="relative">
            <div class="bg-gradient-to-b from-primary/5 to-transparent">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <h1 class="text-3xl font-bold text-primary mb-6 text-center">
                    About EduLearn
                </h1>
                <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto typing-text">
                    {{ displayText }}
                </p>
            </div>
        </div>
    </header>

    <main>
        <!-- Mission Section -->
        <section class="py-20 px-4 bg-gradient-to-b from-white to-primary/5 overflow-hidden">
            <div class="relative">
                    <div class="absolute inset-0 bg-primary/5 transform skew-y-6"></div>
                    <div class="relative bg-white p-8 rounded-2xl shadow-lg">
                        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div>
                                <h3 class="text-2xl font-bold text-primary mb-4">Our Commitment</h3>
                                <p class="text-gray-600 mb-4">
                                    At EduLearn, we're dedicated to transforming education through technology and innovation. Our platform combines theoretical knowledge with practical skills, preparing students for real-world success.
                                </p>
                                <button class="bg-primary hover:bg-primary_light text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 hover:shadow-lg">
                                    Learn More
                                </button>
                            </div>
                            <div class="relative">
                                <img
                                    src="../../../public/storage/assets/images/mission.jpg"
                                    alt="Our Mission"
                                    class="rounded-xl shadow-lg w-full h-[300px] object-cover"
                                />
                                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-secondary/20 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
                <div class="text-center mb-16 relative">
                    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-primary/10 rounded-full blur-xl"></div>
                    <h2 class="text-4xl font-bold text-primary mb-4 relative">Our Mission & Vision</h2>
                    <div class="w-24 h-1 bg-primary mx-auto rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="group">
                        <div class="relative p-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
                                    <i class="pi pi-users text-2xl text-primary"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-4">Accessible Education</h3>
                                <p class="text-gray-600">Breaking down barriers to ensure quality education reaches everyone, everywhere.</p>
                            </div>
                        </div>
                    </div>

                    <div class="group lg:-mt-8">
                        <div class="relative p-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
                                    <i class="pi pi-star text-2xl text-primary"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-4">Quality Content</h3>
                                <p class="text-gray-600">Partnering with industry experts to deliver comprehensive, practical learning experiences.</p>
                            </div>
                        </div>
                    </div>

                    <div class="group">
                        <div class="relative p-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
                                    <i class="pi pi-chart-line text-2xl text-primary"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-4">Student Success</h3>
                                <p class="text-gray-600">Empowering learners to achieve their goals through innovative learning methods.</p>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary mb-2">
                            50K+
                        </div>
                        <div class="text-gray-600">Active Students</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary mb-2">
                            200+
                        </div>
                        <div class="text-gray-600">Expert Instructors</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary mb-2">
                            100+
                        </div>
                        <div class="text-gray-600">Courses Available</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary mb-2">
                            95%
                        </div>
                        <div class="text-gray-600">Success Rate</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-primary mb-12 text-center">
                    Meet Our Team
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gray-50 rounded-xl p-6 text-center hover:scale-105 transition-all duration-300">
                        <img
                            src="/images/team-1.jpg"
                            alt="Team Member"
                            class="w-32 h-32 rounded-full mx-auto mb-4 object-cover"
                        />
                        <h3 class="text-xl font-semibold mb-2">
                            Sarah Johnson
                        </h3>
                        <p class="text-primary mb-2">CEO & Founder</p>
                        <p class="text-gray-600 text-sm">
                            Education enthusiast with 15+ years of experience in
                            EdTech
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6 text-center hover:scale-105 transition-all duration-300">
                        <img
                            src="/images/team-2.jpg"
                            alt="Team Member"
                            class="w-32 h-32 rounded-full mx-auto mb-4 object-cover"
                        />
                        <h3 class="text-xl font-semibold mb-2">Michael Chen</h3>
                        <p class="text-primary mb-2">Head of Education</p>
                        <p class="text-gray-600 text-sm">
                            Former professor with passion for online learning
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6 text-center hover:scale-105 transition-all duration-300">
                        <img
                            src="/images/team-3.jpg"
                            alt="Team Member"
                            class="w-32 h-32 rounded-full mx-auto mb-4 object-cover"
                        />
                        <h3 class="text-xl font-semibold mb-2">
                            Emily Martinez
                        </h3>
                        <p class="text-primary mb-2">Lead Developer</p>
                        <p class="text-gray-600 text-sm">
                            Tech expert creating seamless learning experiences
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-primary/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-primary mb-6">
                    Ready to Start Learning?
                </h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                    Join thousands of learners who are already advancing their
                    careers with LearnHub
                </p>
                <button
                    class="bg-primary hover:bg-primary_light text-white px-8 py-3 rounded-lg text-lg font-semibold transition-colors duration-200 shadow-lg hover:shadow-xl"
                >
                    Browse Courses
                </button>
            </div>
        </section>
    </main>
    </component>
</template>

<style scoped>
.typing-text {
    border-right: 2px solid #000;
    white-space: pre-wrap;
    overflow: hidden;
    animation: cursor-blink 0.7s infinite;
}

@keyframes cursor-blink {
    50% {
        border-right-color: transparent;
    }
}
</style>
