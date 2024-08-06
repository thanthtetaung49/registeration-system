<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextInputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import defaultImage from "@/images/default_profile.png";
import { defineComponent, ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";

defineComponent({ defaultImage });

const props = defineProps({ user: Object, types: Object, groups: Object });
const user = props.user;

const form = useForm({
  name: user.name,
  age: user.age,
  sex: user.sex,
  phone_number: user.phone_number,
  nrc_number: user.nrc_number,
  edu_background: user.edu_background,
  position: user.position,
  department: user.department,
  address: user.address,
  email: user.email,
  avatar: user.profile_path,
  attendees_types_id:
    props.user.attendees_types !== null ? props.user.attendees_types.id : null,
  attendees_groups_id:
    props.user.attendees_groups !== null
      ? props.user.attendees_groups_id
      : null,
});

const updateAttendees = () => form.post(`/attendees/update/${user.id}`);
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
          <div class="border-b border-gray-200 px-4 py-5 mb-10">
            <div class="mt-5">
              <form v-on:submit.prevent="updateAttendees">
                <div class="w-1/3 my-3 flex items-end">
                  <img
                    v-if="user.profile_path"
                    :src="`http://127.0.0.1:8000/storage/${user.profile_path}`"
                    alt="preview image"
                    class="w-20 rounded-md h-20"
                  />
                  <img
                    v-else
                    :src="defaultImage"
                    alt="preview image"
                    class="w-20 rounded-md h-20"
                  />

                  <div class="ms-5">
                    <label
                      for="file-input"
                      class="mt-3 text-blue-700 underline text-sm font-medium"
                      >File upload</label
                    >
                    <input
                      disabled
                      @input="previewImage"
                      type="file"
                      name="import_file"
                      id="file-input"
                      class="hidden w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400 mt-3"
                    />
                  </div>
                </div>
                <div class="w-full flex">
                  <div class="w-1/3">
                    <InputLabel :value="'Name'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.name"
                      class="w-full mt-3"
                      disabled
                    ></TextInput>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Age'"></InputLabel>
                    <TextInput
                      type="number"
                      v-model="form.age"
                      class="w-full mt-3"
                      disabled
                    ></TextInput>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Sex'"></InputLabel>
                    <select
                      disabled
                      v-model="form.sex"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3"
                    >
                      <option value="" selected="">Open this select sex</option>
                      <option value="0">Male</option>
                      <option value="1">Female</option>
                    </select>
                  </div>
                </div>

                <div class="w-full flex my-3">
                  <div class="w-1/3">
                    <InputLabel :value="'Phone number'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.phone_number"
                      class="w-full mt-3"
                      disabled
                    ></TextInput>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'NRC number'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.nrc_number"
                      class="w-full mt-3"
                      disabled
                    ></TextInput>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Education background'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.edu_background"
                      class="w-full mt-3"
                      disabled
                    ></TextInput>
                  </div>
                </div>

                <div class="w-full flex my-3">
                  <div class="w-1/3">
                    <InputLabel :value="'Positions'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.position"
                      class="w-full mt-3"
                      disabled
                    ></TextInput>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Department'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.department"
                      class="w-full mt-3"
                      disabled
                    ></TextInput>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Address'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.address"
                      class="w-full mt-3"
                      disabled
                    ></TextInput>
                  </div>
                </div>

                <div class="w-full flex my-3">
                  <div class="w-1/3">
                    <InputLabel :value="'Email'"></InputLabel>
                    <TextInput
                      type="email"
                      v-model="form.email"
                      class="w-full mt-3"
                      disabled
                    ></TextInput>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Attendees type'"></InputLabel>
                    <select
                      v-model="form.attendees_types_id"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3"
                      disabled
                    >
                      <option value="" selected="">
                        Open this attendees type
                      </option>

                      <option
                        v-for="type in types"
                        :key="type.id"
                        :value="type.id"
                      >
                        {{ type.name }}
                      </option>
                    </select>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Attendees group'"></InputLabel>
                    <select
                      v-model="form.attendees_groups_id"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3" disabled
                    >
                      <option value="" selected="">
                        Open this attendees group
                      </option>

                      <option
                        v-for="group in groups"
                        :key="group.id"
                        :value="group.id"
                      >
                        {{ group.name }}
                      </option>
                    </select>
                    <TextInputError
                      :message="form.errors.attendees_groups_id"
                    ></TextInputError>
                  </div>
                </div>

                <div class="w-full flex justify-end">
                  <Link
                    href="/attendees/list"
                    class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >Back</Link
                  >
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
