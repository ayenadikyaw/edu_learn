<script setup lang="ts">
import AuthHeader from '@/Components/Layouts/auth_header.vue';
import Footer from '@/Components/Layouts/footer.vue';
import { usePage } from '@inertiajs/vue3';

if (usePage().props.flash?.['auth.logout']) {
    window.location.href = '/';
}

defineOptions({
    name: 'AuthenticatedLayout',
});
</script>

<template>
    <div>
        <AuthHeader />
        <main>
            <!-- Add some visible content to verify the layout is loading -->
            <div class="bg-blue-100 p-2">Authenticated Layout Loaded</div>
            <slot />
        </main>
        <Footer />
    </div>
</template>