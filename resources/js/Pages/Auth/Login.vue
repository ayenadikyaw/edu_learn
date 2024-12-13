<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import LoginLayout from '@/Layouts/LoginLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import DefaultLayout from "@/Components/Layouts/default.vue";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
        onSuccess: () => {
            // Force a full page reload after successful login
            window.location.reload();
        },
        onError: () => {
            console.error('Login failed');
        },
        preserveScroll: true,
    });
};


</script>

<template>
    <DefaultLayout>
        <LoginLayout>
            <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="animate-fade-in">
            <div class="relative">
                <TextInput
                    id="email"
                    type="email"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300 peer placeholder-transparent"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Email"
                />
                <label
                    for="email"
                    class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary"
                >Email</label>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4 relative">
                <TextInput
                    id="password"
                    type="password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300 peer placeholder-transparent"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                />
                <label
                    for="password"
                    class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary"
                >Password</label>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600"
                        >Remember me</span
                    >
                </label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton type="submit"
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
                </div>
            </form>
        </LoginLayout>
    </DefaultLayout>
</template>
