<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EventTabLayout from "@/Layouts/EventTabLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({ events: Object });

const registerEvents = ref([]);

const getRegisterAttendees = (eventId) => {
  axios
    .get(`/event/attendees/list/${eventId}`)
      .then((response) =>
      {
        registerEvents.value = response.data;
    })
    .catch((error) => {
      console.error(error);
    });
};
</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="px-10 py-10">
        <header class="mb-10">
          <h3 class="text-gray-800 text-2xl pb-1 bold">Event</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>

        <div class="w-full bg-white rounded-lg shadow-md">
          <div class="border-b border-gray-200 px-4 pb-5 mb-10">
            <EventTabLayout></EventTabLayout>

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
                        <tr
                          v-for="(event, index) in events.data"
                          :key="event.id"
                        >
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                          >
                            {{ index + 1 }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                          >
                            {{ event.event_name }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                          >
                            {{ event.description }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                          >
                            {{ event.location }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                          >
                            {{ event.lead_instructors.name }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                          >
                            {{ event.assists_instructors.name }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                          >
                            {{ event.categories.category_name }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                          >
                            {{ event.created_at.split("T")[0] }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium"
                          >
                            <button
                              type="button"
                              class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-blue-700 hover:text-white"
                              aria-haspopup="dialog"
                              aria-expanded="false"
                              aria-controls="hs-scale-animation-modal"
                              data-hs-overlay="#hs-scale-animation-modal"
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
                                  d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                                />
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                />
                              </svg>
                            </button>
                            <button
                              type="button"
                              class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 focus:outline-none focus:text-red-800 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:text-red-400 dark:focus:text-red-400"
                            >
                              Delete
                            </button>
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
                  v-for="(link, index) in links"
                  :key="index"
                  class="border py-2 px-3 text-sm"
                  :class="{ 'bg-blue-500 text-white': link.active }"
                >
                  <span v-html="link.label"></span
                ></Link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- modal area -->
      <div
        id="hs-scale-animation-modal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog"
        tabindex="-1"
        aria-labelledby="hs-scale-animation-modal-label"
      >
        <div
          class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 sm:max-w-2xl sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center"
        >
          <div
            class="w-full flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70"
          >
            <div
              class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700"
            >
              <h3
                id="hs-scale-animation-modal-label"
                class="font-bold text-gray-800 dark:text-white"
              >
                Attendees list
              </h3>
              <button
                type="button"
                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                aria-label="Close"
                data-hs-overlay="#hs-scale-animation-modal"
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
                              Created at
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                          <tr
                            v-for="(attendee, index) in registerEvents"
                            :key="attendee.id"
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
                              {{
                                attendee.register_attendees.created_at.split(
                                  "T"
                                )[0]
                              }}
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
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                data-hs-overlay="#hs-scale-animation-modal"
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
