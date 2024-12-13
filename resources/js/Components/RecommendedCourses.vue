<template>
    <ThemeSwitcher />
    <div class="card">
        <Carousel :value="sampleCourses" :numVisible="3" :numScroll="1" :responsiveOptions="responsiveOptions" circular :autoplayInterval="3000">
            <template #item="slotProps">
                <div class="border border-surface-200 dark:border-surface-700 rounded m-2  p-4">
                    <div class="mb-4">
                        <div class="relative mx-auto">
                            <img src="../../../public/storage/assets/images/mission.jpg" :alt="slotProps.data.name" class="w-full rounded" />
                            <Tag :value="slotProps.data.status" :severity="getSeverity(slotProps.data.status)" class="absolute" style="left:5px; top: 5px"/>
                        </div>
                    </div>
                    <div class="mb-4 font-medium">{{ slotProps.data.name }}</div>
                    <div class="flex justify-between items-center">
                        <div class="mt-0 font-semibold text-xl">${{ slotProps.data.price }}</div>
                        <span>
                           <button class="text-primary font-semibold">View Course
                            <i class="pi pi-eye ml-2"></i>
                           </button>
                        </span>
                    </div>
                </div>
            </template>
        </Carousel>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

//import { Carousel } from 'primevue/carousel';



const sampleCourses = ref([
    {
        image: 'course-1.jpg',
        name: 'Introduction to Python',
        status: 'Popular',
        price: 19.99
    },
    {
        image: 'course-2.jpg',
        name: 'Web Development Fundamentals',
        status: 'New',
        price: 29.99
    },
    {
        image: 'course-3.jpg',
        name: 'Data Science Essentials',
        status: 'Trending',
        price: 39.99
    },
    {
        image: 'course-4.jpg',
        name: 'Machine Learning Basics',
        status: 'New',
        price: 49.99
    }
]);
const responsiveOptions = ref([
    {
        breakpoint: '1400px',
        numVisible: 2,
        numScroll: 1
    },
    {
        breakpoint: '1199px',
        numVisible: 3,
        numScroll: 1
    },
    {
        breakpoint: '767px',
        numVisible: 2,
        numScroll: 1
    },
    {
        breakpoint: '575px',
        numVisible: 1,
        numScroll: 1
    }
]);

const getSeverity = (status) => {
    switch (status) {
        case 'Popular':
            return 'success';

        case 'New':
            return 'warn';

        case 'Trending':
            return 'danger';

        default:
            return null;
    }
};

</script>
