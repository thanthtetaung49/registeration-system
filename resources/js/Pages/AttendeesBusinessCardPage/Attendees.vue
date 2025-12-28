<script setup>
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import defaultImage from "@/images/default_profile.png";
import { Link, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps({ users: Object, baseUrl: String });

const userData = ref(props.users.data);
const userLink = ref(props.users.links);
const baseUrl = ref(props.baseUrl).value;
const input = ref(null);
const query = ref(null);

onMounted(() => {
    input.value.focus();
});

const searchAttendees = () => {
    router.visit(`/attendess/business/card/search?query=${query.value}`, {
        method: "get",
        onSuccess: (page) => {
            userData.value = page.props.users.data;
            userLink.value = page.props.users.links;

            console.log(page);
        },
    });
};

</script>

<template>
    <AuthenticatedLayout>
        <div>
            <div class="min-h-screen bg-gray-50 p-8">
                <div>
                    <h3 class="text-2xl">Attendees Business Card</h3>
                </div>
                <div class="flex justify-end my-3 relative">
                    <TextInput ref="input" v-model="query" @keydown.enter="searchAttendees"
                        placeholder="Search attendees..." class="text-sm"></TextInput>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
                    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 flex flex-col items-center text-center transition-transform hover:-translate-y-2"
                        v-for="(user, index) in userData" :key="user.id">
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
