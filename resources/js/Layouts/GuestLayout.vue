<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Header title="Online Regisration System"></Header>
    <div class="w-full h-screen lg:flex">
        <div style="background-image: url('/img/coverImage/coverImage.jpg');" class="hidden lg:block lg:w-1/2 relative bg-cover bg-center">
            <div class="absolute inset-0 bg-black opacity-60"></div>

            <div class="relative z-10 p-6 text-white top-1/2 -translate-y-1/2">
                <h1 class="text-5xl font-bold text-blue-400">Welcome to Your Event Registration Portal !</h1>
                <p class="mt-10 max-w-md">Log in to your account and get started with a smooth and secure registration
                    experience.</p>
            </div>

        </div>

        <div class="sm:w-full lg:w-1/2 h-full dark:bg-gray-900">
            <div>
                <Link :href="route('businessCard.public.index')" class="absolute top-6 right-6 flex items-center space-x-2 text-sm dark:text-white underline">
                    Business Card
                </Link>
            </div>
            <div class="sm:w-full flex items-center justify-center h-full">
                <div
                    class="dark:bg-gray-800 w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
