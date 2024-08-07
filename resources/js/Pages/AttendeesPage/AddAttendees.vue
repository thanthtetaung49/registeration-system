<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextInputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import defaultImage from "@/images/default_profile.png";
import { defineComponent, onMounted, ref } from "vue";

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
  avatar: null,
  attendees_types_id: "",
  attendees_groups_id: "",
});

defineComponent({ defaultImage });

const props = defineProps({ states: Object, types: Object, groups: Object });

const imageUrl = ref(null);

const previewImage = (event) => {
  form.avatar = event.target.files[0];

  const reader = new FileReader();
  reader.onload = (e) => {
    imageUrl.value = e.target.result;
  };
  reader.readAsDataURL(form.avatar);
};

const saveAttendees = () =>
  form.post("/attendees/create", {
    onSuccess: () => {
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
        "email",
        "avatar",
        "attendees_types_id",
        "attendees_groups_id"
      );
    },
  });

// onMounted(() => {
//   document.addEventListener("keypress", handleKeyDown);
// });

// const handleKeyDown = (event) => {
//   const key = event.key.toLowerCase();

//   const mapElementsToData = (elements) => {
//     return elements.map((element) => ({
//       name: element.name,
//       id: element.id,
//     }));
//   };

//   const attendeesData = mapElementsToData(props.types);
//   const attendeesGroupData = mapElementsToData(props.groups);

//   const findIndexByKey = (data, key) => {
//     const firstLetters = data.map((item) => item.name.charAt(0));
//     return firstLetters.indexOf(key);
//   };

//   const indexType = findIndexByKey(attendeesData, key);
//   const indexGroup = findIndexByKey(attendeesGroupData, key);

//   if (indexType !== -1) {
//     form.attendees_types_id = attendeesData[indexType].id;
//   }

//   if (indexGroup !== -1) {
//     form.attendees_groups_id = attendeesGroupData[indexGroup].id;
//   }

//   if (key === "m") {
//     form.sex = "0";
//   } else if (key === "f") {
//     form.sex = "1";
//   }
// };
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
          <div class="border-b border-gray-200 px-4 pb-10 mb-10">
            <AttendeesTabLayout></AttendeesTabLayout>

            <div class="mt-5">
              <form v-on:submit.prevent="saveAttendees">
                <div class="w-1/3 my-3 flex items-end">
                  <img
                    v-if="imageUrl && imageUrl != null"
                    :src="imageUrl"
                    alt="preview image"
                    class="w-20 rounded-md h-20"
                  />
                  <img
                    v-else
                    :src="defaultImage"
                    alt="default image"
                    class="w-20 rounded-md h-20"
                  />
                  <div class="ms-5">
                    <label
                      for="file-input"
                      class="mt-3 text-blue-700 underline text-sm font-medium"
                      >File upload</label
                    >
                    <input
                      @input="previewImage"
                      type="file"
                      name="import_file"
                      id="file-input"
                      class="hidden w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400 mt-3"
                    />
                    <TextInputError
                      :message="form.errors.avatar"
                    ></TextInputError>
                  </div>
                </div>
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
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Attendees type'"></InputLabel>
                    <select
                      v-model="form.attendees_types_id"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3"
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
                    <TextInputError
                      :message="form.errors.attendees_types_id"
                    ></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="'Attendees group'"></InputLabel>
                    <select
                      v-model="form.attendees_groups_id"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3"
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
