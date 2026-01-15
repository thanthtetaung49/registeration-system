<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import defaultImage from "@/images/default_profile.png";
import axios from "axios";
import SuccessAlert from "@/Components/SuccessAlert.vue";
import { onMounted, onUpdated, ref } from "vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  users: Object,
  superAdmin: Number
});

let superAdmin = props.superAdmin;
let users = props.users;
let user = ref(null);
let baseUrl;
let links = props.users.links;
let showAlertStatus = ref(false);
let input = ref(null);
let query = ref(null);
const page = usePage();
const l = page.props.language;

const userView = (userId) => {
  axios
    .get(`/users/view/${userId}`)
    .then((response) => {
      user.value = response.data.user;
    })
    .catch((error) => console.error(error));
};

const updateUserRole = (userId, role) => {
  const data = {
    id: userId,
    role: role,
  };

  axios
    .post(`/users/role/update`, data)
    .then((response) => {
      user.value = response.data.user;

      console.log(user.value);

      showAlertStatus.value = true;

      setTimeout(() => {
        showAlertStatus.value = false;
      }, 5000);
    })
    .catch((err) => console.error(err));
};

const accountDisabled = () => {
  let message = "Are you sure want to disable this user account?";
  let url = "/users/user/diabled";
  accountActivateAndDisable(message, url);
};

const accountActivate = () => {
  let message = "Are you sure want to activate this user account?";
  let url = "/users/user/activate";
  accountActivateAndDisable(message, url);
};

const accountDelete = () => {
  let message = "Are you sure want to delete this user account?";
  let url = "/users/user/delete";
  accountActivateAndDisable(message, url);
};

const accountActivateAndDisable = (message, url) => {
  const userConfirmation = window.confirm(message);

  let userId = user.value.id;

  if (userConfirmation) {
    axios
      .post(url, {
        userId: userId,
      })
      .then(() => {
        window.location.href = "/users";
      })
      .catch((error) => console.error(error));
  } else {
    console.log('user clicked cancel button.');
  }
};

const searchUser = () => {

  router.visit(`/users/search`, {
    method: "get",
    data: {
      query: query.value,
    },
    onSuccess: (page) => {
      console.log("Success");
    },
  });
}

onMounted(() => {
  input.value.focus();
})
</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
          <header class="mb-5">
            <h3 class="text-gray-800 text-2xl pb-1 bold dark:text-white">
              {{ l.users.title }}
            </h3>
            <div class="w-10 h-1 bg-blue-800"></div>
          </header>

          <div class="mb-5">
            <div class="flex justify-end mt-5">
              <div class="relative">
                <TextInput ref="input" v-model="query" :placeholder="l.users.searchPlaceholder"
                  @keydown.enter="searchUser" class="text-sm"></TextInput>
                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4 dark:text-white">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
          <div
            class="bg-white text-sm overflow-hidden shadow-sm sm:rounded-lg p-10 w-full dark:bg-gray-800 dark:text-white">
            <div class="flex flex-col">
              <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                  <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                      <thead>
                        <tr>
                          <th scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                            {{ l.users.table.no }}
                          </th>
                          <th scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                            {{ l.users.table.name }}
                          </th>
                          <th scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                            {{ l.users.table.age }}
                          </th>
                          <th scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                            {{ l.users.table.address }}
                          </th>
                          <th scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                            {{ l.users.table.email }}
                          </th>
                          <th scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                            {{ l.users.table.role }}
                          </th>
                          <th scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                            {{ l.users.table.accountStatus }}
                          </th>
                          <th scope="col"
                            class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                            {{ l.users.table.actions }}
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                        <tr v-for="(user, index) in users.data" :key="user.id">
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                            {{ index + 1 }}
                          </td>
                          <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                            {{ user.name }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                            {{ user.age }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                            {{ user.address }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                            {{ user.email }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                            <span v-if="user.is_admin == 0"
                              class="text-green-500 bg-green-100 px-3 py-1 rounded">Attendees</span>
                            <span v-else-if="user.is_admin == 1"
                              class="text-gray-500 bg-gray-100 px-3 py-1 rounded">Admin</span>
                            <span v-else-if="user.is_admin == 2"
                              class="text-red-500 bg-red-100 px-3 py-1 rounded">Security</span>
                            <span v-else-if="user.is_admin == 3"
                              class="text-yellow-500 bg-yellow-100 px-3 py-1 rounded">Self-check in user</span>
                            <span v-else class="text-indigo-500 bg-indigo-100 px-3 py-1 rounded">Super user</span>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                            <span v-if="user.disable_status == 1"
                              class="text-red-100 bg-red-500 rounded px-4 py-1 text-sm">Disabled</span>
                            <span v-else class="text-green-100 bg-green-500 rounded px-4 py-1 text-sm">Active</span>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                            <button
                              class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-whitedisabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-green-700 hover:text-white"
                              aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-large-modal"
                              data-hs-overlay="#hs-large-modal" v-on:click="userView(user.id)">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                              </svg>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="flex justify-end w-full">
                    <div class="mb-10 my-5">
                      <Link :href="link.url" v-for="(link, index) in links" :key="index"
                        class="border py-2 px-3 text-sm dark:text-white" :class="{
                          'bg-blue-500 text-white': link.active,
                        }">
                        <span v-html="link.label"></span>
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- modal -->

      <div id="hs-large-modal"
        class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="hs-large-modal-label">
        <!-- alert -->
        <div v-if="showAlertStatus" id="alertContainer" class="w-72 absolute right-5 top-5 z-50">
          <SuccessAlert v-if="user?.is_admin === 0" :message="`Role Change to Attendees.`"></SuccessAlert>
          <SuccessAlert v-else-if="user?.is_admin === 1" :message="`Role Change to Admin.`"></SuccessAlert>
          <SuccessAlert v-else-if="user?.is_admin === 2" :message="`Role Change to Security.`"></SuccessAlert>
          <SuccessAlert v-else-if="user?.is_admin === 3" :message="`Role Change to Self Check-in User.`"></SuccessAlert>
          <SuccessAlert v-else :message="`Role Change to Super Admin.`"></SuccessAlert>
        </div>

        <div class="sm:max-w-5xl sm:w-full m-3 sm:mx-auto">
          <div
            class="flex flex-col bg-white border border-gray-100 shadow-2xl rounded-3xl pointer-events-auto dark:bg-neutral-900 dark:border-neutral-800">

            <div class="flex justify-between items-center py-4 px-6 border-b border-gray-50 dark:border-neutral-800">
              <h3 id="hs-basic-modal-label" class="text-xl font-extrabold text-gray-800 dark:text-white tracking-tight">
                {{ l.users.userProfile }}
              </h3>
              <button type="button"
                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                aria-label="Close" data-hs-overlay="#hs-large-modal">
                <span class="sr-only">Close</span>
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>

            </div>

            <div v-if="user" class="p-6 overflow-y-auto">
              <div v-if="superAdmin == 4" class="flex justify-end gap-x-2 mb-6">

                <button v-on:click="accountDisabled" type="button"
                  class="p-2 rounded-xl bg-red-50 text-red-500 hover:bg-red-100 transition dark:bg-red-900/20 hs-tooltip-toggle flex items-center"><svg
                    class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path
                      d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25Z" />
                  </svg>
                  <div class="text-xs ms-2">{{ l.users.button.accountDisabled }}</div>
                </button>

                <button v-on:click="accountActivate" type="button"
                  class="p-2 rounded-xl bg-green-50 text-green-500 hover:bg-green-100 transition dark:bg-green-900/20 flex items-center"><svg
                    class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path
                      d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                  </svg>
                  <div class="text-xs ms-2">{{ l.users.button.accountActive }}</div>
                </button>

                <button v-on:click="accountDelete" type="button"
                  class="p-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition dark:bg-red-900/20 flex items-center"><svg
                    class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path
                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 01 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                  </svg>
                  <div class="text-xs ms-2">{{ l.users.button.accountDeleted }}</div>
                </button>
              </div>

              <div class="flex flex-col md:flex-row gap-10">
                <div class="w-full md:w-1/3 flex flex-col items-center">
                  <div class="relative group">
                    <div
                      class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-1000">
                    </div>
                    <img :src="user?.profile_path ? `${baseUrl}/storage/${user?.profile_path}` : defaultImage"
                      class="relative w-52 h-52 object-cover rounded-3xl border-4 border-white shadow-sm" alt="Profile">
                    <div
                      class="absolute -bottom-3 left-1/2 -translate-x-1/2 px-4 py-2 bg-indigo-600 text-white text-[10px] font-black uppercase rounded-full shadow-lg w-3/4 text-center">
                      <span v-if="user?.is_admin == 0">{{ l.roles.attendees }}</span>
                      <span v-else-if="user?.is_admin == 1">{{ l.roles.admin }}</span>
                      <span v-else-if="user?.is_admin == 2">{{ l.roles.security }}</span>
                      <span v-else-if="user?.is_admin == 3">{{ l.roles.selfCheckinUser }}</span>
                      <span v-else>{{ l.roles.superAdmin }}</span>
                    </div>
                  </div>
                </div>

                <div class="w-full md:w-2/3 space-y-6">
                  <div>
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white">{{ user?.name || 'Test 2' }}</h2>
                    <p class="text-sm text-gray-400 font-medium">{{ user?.email }}</p>
                  </div>

                  <div class="grid grid-cols-2 gap-y-4 gap-x-6 border-t border-gray-50 pt-6 dark:border-neutral-800">
                    <div
                      v-for="(val, label) in { 'Age': user?.age, 'Gender': user?.sex, 'Phone': user?.phone_number, 'NRC': user?.nrc_number, 'Dept': user?.department, 'Position': user?.position, 'Address': user?.address }"
                      :key="label">
                      <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-0.5">{{ label }}</p>
                      <p class="text-sm font-bold text-gray-700 dark:text-neutral-300">{{ val || '-' }}</p>
                    </div>
                  </div>

                  <div class="bg-gray-50 p-4 rounded-2xl dark:bg-neutral-800/50">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Update Role</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                      <label
                        v-for="(r, index) in [l.roles.attendees, l.roles.admin, l.roles.security, l.roles.selfCheckinUser, l.roles.superAdmin]"
                        :key="r" class="cursor-pointer group">
                        <input type="checkbox" class="peer hidden" :checked="user?.is_admin === index"
                          @change="updateUserRole(user.id, index)">
                        <span
                          class="px-4 py-1.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-500 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-all hover:bg-gray-100">{{
                            r }} </span>
                      </label>
                    </div>
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
