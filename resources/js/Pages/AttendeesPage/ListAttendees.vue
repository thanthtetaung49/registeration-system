<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({ users: Object });
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
          <div class="border-b border-gray-200 px-4">
            <AttendeesTabLayout></AttendeesTabLayout>

            <div class="mt-5">
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
                              Name
                            </th>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              Age
                            </th>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              Sex
                            </th>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              Phone number
                            </th>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              NRC number
                            </th>
                            <th
                              scope="col"
                              class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                            >
                              Education background
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
                              Address
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
                            v-for="(user, index) in users.data"
                            :key="user.id"
                          >
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ index + 1 }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ user.name }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ user.age }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ user.sex == 0 ? "male" : "female" }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ user.phone_number }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ user.nrc_number }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ user.edu_background }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ user.department }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ user.address }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ user.email }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                            >
                              {{ user.created_at.split("T")[0] }}
                            </td>
                            <td
                              class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium"
                            >
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
                    v-for="(link, index) in users.links"
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
      </div>
    </AuthenticatedLayout>
  </div>
</template>
