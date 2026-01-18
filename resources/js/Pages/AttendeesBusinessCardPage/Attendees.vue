<script setup>
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import defaultImage from "@/images/default_profile.png";
import { Link, router, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps({ users: Object, baseUrl: String });

const userData = ref(props.users.data);
const userLink = ref(props.users.links);
const baseUrl = ref(props.baseUrl).value;
const input = ref(null);
const query = ref(null);
const page = usePage();
const l = page.props.language;

onMounted(() => {
    input.value.focus();
});

const searchAttendees = () => {
    router.visit(`/attendess/business/card/search?query=${query.value}`, {
        method: "get",
        onSuccess: (page) => {
            userData.value = page.props.users.data;
            userLink.value = page.props.users.links;
        },
    });
};

const togglePublic = (id) => {
    router.visit(`/attendess/business/card/change/url/status/` + id, {
        method: "get",
        onSuccess: (page) => {
            userData.value = page.props.users.data;
            userLink.value = page.props.users.links;
        },
    });
};

</script>

<template>
    <AuthenticatedLayout>
        <div>
            <div class="min-h-screen bg-gray-50 p-8 dark:bg-gray-800">
                <div>
                    <h3 class="text-2xl dark:text-white">{{ l.businessCards.title }}</h3>
                </div>
                <div class="flex justify-end my-3 relative">
                    <TextInput ref="input" v-model="query" @keydown.enter="searchAttendees"
                        :placeholder="l.businessCards.searchPlaceholder" class="text-sm"></TextInput>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
                    <div class="bg-white dark:bg-gray-900 dark:border-gray-800 rounded-[2rem] p-6 shadow-sm border border-gray-100 flex flex-col items-center text-center transition-transform hover:-translate-y-2"
                        v-for="(user, index) in userData" :key="user.id">

                        <div class="flex justify-end w-full mb-3">
                            <button v-if="user.is_public_url" type="button" v-on:click="togglePublic(user.id)" class="text-blue-700">
                                <span class="text-xs">Public</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4 inline ms-1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                            <button v-else type="button"  v-on:click="togglePublic(user.id)" class="text-blue-700">
                                <span class="text-xs">Private</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4 inline ms-1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>

                            </button>
                        </div>

                        <img v-if="user.profile_path" :src="`${baseUrl}/storage/${user.profile_path}`"
                            alt="preview image" class="w-20 h-20 rounded-2xl object-cover mb-4 grayscale" />
                        <img v-else :src="defaultImage" alt="preview image"
                            class="w-20 h-20 rounded-2xl object-cover mb-4 grayscale" />

                        <h3 class="text-sm font-bold text-gray-900">{{ user.name }}</h3>
                        <p class="text-xs text-gray-400 mb-6">{{ user.department }}</p>

                        <div class="bg-gray-50 p-3 rounded-2xl border border-dashed border-gray-200">
                            <img :src="`https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=${encodeURIComponent(route('businessCard.view', user.id))}`"
                                alt="QR" class="w-20 h-20 opacity-80">
                        </div>
                        <p class="mt-4 text-[10px] font-bold text-gray-300 uppercase tracking-widest">Scan to Connect
                        </p>
                    </div>
                </div>

                <div class="flex justify-center w-full">
                    <div class="mb-10 my-5">
                        <Link :href="link.url" v-for="(link, index) in userLink" :key="index"
                            class="border py-2 px-3 text-sm dark:text-white" :class="{
                                'bg-blue-500 text-white': link.active,
                            }">
                            <span v-html="link.label"></span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
