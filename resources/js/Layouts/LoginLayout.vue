<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

// Watch for both forceReload and clearAdminLayout
watch(() => [page.props.flash?.forceReload, page.props.flash?.clearAdminLayout], ([newReload, newClear]) => {
    if (newReload || newClear) {
        window.location.reload();
    }
});
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center justify-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
    >
        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <div>
                <Link href="/">
                    <ApplicationLogo
                        class="h-28 w-28 fill-current text-gray-500 mx-auto"
                    />
                </Link>
            </div>
            <slot />
        </div>
    </div>
</template>
