<script setup>
import Header from '@/Components/Layouts/header.vue';
import Footer from '@/Components/Layouts/footer.vue';
</script>

<template>
    <div>
        <Header />
        <main>
            <slot />
        </main>
        <Footer />
    </div>
</template>