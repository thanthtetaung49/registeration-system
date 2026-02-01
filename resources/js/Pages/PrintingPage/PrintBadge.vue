<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import axios from "axios";
import BuildingImage from "@/images/building.jpg";
import { defineComponent, ref } from "vue";

defineComponent({ BuildingImage });

const props = defineProps({
    events: Object,
    nameBadgeData: Object,
    qrCode: String,
});

console.log(props);

const page = usePage();
const l = page.props.language;

const form = useForm({
    events_id: "",
    users_id: "",
});

const events = ref(props.events);
const attendees = ref([]);

const selectEvent = () => {
    const registerAttendees = [];
    axios
        .get(`/printBadge/event/${form.events_id}`)
        .then((response) => {
            const data = response.data;
            data.forEach((data) => {
                registerAttendees.push(data.register_attendees);
            });

            attendees.value = registerAttendees;
        })
        .catch((error) => {
            console.log(error);
        });
};

const nameBadgeGenerate = () => {
    form.post("/printBadge", {
        onSuccess: () => form.reset("events_id", "users_id"),
    });
};
</script>

<template>
    <div>
        <AuthenticatedLayout>
            <div class="px-10 py-10">
                <header class="mb-10">
                    <h3 class="text-gray-800 text-2xl pb-1 bold dark:text-white">{{ l.printBadge.title }}</h3>
                    <div class="w-10 h-1 bg-blue-800"></div>
                </header>

                <div class="w-full bg-white rounded-lg shadow-md dark:text-white dark:bg-gray-800 flex mb-20">
                    <div :class="!nameBadgeData ? 'w-full py-5' : 'w-1/3 py-5'">
                        <div class=" border-gray-200 dark:border-none px-4 pb-10 pt-3 mb-10">
                            <div class="mt-5">
                                <form v-on:submit.prevent="nameBadgeGenerate">
                                    <div class="w-full mr-3">
                                        <InputLabel :value="l.printBadge.label.eventName" class="mb-3"></InputLabel>
                                        <select v-model="form.events_id"
                                            class="hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 dark:border-none rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600"
                                            v-on:change="selectEvent">
                                            <option value="" selected>
                                                Choose Events
                                            </option>
                                            <option v-for="event in events" :key="event.id" :value="event.id">
                                                {{ event.event_name }}
                                            </option>
                                        </select>

                                        <TextInputError :message="form.errors.events_id"></TextInputError>
                                    </div>

                                    <div class="w-full mt-5">
                                        <InputLabel :value="l.printBadge.label.registeredAttendees" class="mb-3">
                                        </InputLabel>
                                        <select
                                            class="hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 dark:border-none rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600"
                                            v-model="form.users_id">
                                            <option value="">Choose Registered Attendees</option>
                                            <option v-for="attendee in attendees" :key="attendee.id"
                                                :value="attendee.id">
                                                {{ attendee.name }}
                                            </option>
                                        </select>
                                        <TextInputError :message="form.errors.users_id"></TextInputError>
                                    </div>

                                    <div class="w-full flex justify-end mt-5">
                                        <PrimaryButton type="submit">{{ l.printBadge.button.generate }}</PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div v-if="nameBadgeData" class="w-2/3 border-l py-5 px-10" >
                        <div class="mt-5 pt-5">
                            <header class="mb-5">
                                <h3 class="text-gray-800 text-lg pb-1 bold dark:text-white">
                                    {{ l.printBadge.cardDesignPreview }}
                                </h3>
                                <div class="w-10 h-1 bg-blue-800"></div>
                            </header>
                            <div class="w-full flex justify-end">
                                <a target="_blank" :href="`attendees/QRCode/download/${nameBadgeData.id}`"
                                    class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <span>{{ l.printBadge.button.download }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4 inline ms-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                </a>
                            </div>

                            <div
                                class="w-[4.5in] border-2 border-gray-200 rounded-xl shadow-2xl bg-white overflow-hidden flex flex-col font-sans mt-10">

                                <div class="h-4 bg-indigo-600 w-full"></div>

                                <div class="flex flex-col items-center justify-between h-full p-4">
                                    <div class="text-center">
                                        <h1 class="text-lg font-bold tracking-tight text-gray-800 uppercase">{{ nameBadgeData ? nameBadgeData.events.event_name : 'Sample Event name' }}
                                        </h1>
                                        <p class="text-xs text-gray-500 font-medium">Start Date: {{ nameBadgeData.events.start_date }} | End Date: {{ nameBadgeData.events.end_date }}</p>
                                    </div>

                                    <div class="p-2 bg-gray-50 rounded-lg border border-gray-100 shadow-inner my-3">
                                        <div v-html="qrCode" class="w-24 h-24"></div>
                                    </div>

                                    <div class="text-center">
                                        <p class="text-xs text-gray-500 font-medium">Start Time: {{ nameBadgeData.events.start_time }} | End Time: {{ nameBadgeData.events.end_time }}</p>
                                    </div>

                                    <div class="text-center w-full border-t pt-2 mt-3">
                                        <span class="text-[10px] uppercase font-semibold text-gray-400">Scan for
                                            Verification</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
