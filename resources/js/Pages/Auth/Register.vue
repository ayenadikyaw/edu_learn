<script setup>
import GuestLayout from "@/Layouts/LoginLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import DefaultLayout from "@/Components/Layouts/default.vue";

const page = usePage();
const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <DefaultLayout>
        <GuestLayout>
            <Head title="Register" />

            <form @submit.prevent="submit" class="animate-fade-in">
                <div class="relative">
                    <TextInput
                        id="name"
                        type="text"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300 peer placeholder-transparent"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Name"
                    />
                    <label
                        for="name"
                        class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary"
                        >Name</label
                    >

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4 relative">
                    <TextInput
                        id="email"
                        type="email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300 peer placeholder-transparent"
                        v-model="form.email"
                        required
                        autocomplete="username"
                        placeholder="Email"
                    />
                    <label
                        for="email"
                        class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary"
                        >Email</label
                    >

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4 relative">
                    <TextInput
                        id="password"
                        type="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300 peer placeholder-transparent"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="Password"
                    />
                    <label
                        for="password"
                        class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary"
                        >Password</label
                    >

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4 relative">
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300 peer placeholder-transparent"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm Password"
                    />
                    <label
                        for="password_confirmation"
                        class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary"
                        >Confirm Password</label
                    >

                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <Link
                        :href="route('login')"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Already registered?
                    </Link>

                    <PrimaryButton
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    </DefaultLayout>
</template>
