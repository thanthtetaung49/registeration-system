<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EventTabLayout from "@/Layouts/EventTabLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({ registerEvents: Object });
const registerEvents = ref(props.registerEvents);
const query = ref(null);

const searchEvent = () =>
{
    router.visit(`/event/report/search?query=${query.value}`, {
        method: 'get',
        onSuccess: (page) =>
        {
            registerEvents.value = page.props.registerEvents;
            console.log(registerEvents);
        }
    })
  axios
    .get(`/event/report/search?query=${query.value}`)
    .then((response) => {
      registerEvents.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
};

const excelExport = () =>
{
    window.location.href = '/event/report/checkin/excel/export';
}
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

            <div class="flex justify-end mt-5">
                <button
                type="button"
                v-on:click="excelExport"
                class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3"
              >
                Excel
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="size-5 ms-2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"
                  />
                </svg>
              </button>

              <div class="relative">
                <TextInput
                  v-model="query"
                  @keydown.enter="searchEvent"
                  placeholder="Search attendees..."
                  class="text-sm"
                ></TextInput>
                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-5"
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
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            Attendees name
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            Attendees type
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                          >
                            Check in time
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200">
                        <tr
                          v-for="(event, index) in registerEvents.data"
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
                            {{ event.events.event_name }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                          >
                            {{ event.register_attendees.name }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                          >
                            <span v-if="event.attendees_types">{{
                              event.attendees_types.name
                            }}</span>
                            <span v-else>-</span>
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                          >
                            <span v-if="event.scan_time">{{
                              event.scan_time
                            }}</span>
                            <span
                              v-else
                              class="text-xs bg-red-100 text-red-900 px-3 py-1 rounded-sm"
                              >Not check in</span
                            >
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
                  v-for="(link, index) in registerEvents.links"
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
    </AuthenticatedLayout>
  </div>
</template>
