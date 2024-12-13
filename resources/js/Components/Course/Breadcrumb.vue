<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    items: {
        type: Array,
        required: true,
        // Each item should have label and url properties
        validator: (items) => {
            return items.every(item => 'label' in item && 'url' in item);
        }
    }
});
</script>

<template>
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li v-for="(item, index) in items" :key="index" class="inline-flex items-center">
                <template v-if="index === 0">
                    <Link :href="item.url" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary">
                        <i class="pi pi-home mr-2"></i>
                        {{ item.label }}
                    </Link>
                </template>
                <template v-else>
                    <div class="flex items-center">
                        <i class="pi pi-angle-right text-gray-400 mx-2"></i>
                        <Link 
                            :href="item.url"
                            :class="[
                                'text-sm font-medium',
                                index === items.length - 1 
                                    ? 'text-primary cursor-default pointer-events-none'
                                    : 'text-gray-700 hover:text-primary'
                            ]"
                        >
                            {{ item.label }}
                        </Link>
                    </div>
                </template>
            </li>
        </ol>
    </nav>
</template>
