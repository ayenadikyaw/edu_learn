<script setup>
 const slides = [
        {
            image: '/images/slide1.jpg',
            title: 'Transform Your Future With Online Learning',
            description: 'Access world-class education from anywhere. Learn at your own pace with our flexible online courses.'
        },
        {
            image: '/images/slide2.jpg',
            title: 'Expert-Led Courses',
            description: 'Learn from industry professionals and gain practical skills that employers value.'
        },
        {
            image: '/images/slide3.jpg',
            title: 'Interactive Learning Experience',
            description: 'Engage with dynamic content, collaborate with peers, and get real-time feedback.'
        }
    ];
</script>


<template>
     <div class="carousel-section mt-20">
        <Carousel 
            :value="slides" 
            :numVisible="1" 
            :numScroll="1" 
            :autoplayInterval="3000"
            :circular="true"
            :showNavigators="false"
            class="custom-carousel"
        >
            <template #item="sliderData">
                <div class="relative h-[600px] w-full">
                    <img 
                        :src="sliderData.data.image" 
                        :alt="sliderData.data.title"
                        class="w-full h-full object-cover rounded-lg"
                    >
                    <div class="absolute inset-0 bg-primary bg-opacity-40 flex flex-col justify-center items-center text-white p-8">
                        <h2 class="text-4xl font-bold mb-4">{{ sliderData.data.title }}</h2>
                        <p class="text-xl text-center max-w-2xl">{{ sliderData.data.description }}</p>
                    </div>
                </div>
            </template>
        </Carousel>
    </div>
</template>

<style scoped>
.custom-carousel :deep(.p-carousel-indicators) {
    justify-content: center;
    margin-top: 1rem;
}

.custom-carousel :deep(.p-carousel-indicator button) {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #ffffff;
    opacity: 0.5;
    transition: all 0.3s ease;
}

.custom-carousel :deep(.p-carousel-indicator.p-highlight button) {
    background-color: #7ed957;
    opacity: 1;
    transform: scale(1.2);
}
</style>
