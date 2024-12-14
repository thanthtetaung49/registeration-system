<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/vue3";
import defaultImage from "@/images/default_profile.png";
import axios from "axios";

const props = defineProps({
  users: Object,
});

let users = props.users;
let user;
let baseUrl;
let links = props.users.links;

const userView = (userId) => {
  axios
    .get(`/users/view/${userId}`)
    .then((response) => {
      user = response.data.user;
      baseUrl = response.data.baseUrl;
      console.log(user);
    })
    .catch((error) => console.error(error));
};

const updateUserRole = (userId, role) => {
  axios
    .post(`/users/update/role`, {
      id: userId,
      role: role,
    })
    .then((response) => {})
    .catch((error) => console.error(error));
};
</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
          <header class="mb-10">
            <h3 class="text-gray-800 text-2xl pb-1 bold dark:text-white">
              Users management
            </h3>
            <div class="w-10 h-1 bg-blue-800"></div>
          </header>
          <div
            class="bg-white text-sm overflow-hidden shadow-sm sm:rounded-lg p-10 w-full dark:bg-gray-800 dark:text-white"
          >
            <div class="flex flex-col">
              <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                  <div class="overflow-hidden">
                    <table
                      class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700"
                    >
                      <thead>
                        <tr>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                          >
                            No
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                          >
                            Name
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                          >
                            Age
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                          >
                            Address
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                          >
                            Email
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                          >
                            Role
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                          >
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                        <tr v-for="(user, index) in users.data" :key="user.id">
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200"
                          >
                            {{ index + 1 }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200"
                          >
                            {{ user.name }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                          >
                            {{ user.age }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                          >
                            {{ user.address }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                          >
                            {{ user.email }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                          >
                            <span
                              v-if="user.is_admin == 0"
                              class="text-green-500 bg-green-100 px-3 py-1 rounded"
                              >Attendees</span
                            >
                            <span
                              v-else-if="user.is_admin == 1"
                              class="text-gray-500 bg-gray-100 px-3 py-1 rounded"
                              >Admin</span
                            >
                            <span
                              v-else-if="user.is_admin == 2"
                              class="text-red-500 bg-red-100 px-3 py-1 rounded"
                              >Security</span
                            >
                            <span
                              v-else-if="user.is_admin == 3"
                              class="text-yellow-500 bg-yellow-100 px-3 py-1 rounded"
                              >Self-check in user</span
                            >
                            <span
                              v-else
                              class="text-indigo-500 bg-indigo-100 px-3 py-1 rounded"
                              >Super user</span
                            >
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium"
                          >
                            <button
                              class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-whitedisabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-green-700 hover:text-white"
                              aria-haspopup="dialog"
                              aria-expanded="false"
                              aria-controls="hs-basic-modal"
                              data-hs-overlay="#hs-basic-modal"
                              v-on:click="userView(user.id)"
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
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="flex justify-end w-full">
                    <div class="mb-10 my-5">
                      <Link
                        :href="link.url"
                        v-for="(link, index) in links"
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
          </div>
        </div>
      </div>

      <!-- modal -->

      <div
        id="hs-basic-modal"
        class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none"
        role="dialog"
        tabindex="-1"
        aria-labelledby="hs-basic-modal-label"
      >
        <div class="sm:max-w-2xl sm:w-full m-3 sm:mx-auto">
          <div
            class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70"
          >
            <div
              class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700"
            >
              <h3
                id="hs-basic-modal-label"
                class="font-bold text-gray-800 dark:text-white"
              >
                User Information
              </h3>
              <button
                type="button"
                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                aria-label="Close"
                data-hs-overlay="#hs-basic-modal"
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
            <div class="p-4 overflow-y-auto flex">
              <div class="w-1/2 ps-20 mt-3">
                <img
                  v-if="user?.profile_path"
                  :src="`${baseUrl}/storage/${user?.profile_path}`"
                  alt="preview image"
                  class="w-auto rounded-md"
                />
                <img
                  v-else
                  :src="defaultImage"
                  alt="default image"
                  class="w-auto rounded-md"
                />
              </div>

              <div class="w-1/2">
                <ul v-if="user" class="text-sm text-gray-800 dark:text-white">
                  <li class="my-2">Name - {{ user.name }}</li>
                  <li class="my-2">Email - {{ user.email }}</li>
                  <li class="my-2">Age - {{ user.age }}</li>
                  <li class="my-2">
                    <span v-if="user.sex == 0">Gender - Male</span>
                    <span v-else>Gender - Female</span>
                  </li>
                  <li class="my-2">Phone number - {{ user.phone_number }}</li>
                  <li class="my-2">NRC Number - {{ user.nrc_number }}</li>
                  <li class="my-2">Education background - {{ user.edu_background }}</li>
                  <li class="my-2">Position - {{ user.position }}</li>
                  <li class="my-2">Department - {{ user.department }}</li>
                  <li class="my-2">Address - {{ user.address }}</li>
                  <li class="my-2 pb-2">
                    Role -
                    <span
                      v-if="user.is_admin == 0"
                      class="text-green-500 bg-green-100 px-3 py-1 rounded"
                      >Attendees</span
                    >
                    <span
                      v-else-if="user.is_admin == 1"
                      class="text-gray-500 bg-gray-100 px-3 py-1 rounded"
                      >Admin</span
                    >
                    <span
                      v-else-if="user.is_admin == 2"
                      class="text-red-500 bg-red-100 px-3 py-1 rounded"
                      >Security</span
                    >
                    <span
                      v-else-if="user.is_admin == 3"
                      class="text-yellow-500 bg-yellow-100 px-3 py-1 rounded"
                      >Self-check in user</span
                    >
                    <span v-else class="text-indigo-500 bg-indigo-100 px-3 py-1 rounded"
                      >Super user</span
                    >
                  </li>

                  <li class="my-2 border-t">
                    <h6 class="font-semibold mb-2 mt-4">Update role</h6>
                    <div class="flex">
                      <input
                        type="checkbox"
                        class=""
                        id="attendees"
                        value="0"
                        :checked="user.is_admin == 0"
                        v-on:change="updateUserRole(user.id, 0)"
                      />
                      <label
                        for="attendees"
                        class="text-sm text-gray-500 ms-3 dark:text-neutral-400"
                        >Attendees</label
                      >
                    </div>

                    <div class="flex">
                      <input
                        type="checkbox"
                        class=""
                        id="admin"
                        value="1"
                        :checked="user.is_admin == 1"
                        v-on:change="updateUserRole(user.id, 1)"
                      />
                      <label
                        for="admin"
                        class="text-sm text-gray-500 ms-3 dark:text-neutral-400"
                        >Admin</label
                      >
                    </div>

                    <div class="flex">
                      <input
                        type="checkbox"
                        class=""
                        id="security"
                        value="2"
                        :checked="user.is_admin == 2"
                        v-on:change="updateUserRole(user.id, 2)"
                      />
                      <label
                        for="security"
                        class="text-sm text-gray-500 ms-3 dark:text-neutral-400"
                        >Security</label
                      >
                    </div>

                    <div class="flex">
                      <input
                        type="checkbox"
                        class=""
                        id="selfCheckinUser"
                        value="3"
                        :checked="user.is_admin == 3"
                        v-on:change="updateUserRole(user.id, 3)"
                      />
                      <label
                        for="selfCheckinUser"
                        class="text-sm text-gray-500 ms-3 dark:text-neutral-400"
                        >Self check-in user</label
                      >
                    </div>

                    <div class="flex">
                      <input
                        type="checkbox"
                        class=""
                        id="superAdmin"
                        value="3"
                        :checked="user.is_admin == 4"
                        :disabled="user.is_admin == 4"
                        v-on:change="updateUserRole(user.id, 4)"
                      />
                      <label
                        for="superAdmin"
                        class="text-sm text-gray-500 ms-3 dark:text-neutral-400"
                        >Super Admin</label
                      >
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div
              class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700"
            >
              <button
                type="button"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                data-hs-overlay="#hs-basic-modal"
              >
                Close
              </button>
              <button
                type="button"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
              >
                Save changes
              </button>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
