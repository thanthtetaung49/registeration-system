<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CategoryForm from "@/Components/EventCategoriesForm.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import { Link } from "@inertiajs/vue3";

import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: null,
});

const saveAttendeesGroup = () =>
    form.post("/attendees/group/create", {
        onSuccess: () => form.reset("name"),
    });

const props = defineProps({
    groups: Object,
});
</script>

<template>
    <div>
        <AuthenticatedLayout>
            <div class="px-10 py-10">
                <header class="mb-10">
                    <h3 class="text-gray-800 text-2xl pb-1 bold dark:text-white">
                        Attendees group
                    </h3>
                    <div class="w-10 h-1 bg-blue-800"></div>
                </header>

                <div class="w-full bg-white rounded-lg shadow-md dark:text-white dark:bg-gray-800">
                    <div class="border-b border-gray-200 dark:border-none px-4">
                        <AttendeesTabLayout></AttendeesTabLayout>

                        <div class="mt-5">
                            <form v-on:submit.prevent="saveAttendeesGroup">
                                <div>
                                    <InputLabel
                                        :value="'Attendees group'"
                                    ></InputLabel>
                                    <TextInput
                                        v-model="form.name"
                                        class="mt-3 w-[30%] text-sm"
                                    ></TextInput>
                                    <InputError
                                        :message="form.errors.name"
                                    ></InputError>
                                </div>
                                <div class="mt-5 w-full flex justify-end">
                                    <PrimaryButton type="submit" class=""
                                        >Save</PrimaryButton
                                    >
                                </div>
                            </form>
                        </div>

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
                                                        Attendees type
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
                                                        group, index
                                                    ) in groups.data"
                                                    :key="group.id"
                                                >
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                                                    >
                                                        {{ index + 1 }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                                                    >
                                                        {{ group.name }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white"
                                                    >
                                                        {{
                                                            group.created_at.split(
                                                                "T"
                                                            )[0]
                                                        }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium"
                                                    >
                                                        <Link
                                                            :href="`/attendees/group/view/${group.id}`"
                                                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-whitedisabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-green-700 hover:text-white"
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
                                                            :href="`/attendees/group/edit/${group.id}`"
                                                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-whitedisabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-gray-700 hover:text-white"
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
                                                            :href="`/attendees/group/delete/${group.id}`"
                                                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border text-gray-600 focus:outline-none focus:text-whitedisabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400 p-2 mr-3 hover:bg-red-700 hover:text-white"
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
                                    v-for="(link, index) in groups.links"
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
        </AuthenticatedLayout>
    </div>
</template>
