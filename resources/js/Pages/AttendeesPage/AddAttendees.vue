<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextInputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  name: null,
  age: null,
  sex: "",
  phone_number: null,
  nrc_number: null,
  edu_background: null,
  position: null,
  department: null,
  address: null,
  email: null,
});

const props = defineProps({ states: Object });

const saveAttendees = () =>
  form.post("/attendees/create", {
    onSuccess: () =>
      form.reset(
        "name",
        "age",
        "sex",
        "phone_number",
        "nrc_number",
        "edu_background",
        "position",
        "department",
        "address",
        "email"
      ),
  });
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
          <div class="border-b border-gray-200 px-4 py-10 mb-10">
            <AttendeesTabLayout></AttendeesTabLayout>

            <div class="mt-5">
              <form v-on:submit.prevent="saveAttendees">
                <div class="w-full flex">
                  <div class="w-1/3">
                    <InputLabel :value="'Name'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.name"
                      class="w-full mt-3"
                    ></TextInput>
                    <TextInputError
                      :message="form.errors.name"
                    ></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Age'"></InputLabel>
                    <TextInput
                      type="number"
                      v-model="form.age"
                      class="w-full mt-3"
                    ></TextInput>
                    <TextInputError :message="form.errors.age"></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Sex'"></InputLabel>
                    <select
                      v-model="form.sex"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3"
                    >
                      <option value="" selected="">Open this select sex</option>
                      <option value="0">Male</option>
                      <option value="1">Female</option>
                    </select>
                    <TextInputError
                      :message="form.errors.name"
                    ></TextInputError>
                  </div>
                </div>

                <div class="w-full flex my-3">
                  <div class="w-1/3">
                    <InputLabel :value="'Phone number'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.phone_number"
                      class="w-full mt-3"
                    ></TextInput>
                    <TextInputError
                      :message="form.errors.phone_number"
                    ></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'NRC number'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.nrc_number"
                      class="w-full mt-3"
                    ></TextInput>
                    <TextInputError
                      :message="form.errors.nrc_number"
                    ></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Education background'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.edu_background"
                      class="w-full mt-3"
                    ></TextInput>
                    <TextInputError
                      :message="form.errors.edu_background"
                    ></TextInputError>
                  </div>
                </div>

                <div class="w-full flex my-3">
                  <div class="w-1/3">
                    <InputLabel :value="'Positions'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.position"
                      class="w-full mt-3"
                    ></TextInput>
                    <TextInputError
                      :message="form.errors.position"
                    ></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Department'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.department"
                      class="w-full mt-3"
                    ></TextInput>
                    <TextInputError
                      :message="form.errors.department"
                    ></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Address'"></InputLabel>
                    <TextInput
                      type="text"
                      v-model="form.address"
                      class="w-full mt-3"
                    ></TextInput>
                    <TextInputError
                      :message="form.errors.address"
                    ></TextInputError>
                  </div>
                </div>

                <div class="w-full flex my-3">
                  <div class="w-1/3">
                    <InputLabel :value="'Email'"></InputLabel>
                    <TextInput
                      type="email"
                      v-model="form.email"
                      class="w-full mt-3"
                    ></TextInput>
                    <TextInputError
                      :message="form.errors.email"
                    ></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3"></div>
                </div>

                <div class="w-full flex justify-end">
                  <PrimaryButton type="submit">Save</PrimaryButton>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
