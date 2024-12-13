<script setup>
const currentYear = new Date().getFullYear();

const footerLinks = {
    courses: [
        { name: 'Web Development', url: '#' },
        { name: 'UI/UX Design', url: '#' },
        { name: 'Mobile Development', url: '#' },
        { name: 'Data Science', url: '#' }
    ],
    company: [
        { name: 'About Us', url: '#' },
        { name: 'Careers', url: '#' },
        { name: 'Blog', url: '#' },
        { name: 'Contact', url: '#' }
    ],
    support: [
        { name: 'Help Center', url: '#' },
        { name: 'Terms of Service', url: '#' },
        { name: 'Privacy Policy', url: '#' },
        { name: 'FAQ', url: '#' }
    ]
};
</script>

<template>
    <footer class="bg-primary text-white">
        <!-- Main Footer Content -->
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Brand Section -->
                <div class="space-y-6">
                    <div class="text-2xl font-bold">EduLearn</div>
                    <p class="text-white/80">
                        Empowering learners worldwide with quality education and innovative learning solutions.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-white/80 transition-colors">
                            <i class="pi pi-facebook text-xl"></i>
                        </a>
                        <a href="#" class="hover:text-white/80 transition-colors">
                            <i class="pi pi-twitter text-xl"></i>
                        </a>
                        <a href="#" class="hover:text-white/80 transition-colors">
                            <i class="pi pi-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="hover:text-white/80 transition-colors">
                            <i class="pi pi-instagram text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Courses Links -->
                <div>
                    <h3 class="text-xl font-semibold mb-6">Courses</h3>
                    <ul class="space-y-4">
                        <li v-for="link in footerLinks.courses" :key="link.name">
                            <a :href="link.url" class="text-white/80 hover:text-white transition-colors">
                                {{ link.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Company Links -->
                <div>
                    <h3 class="text-xl font-semibold mb-6">Company</h3>
                    <ul class="space-y-4">
                        <li v-for="link in footerLinks.company" :key="link.name">
                            <a :href="link.url" class="text-white/80 hover:text-white transition-colors">
                                {{ link.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div>
                    <h3 class="text-xl font-semibold mb-6">Support</h3>
                    <ul class="space-y-4">
                        <li v-for="link in footerLinks.support" :key="link.name">
                            <a :href="link.url" class="text-white/80 hover:text-white transition-colors">
                                {{ link.name }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-white/10">
            <div class="container mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-white/80">
                        © {{ currentYear }} EduLearn. All rights reserved.
                    </div>
                    <div class="flex space-x-6">
                        <a href="#" class="text-white/80 hover:text-white transition-colors">Terms</a>
                        <a href="#" class="text-white/80 hover:text-white transition-colors">Privacy</a>
                        <a href="#" class="text-white/80 hover:text-white transition-colors">Cookies</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped>
footer {
    position: relative;
    overflow: hidden;
}

footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}
</style>
