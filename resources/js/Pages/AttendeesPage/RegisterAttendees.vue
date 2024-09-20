<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
  users: Object,
  events: Object,
  message: String,
  groups: Object,
  groupId: String,
  eventsId: String,
});

const users = ref(props.users);
const status = ref(false);
const checkBoxAll = ref(null);
const query = ref(null);
const input = ref(null);

const form = useForm({
  users_id: [],
  events_id: props.eventsId ? props.eventsId : "",
  attendees_groups_id: props.groupId ? props.groupId : "",
});

const registerEvent = () => {
  const checkBoxes = document.querySelectorAll(".checkBoxes");

  form.post("/attendees/event/register", {
    onSuccess: () => {
      status.value = true;
      setInterval(() => {
        status.value = false;
      }, 5000);

      form.users_id = [];
      form.events_id = "";

      window.location.href = "/attendees/register";
    },
  });

  checkBoxAll.value.checked = false;
  checkBoxes.forEach((checkBox) => {
    checkBox.checked = false;
  });
};

const handleCheckboxChange = (event) => {
  const id = event.target.value;

  if (event.target.checked) {
    form.users_id.push(id);
  } else {
    const index = form.users_id.indexOf(id);

    if (index > -1) {
      form.users_id.splice(index, 1);
    }
  }
};

const handleSelectAllChackBoxChange = (users) => {
  const checkBoxes = document.querySelectorAll(".checkBoxes");

  if (checkBoxAll.value.checked) {
    checkBoxes.forEach((checkBox) => {
      checkBox.checked = true;
    });

    users.data.forEach((user) => {
      form.users_id.push(user.id);
    });
  } else {
    checkBoxes.forEach((checkBox) => {
      checkBox.checked = false;
    });

    form.users_id = [];
  }
};

const filter = () => {
  router.get("/attendees/event/register/filter", {
    data: {
      attendeesGroupId: form.attendees_groups_id,
    },
    method: "get",
    onSuccess: (page) => {
      users.value = page.props.users;
      console.log(form.users_id);
    },
  });
};

const excelExport = () => {
  window.location.href = `/attendees/event/registerAttendees/Export`;
};

const searchUser = () => {
  router.visit(`/attendees/event/register/search`, {
    method: "get",
    data: {
      query: query.value,
    },
    onSuccess: (page) => {
      users.value = page.props.users;
      console.log(users.value);
    },
  });
};

// onMounted(() => {
//     input.value.focus();
// });
</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="px-10 py-5">
        <Transition name="slide-fade">
          <div
            v-if="status"
            class="text-xs bg-green-500 block fixed right-10 top-20 z-10 text-white px-3 py-4 rounded-md"
          >
            Event registration is successfully.
          </div>
        </Transition>

        <header class="mb-10">
          <h3 class="text-gray-800 text-2xl pb-1 bold dark:text-white">Attendees</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>

        <div class="w-full bg-white shadow-md mb-20 dark:bg-gray-800">
          <div class="border-b border-gray-200 dark:border-none px-4">
            <AttendeesTabLayout></AttendeesTabLayout>

            <!-- <div class="flex w-full justify-end">
                            <div class="relative w-1/4 ms-3">
                                <label
                                    for="hs-table-input-search"
                                    class="sr-only"
                                    >Search</label
                                >
                                <input
                                    ref="input"
                                    v-model="query"
                                    @keydown.enter="searchUser"
                                    type="text"
                                    name="hs-table-search"
                                    id="hs-table-input-search"
                                    class="p-3 ps-9 block w-full border-gray-200 dark:border-none shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="Search for items"
                                    data-hs-datatable-search=""
                                />
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3"
                                >
                                    <svg
                                        class="size-4 text-gray-400 dark:text-neutral-500"
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
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                </div>
                            </div>
                        </div> -->

            <div class="">
              <InputError :message="form.errors.attendees_groups_id"></InputError>
              <InputError :message="form.errors.events_id"></InputError>
              <InputError :message="form.errors.users_id"></InputError>

              <form v-on:submit.prevent="registerEvent">
                <div class="w-full flex items-center mt-5">
                  <div class="w-1/3 ms-3">
                    <select
                      class="hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 dark:border-none rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600"
                      v-model="form.attendees_groups_id"
                      @change="filter"
                    >
                      <option value="">Choose attendees group</option>
                      <option v-for="group in groups" :key="group.id" :value="group.id">
                        {{ group.name }}
                      </option>
                    </select>
                  </div>

                  <div class="w-1/3 ms-3">
                    <select
                      data-hs-select='{
                    "hasSearch": true,
                    "searchPlaceholder": "Search...",
                    "searchClasses": "block w-full text-sm border-gray-200 dark:border-none rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                    "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                    "placeholder": "Select event...",
                    "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200 \" data-title></span></button>",
                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 dark:border-none rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600 w-[250px]",
                    "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 dark:border-none rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                    "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
                    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                    }'
                      class="hidden"
                      v-model="form.events_id"
                    >
                      <option value="">Choose events</option>
                      <option v-for="event in events" :key="event.id" :value="event.id">
                        {{ event.event_name }}
                      </option>
                    </select>
                  </div>

                  <div class="w-1/3 ms-5 inline-flex">
                    <button
                      type="button"
                      v-on:click="excelExport"
                      class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
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
                    <PrimaryButton type="submit" class="ms-3">Save</PrimaryButton>
                  </div>
                </div>
                <div class="w-full flex justify-end mt-5"></div>
              </form>
            </div>

            <div class="">
              <div class="flex flex-col">
                <div class="overflow-x-auto">
                  <div class="min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                      <table class="min-w-full">
                        <thead class="border-b border-gray-200 dark:border-none">
                          <tr>
                            <th scope="col" class="py-1 ps-3 --exclude-from-ordering">
                              <div class="flex items-center h-5">
                                <input
                                  :disabled="!form.attendees_groups_id || !form.events_id"
                                  ref="checkBoxAll"
                                  @change="handleSelectAllChackBoxChange(users)"
                                  id="hs-table-checkbox-all"
                                  type="checkbox"
                                  class="border-gray-300 rounded text-blue-600 focus:ring-blue-500"
                                />
                                <label for="hs-table-checkbox-all" class="sr-only"
                                  >Checkbox</label
                                >
                              </div>
                            </th>

                            <th
                              scope="col"
                              class="py-1 group text-start font-normal focus:outline-none"
                            >
                              <div
                                class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:border-none"
                              >
                                Name
                              </div>
                            </th>

                            <th
                              scope="col"
                              class="py-1 group text-start font-normal focus:outline-none"
                            >
                              <div
                                class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:border-none"
                              >
                                Attendees group
                              </div>
                            </th>

                            <th
                              scope="col"
                              class="py-1 group text-start font-normal focus:outline-none"
                            >
                              <div
                                class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:border-none"
                              >
                                Phone number
                              </div>
                            </th>

                            <th
                              scope="col"
                              class="py-1 group text-start font-normal focus:outline-none"
                            >
                              <div
                                class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:border-none"
                              >
                                Email
                              </div>
                            </th>

                            <th
                              scope="col"
                              class="py-1 group text-start font-normal focus:outline-none"
                            >
                              <div
                                class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:border-none"
                              >
                                created_at
                              </div>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200" id="tableBody">
                          <tr v-for="user in users.data" :key="user.id">
                            <td class="py-3 ps-3">
                              <input
                                :disabled="!form.attendees_groups_id || !form.events_id"
                                :value="user.id"
                                :id="`hs-table-checkbox-${user.id}`"
                                type="checkbox"
                                class="border-gray-300 checkBoxes rounded text-blue-600 focus:ring-blue-500"
                                data-hs-datatable-row-selecting-individual=""
                                @change="handleCheckboxChange"
                              />
                            </td>
                            <td
                              class="p-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                            >
                              {{ user.name }}
                            </td>
                            <td
                              class="p-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                            >
                              {{ user.attendees_groups.name }}
                            </td>
                            <td
                              class="p-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                            >
                              {{ user.phone_number }}
                            </td>
                            <td
                              class="p-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                            >
                              {{ user.email }}
                            </td>

                            <td
                              class="p-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                            >
                              {{ user.created_at.split("T")[0] }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="flex justify-end w-full">
                  <div class="mb-7 my-5">
                    <Link
                      :href="`${link.url}&data[attendeesGroupId]=${form.attendees_groups_id}&data[eventsId]=${form.events_id}`"
                      v-for="(link, index) in users.links"
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
    </AuthenticatedLayout>
  </div>
</template>

<style>
.dt-layout-row:has(.dt-search),
.dt-layout-row:has(.dt-length),
.dt-layout-row:has(.dt-paging) {
  display: none !important;
}

.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>
