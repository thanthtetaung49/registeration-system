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
                    <div class="md:shrink-0 bg-indigo-600 flex items-start justify-center p-6">
                        <img v-if="user.profile_path" :src="`${baseUrl}/storage/${user.profile_path}`"
                            alt="Profile Photo"
                            class="h-32 w-32 object-cover rounded-full border-4 border-white shadow-md md:h-48 md:w-48" />
                        <img v-else :src="defaultImage" alt="Profile Photo"
                            class="h-32 w-32 object-cover rounded-full border-4 border-white shadow-md md:h-48 md:w-48" />
                    </div>

                    <div class="p-8 w-full">
                        <div class="text-end">
                            <span v-if="user.disable_status == 0" class="bg-green-100 text-xs px-5 py-2 text-green-900 rounded-full">Active</span>
                            <span v-else class="bg-red-100 text-xs px-5 py-2 text-red-900 rounded-full">Disabled</span>
                        </div>
                        <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold mb-1">{{
                            user.department }}
                        </div>
                        <h1 class="block mt-1 text-2xl leading-tight font-bold text-black">{{ user.name }}</h1>
                        <p class="text-slate-500 font-medium mb-4">{{ user.position }}</p>

                        <hr class="mb-4">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">Teacher ID no</span>
                                <p class="text-gray-700">{{ user.teacher_id }}</p>
                            </div>

                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">မိဘအမည်</span>
                                <p class="text-gray-700">{{ user.parent_name }}</p>
                            </div>

                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">လိင်</span>
                                <p class="text-gray-700">{{ user.gender }}</p>
                            </div>

                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">မွေးသက္ကရာဇ်</span>
                                <p class="text-gray-700">{{ user.birth_date }}</p>
                            </div>

                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">NRC Number</span>
                                <p class="text-gray-700">{{ user.nrc_number }}</p>
                            </div>

                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">လူမျိုး</span>
                                <p class="text-gray-700">{{ user.nation }}</p>
                            </div>

                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">TLEC တွင်
                                    စတင်အလုပ်ဝင်သည့်ခုနှစ် (DD/MM/YYYY)</span>
                                <p class="text-gray-700">{{ user.join_date }}</p>
                            </div>

                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">တာဝန်ကျသည့် ကျောင်း
                                </span>
                                <p class="text-gray-700">{{ user.place_of_duty }}</p>
                            </div>

                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">အမြဲတမ်းနေထိုင်သည့် လိပ်စာ
                                    အပြည့်အစုံ </span>
                                <p class="text-gray-700">{{ user.address }}</p>
                            </div>

                            <div>
                                <span class="block text-gray-400 font-bold uppercase text-xs">ဆက်သွယ်ရန်
                                    ဖုန်းနံပါတ်</span>
                                <p class="text-gray-700">{{ user.phone_number }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
