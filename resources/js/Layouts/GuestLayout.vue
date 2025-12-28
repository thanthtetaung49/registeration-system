<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Header title="Online Regisration System"></Header>
    <div class="w-full h-screen flex">
        <div style="background-image: url('/img/coverImage/coverImage.jpg');" class="w-1/2 relative bg-cover bg-center">
            <div class="absolute inset-0 bg-black opacity-60"></div>

            <div class="relative z-10 p-6 text-white top-1/2 -translate-y-1/2">
                <h1 class="text-5xl font-bold text-blue-400">Welcome to Your Event Registration Portal !</h1>
                <p class="mt-10 max-w-md">Log in to your account and get started with a smooth and secure registration experience.</p>
            </div>

        </div>
        <div class="w-1/2 h-full">
            <div class="w-full flex items-center justify-center h-full">
                <!-- <div>
                    <Link href="/">
                        <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
                    </Link>
                </div> -->

                <div
                    class="dark:bg-gray-800 w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <slot />
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div
            class="dark:bg-gray-800 w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div> -->
</template>
