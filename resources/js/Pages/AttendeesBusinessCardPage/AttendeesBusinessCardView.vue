<script setup>
import { ref } from 'vue';
import defaultImage from "@/images/default_profile.png";

const props = defineProps({ user: Object, baseUrl: String });

const user = ref(props.user);
const baseUrl = ref(props.baseUrl).value;

</script>

<template>
    <div>
        <div class="flex items-center justify-center min-h-screen bg-gray-100 p-4">
            <div
                class="max-w-md w-full bg-white rounded-xl shadow-lg overflow-hidden md:max-w-2xl border border-gray-200">
                <div class="md:flex">
                    <div class="md:shrink-0 bg-indigo-600 flex items-center justify-center p-6">
                        <img v-if="user.profile_path" :src="`${baseUrl}/storage/${user.profile_path}`"
                            alt="Profile Photo" class="h-32 w-32 object-cover rounded-full border-4 border-white shadow-md md:h-48 md:w-48" />
                        <img v-else :src="defaultImage" alt="Profile Photo"
                            class="h-32 w-32 object-cover rounded-full border-4 border-white shadow-md md:h-48 md:w-48" />
                    </div>

                    <div class="p-8 w-full">
                        <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold mb-1">{{ user.department }}
                        </div>
                        <h1 class="block mt-1 text-2xl leading-tight font-bold text-black">{{ user.name }}</h1>
                        <p class="text-slate-500 font-medium mb-4">{{ user.position }}</p>

                        <hr class="mb-4">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">NRC Number</span>
                                <p class="text-gray-700">{{ user.nrc_number }}</p>
                            </div>
                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">Sex</span>
                                <p class="text-gray-700">{{ user.sex === 0 ? 'Male' : 'Female' }}</p>
                            </div>
                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">Education Background</span>
                                <p class="text-gray-700">{{ user.edu_background }}</p>
                            </div>
                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">Address</span>
                                <p class="text-gray-700">{{ user.address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
