<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextInputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import BuildingImage from "@/images/building.jpg";
import { defineComponent, ref } from "vue";

defineComponent({ BuildingImage });

const props = defineProps({
  events: Object,
  attendees: Object,
  nameBadgeData: Object,
  qrCode: String,
});

const form = useForm({
  events_id: "",
  users_id: "",
});

const events = ref([]);

const selectAttendee = () => {
  events.value = [];

  axios
    .get(`/print/event/${form.users_id}`)
    .then((response) => {
      response.data.forEach((data) => {
        events.value.push(data.events);
      });
      console.log(form.users_id);
      console.log(events);
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
          <h3 class="text-gray-800 text-2xl pb-1 bold">Print</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>

        <div class="w-full bg-white rounded-lg shadow-md">
          <div class="border-b border-gray-200 px-4 pb-10 pt-3 mb-10">
            <!-- <AttendeesTabLayout></AttendeesTabLayout> -->

            <div class="mt-5">
              <form v-on:submit.prevent="nameBadgeGenerate">
                <div class="w-full flex">
                  <div class="w-1/2">
                    <InputLabel
                      :value="'Register Attendees'"
                      class="mb-3"
                    ></InputLabel>
                    <select
                      data-hs-select='{
  "placeholder": "Select attendees...",
  "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
  "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
  "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
}'
                      class="hidden"
                      v-model="form.users_id"
                      v-on:change="selectAttendee"
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

                  <div class="w-1/2 ms-3">
                    <InputLabel :value="'Event name'" class="mb-3"></InputLabel>
                    <select
                      v-model="form.events_id"
                      class="hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600"
                    >
                      <option value="" selected>Choose events</option>
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
                </div>

                <div class="w-full flex justify-end mt-5">
                  <PrimaryButton type="submit">Generate</PrimaryButton>
                </div>
              </form>
            </div>

            <div class="border-t mt-5 pt-5" v-if="nameBadgeData">
              <header class="mb-5">
                <h3 class="text-gray-800 text-lg pb-1 bold">Card design</h3>
                <div class="w-10 h-1 bg-blue-800"></div>
              </header>
              <div class="w-full flex justify-end">
                <a
                  target="_blank"
                  :href="`qrcode/download/${nameBadgeData.id}`"
                  class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                  <span>Download</span>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-5 inline ms-1"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"
                    />
                  </svg>
                </a>
              </div>

              <div class="w-[3.5in] h-[3.5in] border shadow-lg">
                <div>
                  <h3 class="text-blue-700 text-xl text-center mt-5">
                    {{ nameBadgeData.events.event_name }}
                  </h3>
                </div>
                <div class="flex justify-center w-full mt-5 mb-10">
                  <div v-html="qrCode"></div>
                </div>
                <div class="w-full h-28 bg-blue-700 mt-3">
                  <ul class="ms-5 py-3">
                    <li class="text-white py-[2px] text-lg underline">
                      <span>{{ nameBadgeData.register_attendees.name }}</span>
                    </li>
                    <li class="text-white py-[2px] text-sm underline">
                      <span>{{
                        nameBadgeData.register_attendees.department
                      }}</span>
                    </li>
                    <li class="text-white py-[2px] text-sm underline">
                      <span>{{
                        nameBadgeData.register_attendees.position
                      }}</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
