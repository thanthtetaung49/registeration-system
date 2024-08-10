<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import { onMounted, ref } from "vue";

const props = defineProps({ users: Object });

const userData = ref(props.users.data);
const userLink = ref(props.users.links);
const query = ref(null);
const duplicate = ref(null);
const input = ref(null);

onMounted(() =>
{
    input.value.focus();
});

const searchAttendees = () => {
    router.visit(`/attendees/search?query=${query.value}`, {
        method: "get",
        onSuccess: (page) => {
            userData.value = page.props.users.data;
            userLink.value = page.props.users.links;
        },
    });
};

const duplicateCheck = () => {
    router.get("/attendees/duplicate/check", {
        data: duplicate.value,
        method: "get",
        onSuccess: (page) => {
            console.log(page.props);
        },
    });
};

const excelExport = () => {
    window.location.href = "/attendees/list/excel/export";
};

const csvExport = () => {
    window.location.href = "/attendees/list/csv/export";
};
</script>

<template>
    <div>
        <AuthenticatedLayout>
            <div class="px-10 py-10">
                <header class="mb-10">
                    <h3 class="text-gray-800 text-2xl pb-1 bold">Attendees</h3>
                    <div class="w-10 h-1 bg-blue-800"></div>
                </header>

                <div class="w-full bg-white rounded-lg shadow-md">
                    <div class="border-b border-gray-200 px-4">
                        <AttendeesTabLayout></AttendeesTabLayout>

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

                            <button
                                type="button"
                                v-on:click="csvExport"
                                class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3"
                            >
                                CSV
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

                            <!-- Select -->
                            <!-- <select
                                data-hs-select='{
  "placeholder": "Select option...",
  "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
  "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
  "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
}'
                                class="hidden"
                                @change="duplicateCheck"
                                v-model="duplicate"
                            >
                                <option value="">select duplicate check</option>
                                <option value="name">Name</option>
                                <option value="age">Age</option>
                                <option value="phone_number">
                                    Phone number
                                </option>
                                <option value="email">Email</option>
                            </select> -->
                            <!-- End Select -->



                            <div class="relative ms-3">
                                <TextInput
                                    ref="input"
                                    v-model="query"
                                    @keydown.enter="searchAttendees"
                                    placeholder="Search attendees..."
                                    class="text-sm"
                                ></TextInput>
                                <div
                                    class="absolute right-3 top-1/2 -translate-y-1/2"
                                >
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

                        <div class="mt-5">
                            <div class="flex flex-col mt-5">
                                <div class="-m-1.5 overflow-x-auto">
                                    <div
                                        class="p-1.5 min-w-full inline-block align-middle"
                                    >
                                        <div class="overflow-hidden">
                                            <table
                                                class="min-w-full divide-y divide-gray-200"
                                            >
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
                                                            Attendees type
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                                                        >
                                                            Attendees group
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
                                                <tbody
                                                    class="divide-y divide-gray-200"
                                                >
                                                    <tr
                                                        v-for="(
                                                            user, index
                                                        ) in userData"
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
                                                            {{
                                                                user.sex == 0
                                                                    ? "male"
                                                                    : "female"
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                                                        >
                                                            {{
                                                                user.phone_number
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                                                        >
                                                            {{
                                                                user.nrc_number
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                                                        >
                                                            {{
                                                                user.edu_background
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                                                        >
                                                            {{
                                                                user.department
                                                            }}
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
                                                            <span
                                                                v-if="
                                                                    user.attendees_types
                                                                "
                                                                class="text-green-900 px-3 py-1 rounded-md bg-green-100 inline-block"
                                                            >
                                                                {{
                                                                    user
                                                                        .attendees_types
                                                                        .name
                                                                }}
                                                            </span>
                                                            <span
                                                                v-else
                                                                class="text-red-900 px-3 py-1 rounded-md bg-red-100 inline-block"
                                                                >-</span
                                                            >
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                                                        >
                                                            <span
                                                                v-if="
                                                                    user.attendees_groups
                                                                "
                                                                class="text-green-900 px-3 py-1 rounded-md bg-green-100 inline-block"
                                                            >
                                                                {{
                                                                    user
                                                                        .attendees_groups
                                                                        .name
                                                                }}
                                                            </span>
                                                            <span
                                                                v-else
                                                                class="text-red-900 px-3 py-1 rounded-md bg-red-100 inline-block"
                                                                >-</span
                                                            >
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                                                        >
                                                            {{
                                                                user.created_at.split(
                                                                    "T"
                                                                )[0]
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium"
                                                        >
                                                            <Link
                                                                :href="`/attendees/view/${user.id}`"
                                                                class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-green-700 hover:text-white"
                                                                aria-haspopup="dialog"
                                                                aria-expanded="false"
                                                                aria-controls="hs-scale-animation-modal"
                                                                data-hs-overlay="#hs-scale-animation-modal"
                                                                v-on:click="
                                                                    getRegisterAttendees(
                                                                        event.id
                                                                    )
                                                                "
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

                                                            <Link
                                                                :href="`/attendees/edit/${user.id}`"
                                                                class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-gray-700 hover:text-white"
                                                                aria-haspopup="dialog"
                                                                aria-expanded="false"
                                                                aria-controls="hs-scale-animation-modal"
                                                                data-hs-overlay="#hs-scale-animation-modal"
                                                                v-on:click="
                                                                    getRegisterAttendees(
                                                                        event.id
                                                                    )
                                                                "
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

                                                            <Link
                                                                :href="`/attendees/delete/${user.id}`"
                                                                class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-red-700 hover:text-white"
                                                                aria-haspopup="dialog"
                                                                aria-expanded="false"
                                                                aria-controls="hs-scale-animation-modal"
                                                                data-hs-overlay="#hs-scale-animation-modal"
                                                                v-on:click="
                                                                    getRegisterAttendees(
                                                                        event.id
                                                                    )
                                                                "
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
                                        v-for="(link, index) in userLink"
                                        :key="index"
                                        class="border py-2 px-3 text-sm"
                                        :class="{
                                            'bg-blue-500 text-white':
                                                link.active,
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
        </AuthenticatedLayout>
    </div>
</template>
