<script setup>
import { Head } from "@inertiajs/vue3";
import DefaultLayout from "@/Components/Layouts/default.vue";
import AuthenticatedLayout from "@/Components/Layouts/authenticated.vue";
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
const role = usePage().props?.auth?.user?.role || 'guest';
const layout = computed(() => {
    if (role && role === 'user') {
        return AuthenticatedLayout;
    } else {
        return DefaultLayout;
    }
});

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    message: ''
});

const submitForm = () => {
    form.post('/contact-us');
};
</script>

<template>
    <component :is="layout">
        <Head :title="`Contact Us`" />
        <div
            class="container mx-auto px-4 py-24 bg-gradient-to-b from-primary/5 to-transparent"
        >
            <div class="max-w-3xl mx-auto text-center space-y-6">
            <h2 class="text-2xl font-bold text-primary">
                Get in Touch with Us
            </h2>
            <p class="text-gray-600">
                Have questions about our courses or need assistance? We're here
                to help! Fill out the form below and our team will get back to
                you as soon as possible.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div
                    class="p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
                >
                    <div
                        class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4"
                    >
                        <i class="pi pi-envelope text-xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        Email Us
                    </h3>
                    <p class="text-gray-600 text-sm">support@edulearn.com</p>
                </div>
                <div
                    class="p-4 bg-white rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-300"
                >
                    <div class="w-12 h-12 bg-secondary/60 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="pi pi-phone text-xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        Phone
                    </h3>
                    <p class="text-gray-600 text-sm">+95-9-977777777</p>
                </div>
                <div
                    class="p-4 bg-white rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-300"
                >
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="pi pi-map-marker text-xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        Location
                    </h3>
                    <p class="text-gray-600 text-sm">
                        Yangon, Myanmar
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--Map-->
    <div class="container mx-auto mt-12 mb-20">
        <div class="w-full h-96 bg-gray-100 rounded-lg">
            <iframe
                src="https://www.google.com/maps/embed?pb=..."
                width="100%"
                height="100%"
                style="border: 0"
                allowfullscreen=""
                loading="lazy"
            ></iframe>
        </div>
    </div>
    <!-- Contact Form -->
    <div class="container mx-auto mt-12 mb-20">
        <div class="flex flex-col items-center space-y-12 animate-fade-in">
            <h1 class="text-4xl text-primary font-bold text-center relative">
                Contact Us
                <div
                    class="absolute -z-10 -inset-2 bg-primary/10 blur-lg rounded-full animate-pulse"
                ></div>
            </h1>

            <div
                class="w-full max-w-2xl p-8 bg-white rounded-2xl shadow-xl transform hover:scale-[1.02] transition-all duration-300"
            >
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <input
                                v-model="form.first_name"
                                type="text"
                                required
                                id="first_name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300 peer placeholder-transparent"
                                placeholder="First Name"
                            />
                            <label
                                for="first_name"
                                class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary"
                                >First Name</label
                            >
                        </div>
                        <div class="relative">
                            <input
                                v-model="form.last_name"
                                type="text"
                                required
                                id="last_name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300 peer placeholder-transparent"
                                placeholder="Last Name"
                            />
                            <label
                                for="last_name"
                                class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary"
                                >Last Name</label
                            >
                        </div>
                    </div>

                    <div class="relative">
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            id="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300 peer placeholder-transparent"
                            placeholder="Email Address"
                        />
                        <label
                            for="email"
                            class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary"
                            >Email Address</label
                        >
                    </div>

                    <div class="relative">
                        <textarea
                            v-model="form.message"
                            required
                            rows="4"
                            id="message"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300 peer placeholder-transparent"
                            placeholder="Your Message"
                        ></textarea>
                        <label
                            for="message"
                            class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary"
                            >Your Message</label
                        >
                    </div>

                    <button
                        @click="submitForm"
                        class="w-full bg-primary hover:bg-primary_light text-white font-semibold py-3 px-6 rounded-lg transform hover:scale-105 transition-all duration-300 hover:shadow-lg"
                    >
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
    </component>
</template>
