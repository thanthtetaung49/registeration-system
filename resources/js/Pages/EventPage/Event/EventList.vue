<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EventTabLayout from "@/Layouts/EventTabLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
import { ref, onMounted } from "vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({ events: Object });

const registerEvents = ref([]);
const query = ref(null);
const eventsData = ref(props.events.data);
const eventLink = ref(props.events.links);
const input = ref(null);
const qrCode = ref(null);
const event = ref(null);

const getRegisterAttendees = (eventId) => {
  axios
    .get(`/event/eventList/eventAttendeesList/${eventId}`)
    .then((response) => {
      registerEvents.value = response.data;
    })
    .catch((error) => {
      console.error(error);
    });
};

const eventType2QrGenerate = (eventId) => {
  axios
    .get(`/event/eventList/selfCheckInUser/QRCode/generate/${eventId}`)
    .then((response) => {
      console.log(response);
      qrCode.value = response.data.qrCode;
      event.value = response.data.event;
    })
    .catch((error) => console.error(error));
};

const searchEvent = () => {
  router.visit(`/event/eventList/search?query=${query.value}`, {
    method: "get",
    onSuccess: (page) => {
      eventsData.value = page.props.events.data;
      eventLink.value = page.props.events.links;
    },
  });
};

onMounted(() => {
  input.value.focus();
});

</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="px-10 py-10">
        <header class="mb-10">
          <h3 class="text-gray-800 text-2xl pb-1 bold dark:text-white">Events</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>

        <div class="w-full bg-white rounded-lg shadow-md dark:text-white dark:bg-gray-800">
          <div class="border-b border-gray-200 dark:border-none px-4 pb-5 mb-10">
            <EventTabLayout></EventTabLayout>

            <div class="flex justify-end">
              <div class="relative">
                <TextInput
                  ref="input"
                  v-model.lazy="query"
                  @keydown.enter="searchEvent"
                  placeholder="Search Event"
                  class="text-sm"
                ></TextInput>
                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-4"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                    />
                  </svg>
                </div>
              </div>
            </div>

            <div class="flex flex-col mt-5">
              <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                  <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                      <thead>
                        <tr>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            No
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            Event name
                          </th>
                          <th
                            scope="col"
                            class="px-2 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            Event type
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            Description
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            Location
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            Lead instructor
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            Assist instructor
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            Category
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            Created at
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase"
                          >
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200">
                        <tr v-for="(event, index) in eventsData" :key="event.id">
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                          >
                            {{ index + 1 }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                          >
                            {{ event.event_name }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                          >
                            {{ event.event_type == 1 ? "Type I" : "Type II" }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                          >
                            {{ event.description }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                          >
                            {{ event.location }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                          >
                            {{ event.lead_instructors.name }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                          >
                            {{ event.assists_instructors.name }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                          >
                            {{ event.categories.category_name }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                          >
                            {{ event.created_at.split("T")[0] }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium"
                          >
                            <div class="inline-block">
                              <button
                                v-if="event.event_type == 2"
                                type="button"
                                class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-whitedisabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-indigo-700 hover:text-white hs-tooltip-toggle"
                                aria-haspopup="dialog"
                                aria-expanded="false"
                                aria-controls="hs-scale-animation-modal"
                                data-hs-overlay="#register-attendees-qrcode-modal"
                                v-on:click="eventType2QrGenerate(event.id)"
                              >
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="none"
                                  viewBox="0 0 24 24"
                                  stroke-width="1.5"
                                  stroke="currentColor"
                                  class="size-4"
                                >
                                  <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z"
                                  />
                                  <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z"
                                  />
                                </svg>
                              </button>
                            </div>

                            <div class="inline-block">
                              <button
                                type="button"
                                class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-whitedisabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-blue-700 hover:text-white hs-tooltip-toggle"
                                aria-haspopup="dialog"
                                aria-expanded="false"
                                aria-controls="hs-scale-animation-modal"
                                data-hs-overlay="#register-attendees-modal"
                                v-on:click="getRegisterAttendees(event.id)"
                              >
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="none"
                                  viewBox="0 0 24 24"
                                  stroke-width="1.5"
                                  stroke="currentColor"
                                  class="size-4"
                                >
                                  <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                                  />
                                </svg>
                              </button>
                            </div>

                            <div class="inline-block">
                              <Link
                                :href="`/event/eventList/view/${event.id}`"
                                class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-whitedisabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-green-700 hover:text-white hs-tooltip-toogle"
                                aria-haspopup="dialog"
                                aria-expanded="false"
                                aria-controls="hs-scale-animation-modal"
                                data-hs-overlay="#event-view-modal"
                              >
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="none"
                                  viewBox="0 0 24 24"
                                  stroke-width="1.5"
                                  stroke="currentColor"
                                  class="size-4"
                                >
                                  <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                                  />
                                  <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                  />
                                </svg>
                              </Link>
                            </div>

                            <div class="hs-tooltip inline-block">
                              <Link
                                :href="`/event/eventList/edit/${event.id}`"
                                class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-whitedisabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-gray-700 hover:text-white hs-tooltip-toggle"
                                aria-haspopup="dialog"
                                aria-expanded="false"
                                aria-controls="hs-scale-animation-modal"
                                data-hs-overlay="#hs-scale-animation-modal"
                              >
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="none"
                                  viewBox="0 0 24 24"
                                  stroke-width="1.5"
                                  stroke="currentColor"
                                  class="size-4"
                                >
                                  <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                                  />
                                </svg>
                              </Link>
                            </div>

                            <div class="hs-tooltip inline-block">
                              <Link
                                :href="`/event/eventList/delete/${event.id}`"
                                class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-whitedisabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-red-700 hover:text-white hs-tooltip-toggle"
                                aria-haspopup="dialog"
                                aria-expanded="false"
                                aria-controls="hs-scale-animation-modal"
                                data-hs-overlay="#hs-scale-animation-modal"
                              >
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="none"
                                  viewBox="0 0 24 24"
                                  stroke-width="1.5"
                                  stroke="currentColor"
                                  class="size-4"
                                >
                                  <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                  />
                                </svg>
                              </Link>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="flex justify-end w-full">
              <div class="mb-10 my-5">
                <Link
                  :href="link.url"
                  v-for="(link, index) in eventLink"
                  :key="index"
                  class="border py-2 px-3 text-sm dark:text-white"
                  :class="{
                    'bg-blue-500 text-white': link.active,
                  }"
                >
                  <span v-html="link.label"></span
                ></Link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- attendees view modal area -->
      <div
        id="register-attendees-modal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog"
        tabindex="-1"
        aria-labelledby="hs-scale-animation-modal-label"
      >
        <div
          class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 lg:max-w-6xl sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center"
        >
          <div
            class=" dark:text-white w-full flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70"
          >
            <div
              class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700"
            >
              <h3
                id="register-attendees-modal"
                class="font-bold text-gray-800 dark:text-white"
              >
                Attendees Lists
              </h3>
              <button
                type="button"
                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                aria-label="Close"
                data-hs-overlay="#register-attendees-modal"
              >
                <span class="sr-only">Close</span>
                <svg
                  class="shrink-0 size-4"
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
            </div>
            <div class="p-4 overflow-y-auto">
              <div class="flex flex-col mt-5">
                <div class="-m-1.5 overflow-x-auto">
                  <div class="p-1.5 min-w-full h-[400px] inline-block align-middle">
                    <div class="mb-3 flex items-center">
                      <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-100"></div>
                        <div class="text-sm ms-2">Register</div>
                      </div>
                      <div class="flex items-center ms-3">
                        <div class="w-3 h-3 bg-red-100"></div>
                        <div class="text-sm ms-2">Not register</div>
                      </div>
                    </div>
                    <div class="overflow-hidden">
                      <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                          <tr>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              No
                            </th>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              Attendees name
                            </th>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              Email
                            </th>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              Department
                            </th>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              Positions
                            </th>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              Register at
                            </th>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              Created at
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                          <tr
                            v-for="(attendee, index) in registerEvents"
                            :key="attendee.id"
                            :class="{
                              'bg-blue-100': attendee.registration_status == 1,
                              'bg-red-100': attendee.registration_status == 0,
                            }"
                          >
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ index + 1 }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ attendee.register_attendees.name }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ attendee.register_attendees.email }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ attendee.register_attendees.department }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ attendee.register_attendees.position }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              <span
                                v-if="
                                  attendee.registration_status == 1 && attendee.scan_time
                                "
                              >
                                {{ attendee.scan_time }}
                              </span>
                              <span v-else>-</span>
                            </td>

                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ attendee.register_attendees.created_at.split("T")[0] }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700"
            >
              <button
                type="button"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 dark:border-none bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                data-hs-overlay="#register-attendees-modal"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- event qr code view area -->
      <div
        id="register-attendees-qrcode-modal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog"
        tabindex="-1"
        aria-labelledby="hs-scale-animation-modal-label"
      >
        <div
          class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 lg:max-w-sm sm:w-full m-3 sm:mx-auto  flex items-center"
        >
          <div
            class="w-full flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70"
          >
            <div
              class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700"
            >
              <h3
                id="register-attendees-qrcode-modal"
                class="font-bold text-gray-800 dark:text-white"
              >
                {{ event?.event_name }}
              </h3>
              <button
                type="button"
                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                aria-label="Close"
                data-hs-overlay="#register-attendees-qrcode-modal"
              >
                <span class="sr-only">Close</span>
                <svg
                  class="shrink-0 size-4"
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
            </div>
            <div class="p-4 overflow-y-auto">
              <div class="w-full flex justify-end">
                <a
                  target="_blank" :href="`/event/QRCode/download/${event?.id}`"
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
              <div class="flex flex-col mt-5">
                <div class="-m-1.5 overflow-x-auto">
                  <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="w-full flex justify-center items-center h-full">
                      <div v-html="qrCode"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700"
            >
              <button
                type="button"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 dark:border-none bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                data-hs-overlay="#register-attendees-qrcode-modal"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
