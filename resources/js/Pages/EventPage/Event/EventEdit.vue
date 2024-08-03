<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
  event: Object,
  instructors: Object,
  categories: Object,
  rooms: Object,
});

const event = props.event;

console.log(event);

const form = useForm({
  event_name: event.event_name,
  description: event.description,
  location: event.location,
  credits: event.credits,
  lead_instructors_id: event.lead_instructors_id,
  assist_instructors_id: event.assist_instructors_id,
  categories_id: event.categories_id,
  max_seats: event.max_seats,
  event_reference_id: event.event_reference_id,
  start_date: event.start_date,
  end_date: event.end_date,
  start_time: event.start_time,
  end_time: event.end_time,
  early_attendance_min: event.early_attendance_min,
  late_attendance_min: event.late_attendance_min,
  room_numbers_id: event.room_numbers_id,
});

const updateEvent = () => form.post(`/event/list/update/${event.id}`);
</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="px-10 py-10">
        <header class="mb-10">
          <h3 class="text-gray-800 text-2xl pb-1 bold">Event edit</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>
        <div class="w-full bg-white rounded-lg shadow-md">
          <div class="border-b border-gray-200 px-4 py-5 mb-10">
            <div class="my-5">
              <form v-on:submit.prevent="updateEvent">
                <div class="w-full flex">
                  <div class="w-1/3">
                    <InputLabel :value="'Event name'"></InputLabel>
                    <TextInput
                      v-model="form.event_name"
                      class="mt-3 w-full"
                    ></TextInput>
                    <InputError :message="form.errors.event_name"></InputError>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="'Location'"></InputLabel>
                    <TextInput
                      v-model="form.location"
                      class="mt-3 w-full"
                    ></TextInput>
                    <InputError :message="form.errors.location"></InputError>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel
                      :value="'Credits (e.g. 10.50, 0.50)'"
                    ></InputLabel>
                    <TextInput
                      v-model="form.credits"
                      class="mt-3 w-full"
                    ></TextInput>
                    <InputError :message="form.errors.credits"></InputError>
                  </div>
                </div>

                <div class="w-full flex my-5">
                  <div class="w-1/3">
                    <InputLabel :value="'Lead instructor'"></InputLabel>
                    <select
                      v-model="form.lead_instructors_id"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3"
                    >
                      <option value="" selected="">
                        Open this select lead instructor
                      </option>
                      <option
                        v-for="instructor in instructors"
                        :key="instructor.id"
                        :value="instructor.id"
                      >
                        {{ instructor.name }}
                      </option>
                    </select>
                    <InputError
                      :message="form.errors.lead_instructors_id"
                    ></InputError>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="'Assist instructor'"></InputLabel>
                    <select
                      v-model="form.assist_instructors_id"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3"
                    >
                      <option value="" selected="">
                        Open this select assist instructor
                      </option>
                      <option
                        v-for="instructor in instructors"
                        :key="instructor.id"
                        :value="instructor.id"
                      >
                        {{ instructor.name }}
                      </option>
                    </select>
                    <InputError
                      :message="form.errors.assist_instructors_id"
                    ></InputError>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="'Categories'"></InputLabel>
                    <select
                      v-model="form.categories_id"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3"
                    >
                      <option value="" selected="">
                        Open this select categories
                      </option>
                      <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                      >
                        {{ category.category_name }}
                      </option>
                    </select>
                    <InputError
                      :message="form.errors.categories_id"
                    ></InputError>
                  </div>
                </div>

                <div class="w-full flex my-5">
                  <div class="w-1/3">
                    <InputLabel :value="'Maximum seats'"></InputLabel>
                    <TextInput
                      type="number"
                      v-model="form.max_seats"
                      class="mt-3 w-full"
                    ></TextInput>
                    <InputError :message="form.errors.max_seats"></InputError>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="'Event reference id'"></InputLabel>
                    <TextInput
                      type="number"
                      v-model="form.event_reference_id"
                      class="mt-3 w-full"
                    ></TextInput>
                    <InputError
                      :message="form.errors.event_reference_id"
                    ></InputError>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="'Room number'"></InputLabel>
                    <select
                      v-model="form.room_numbers_id"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3"
                    >
                      <option value="" selected="">
                        Open this select room number
                      </option>
                      <option
                        v-for="room in rooms"
                        :key="room.id"
                        :value="room.id"
                      >
                        {{ room.room_number }}
                      </option>
                    </select>
                    <InputError
                      :message="form.errors.room_numbers_id"
                    ></InputError>
                  </div>
                </div>

                <div class="w-full flex my-5">
                  <div class="w-1/4">
                    <InputLabel :value="'Start date'"></InputLabel>
                    <TextInput
                      type="date"
                      v-model="form.start_date"
                      class="mt-3 w-full"
                    ></TextInput>
                    <InputError :message="form.errors.start_date"></InputError>
                  </div>
                  <div class="w-1/4 ms-2">
                    <InputLabel :value="'End date'"></InputLabel>
                    <TextInput
                      type="date"
                      v-model="form.end_date"
                      class="mt-3 w-full"
                    ></TextInput>
                    <InputError :message="form.errors.end_date"></InputError>
                  </div>
                  <div class="w-1/4 ms-2">
                    <InputLabel :value="'Start time'"></InputLabel>
                    <TextInput
                      type="time"
                      v-model="form.start_time"
                      class="mt-3 w-full"
                    ></TextInput>
                    <InputError :message="form.errors.start_time"></InputError>
                  </div>
                  <div class="w-1/4 ms-2">
                    <InputLabel :value="'End time'"></InputLabel>
                    <TextInput
                      type="time"
                      v-model="form.end_time"
                      class="mt-3 w-full"
                    ></TextInput>
                    <InputError :message="form.errors.end_time"></InputError>
                  </div>
                </div>

                <div class="w-full flex my-5">
                  <div class="w-1/3">
                    <InputLabel
                      :value="'Early attendance minutes'"
                    ></InputLabel>
                    <select
                      v-model="form.early_attendance_min"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3"
                    >
                      <option value="" selected="">
                        Open this select early attendance minutes
                      </option>
                      <option value="15">15</option>
                      <option value="30">30</option>
                      <option value="45">45</option>
                      <option value="60">60</option>
                    </select>
                    <InputError
                      :message="form.errors.early_attendance_min"
                    ></InputError>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="'Late attendance minutes'"></InputLabel>
                    <select
                      v-model="form.late_attendance_min"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3"
                    >
                      <option value="" selected="">
                        Open this select late attendance minutes
                      </option>
                      <option value="15">15</option>
                      <option value="30">30</option>
                      <option value="45">45</option>
                      <option value="60">60</option>
                    </select>
                    <InputError
                      :message="form.errors.late_attendance_min"
                    ></InputError>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="'Description'"></InputLabel>
                    <div class="max-w-sm space-y-3">
                      <textarea
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        rows="3"
                        placeholder="Description"
                        v-model="form.description"
                      ></textarea>
                    </div>
                    <InputError :message="form.errors.description"></InputError>
                  </div>
                </div>

                <div class="mt-10 w-full flex justify-end">
                  <PrimaryButton>Save</PrimaryButton>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
