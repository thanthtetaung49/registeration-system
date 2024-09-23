<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import BuildingImage from "@/images/building.jpg";
import { defineComponent, ref } from "vue";

defineComponent({ BuildingImage });

const props = defineProps({
    events: Object,
    nameBadgeData: Object,
    qrCode: String,
});

const form = useForm({
    events_id: "",
    users_id: "",
});

const events = ref(props.events);
const attendees = ref([]);

const selectEvent = () => {
    const registerAttendees = [];
    axios
        .get(`/print/event/${form.events_id}`)
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
    form.post("/print", {
        onSuccess: () => form.reset("events_id", "users_id"),
    });
};
</script>

<template>
    <div>
        <AuthenticatedLayout>
            <div class="px-10 py-10">
                <header class="mb-10">
                    <h3 class="text-gray-800 text-2xl pb-1 bold dark:text-white">Print</h3>
                    <div class="w-10 h-1 bg-blue-800"></div>
                </header>

                <div class="w-full bg-white rounded-lg shadow-md dark:text-white dark:bg-gray-800">
                    <div class="border-b border-gray-200 dark:border-none px-4 pb-10 pt-3 mb-10">
                        <div class="mt-5">
                            <form v-on:submit.prevent="nameBadgeGenerate">
                                <div class="w-full flex">
                                    <div class="w-1/2 mr-3">
                                        <InputLabel
                                            :value="'Event name'"
                                            class="mb-3"
                                        ></InputLabel>
                                        <select
                                            v-model="form.events_id"
                                            class="hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 dark:border-none rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600"
                                            v-on:change="selectEvent"
                                        >
                                            <option value="" selected>
                                                Choose events
                                            </option>
                                            <option
                                                v-for="event in events"
                                                :key="event.id"
                                                :value="event.id"
                                            >
                                                {{ event.event_name }}
                                            </option>
                                        </select>

                                        <TextInputError
                                            :message="form.errors.events_id"
                                        ></TextInputError>
                                    </div>

                                    <div class="w-1/2">
                                        <InputLabel
                                            :value="'Register Attendees'"
                                            class="mb-3"
                                        ></InputLabel>
                                        <select
                                            class="hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 dark:border-none rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600"
                                            v-model="form.users_id"
                                        >
                                            <option value="">Choose</option>
                                            <option
                                                v-for="attendee in attendees"
                                                :key="attendee.id"
                                                :value="attendee.id"
                                            >
                                                {{ attendee.name }}
                                            </option>
                                        </select>
                                        <TextInputError
                                            :message="form.errors.users_id"
                                        ></TextInputError>
                                    </div>
                                </div>

                                <div class="w-full flex justify-end mt-5">
                                    <PrimaryButton type="submit"
                                        >Generate</PrimaryButton
                                    >
                                </div>
                            </form>
                        </div>

                        <div class="border-t mt-5 pt-5" v-if="nameBadgeData">
                            <header class="mb-5">
                                <h3 class="text-gray-800 text-lg pb-1 bold dark:text-white">
                                    Card design
                                </h3>
                                <div class="w-10 h-1 bg-blue-800"></div>
                            </header>
                            <div class="w-full flex justify-end">
                                <a
                                    target="_blank"
                                    :href="`attendees/qrcode/download/${nameBadgeData.id}`"
                                    class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <span>Download</span>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-4 inline ms-1"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"
                                        />
                                    </svg>
                                </a>
                            </div>

                            <div class="w-[5in] h-[2.5in] border shadow-lg">
                                <div
                                    class="flex justify-center items-center h-full w-full mt-[15px]"
                                >
                                    <div v-html="qrCode"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
