<script setup>
const missionSteps = [
    {
        year: '2023',
        title: 'Launch & Innovation',
        description: 'Established our platform with cutting-edge learning technologies and innovative teaching methodologies.',
        icon: 'pi pi-rocket',
        color: 'from-primary to-primary_light'
    },
    {
        year: '2024',
        title: 'Global Expansion',
        description: 'Expanding our reach to serve learners worldwide with localized content and partnerships.',
        icon: 'pi pi-globe',
        color: 'from-secondary to-secondary_light'
    },
    {
        year: '2025',
        title: 'AI Integration',
        description: 'Implementing advanced AI-powered personalized learning paths and adaptive assessments.',
        icon: 'pi pi-cog',
        color: 'from-blue-400 to-blue-600'
    },
    {
        year: '2026',
        title: 'Industry Leadership',
        description: 'Becoming the leading platform for professional skill development and career transformation.',
        icon: 'pi pi-star',
        color: 'from-purple-400 to-purple-600'
    }
];
</script>

<template>
    <div class="py-20 bg-gray-50 overflow-hidden">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16 relative">
                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-primary/10 rounded-full blur-xl"></div>
                <h2 class="text-4xl font-bold text-primary mb-4 relative">Our Mission Timeline</h2>
                <p class="text-gray-600 max-w-2xl mx-auto relative">Charting our journey towards transforming education and empowering learners worldwide</p>
            </div>

            <!-- Timeline Container -->
            <div class="relative">
                <!-- Center Line -->
                <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-primary/20 to-secondary/20"></div>

                <!-- Timeline Items -->
                <div class="relative">
                    <div v-for="(step, index) in missionSteps" :key="index" 
                        class="flex items-center mb-16 last:mb-0"
                        :class="index % 2 === 0 ? 'flex-row' : 'flex-row-reverse'"
                    >
                        <!-- Content Box -->
                        <div class="w-5/12 group" 
                            :class="index % 2 === 0 ? 'pr-16 text-right' : 'pl-16 text-left'"
                        >
                            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <div class="inline-block px-4 py-2 rounded-full bg-gradient-to-r mb-4 text-white font-bold" :class="step.color">
                                    {{ step.year }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ step.title }}</h3>
                                <p class="text-gray-600">{{ step.description }}</p>
                            </div>
                        </div>

                        <!-- Center Icon -->
                        <div class="w-2/12 flex justify-center relative">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r flex items-center justify-center text-white shadow-lg transform transition-all duration-300 hover:scale-110 hover:rotate-12"
                                :class="step.color">
                                <i :class="step.icon" class="text-xl"></i>
                            </div>
                        </div>

                        <!-- Spacer for opposite side -->
                        <div class="w-5/12"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

.timeline-item {
    animation: float 6s ease-in-out infinite;
}

/* Stagger animation delay for each item */
.timeline-item:nth-child(2) {
    animation-delay: 1s;
}
.timeline-item:nth-child(3) {
    animation-delay: 2s;
}
.timeline-item:nth-child(4) {
    animation-delay: 3s;
}
</style>
