<script setup>
import { usePage } from '@inertiajs/vue3'

const user = usePage().props.auth.user
console.log('Current user:', user)

</script>

<template>
    <div>
        Dashboard
    </div>
</template>
