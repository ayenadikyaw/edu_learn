<script setup>
import { ref, onMounted } from "vue";
import axios from 'axios';
import { Link } from '@inertiajs/vue3';


//fetch courses from api
const courses = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get('courses/getCourses');
        courses.value = response.data;
        console.log('Response:', response);
        console.log('Courses:', courses.value);
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
});

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
<template>
    <!-- <ThemeSwitcher /> -->
    <div class="card">
        <Carousel :value="courses" :numVisible="3" :numScroll="1" :responsiveOptions="responsiveOptions" circular :autoplayInterval="3000">
            <template #item="slotProps">
                <div class="border border-surface-200 dark:border-surface-700 rounded m-2  p-4">
                    <div class="mb-4">
                        <div class="relative mx-auto">
                            <img src="/assets/images/defaultCourse1.jpg" :alt="slotProps.data.name" class="w-full rounded" />
                            <Tag :value="slotProps.data.status" :severity="getSeverity(slotProps.data.status)" class="absolute" style="left:5px; top: 5px"/>
                        </div>
                    </div>
                    <div class="mb-4 font-medium">{{ slotProps.data.title }}</div>
                    <div class="flex justify-between items-center">
                        <div class="mt-0 font-semibold text-xl">${{ slotProps.data.price }}</div>
                        <span>
                           <Link :href="`/courses/${slotProps.data.id}`" class="text-sm md:text-base text-primary font-semibold">View Course
                            <i class="pi pi-eye ml-2"></i>
                           </Link>
                        </span>
                    </div>
                </div>
            </template>
        </Carousel>
    </div>
</template>


