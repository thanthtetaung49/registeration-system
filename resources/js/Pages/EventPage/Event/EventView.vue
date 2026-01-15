<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({ event: Object });

const event = props.event;

const page = usePage();
const l = page.props.language;

const form = useForm({
  event_name: event.event_name,
  description: event.description,
  location: event.location,
  credits: event.credits,
  lead_instructors_id: event.lead_instructors.name,
  assist_instructors_id: event.assists_instructors.name,
  categories_id: event.categories.category_name,
  max_seats: event.max_seats,
  event_reference_id: event.event_reference_id,
  start_date: event.start_date,
  end_date: event.end_date,
  start_time: event.start_time,
  end_time: event.end_time,
  early_attendance_min: event.early_attendance_min,
  late_attendance_min: event.late_attendance_min,
  room_numbers_id: event.room_numbers_id,
  event_type: event.event_type == 1 ? false : true,
});
</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="px-10 py-10">
        <header class="mb-10">
          <h3 class="text-gray-800 text-2xl pb-1 bold dark:text-white ">{{ l.events.eventViewTitle }}</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>

        <div class="w-full bg-white rounded-lg shadow-md dark:text-white dark:bg-gray-800">
          <div class="border-b border-gray-200 dark:border-none px-4 py-5 mb-10">
            <div class="my-5">
              <form>
                <div class="w-full flex">
                  <div class="w-1/3">
                    <InputLabel :value="l.events.labels.eventName"></InputLabel>
                    <TextInput v-model="form.event_name" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="l.events.labels.location"></InputLabel>
                    <TextInput v-model="form.location" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="l.events.labels.credits"></InputLabel>
                    <TextInput v-model="form.credits" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                </div>

                <div class="w-full flex my-5">
                  <div class="w-1/3">
                    <InputLabel :value="l.events.labels.leadInstructor"></InputLabel>
                    <TextInput v-model="form.lead_instructors_id" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="l.events.labels.assistantInstructor"></InputLabel>
                    <TextInput v-model="form.assist_instructors_id" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="l.events.labels.category"></InputLabel>
                    <TextInput v-model="form.categories_id" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                </div>

                <div class="w-full flex my-5">
                  <div class="w-1/3">
                    <InputLabel :value="l.events.labels.maxSeat"></InputLabel>
                    <TextInput type="number" v-model="form.max_seats" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="l.events.labels.eventReferenceID"></InputLabel>
                    <TextInput type="number" v-model="form.event_reference_id" class="mt-3 w-full text-sm" disabled>
                    </TextInput>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="l.events.labels.eventRoomNumber"></InputLabel>
                    <TextInput v-model="form.room_numbers_id" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                </div>

                <div class="w-full flex my-5">
                  <div class="w-1/4">
                    <InputLabel :value="l.events.labels.startDate"></InputLabel>
                    <TextInput type="date" v-model="form.start_date" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                  <div class="w-1/4 ms-2">
                    <InputLabel :value="l.events.labels.endDate"></InputLabel>
                    <TextInput type="date" v-model="form.end_date" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                  <div class="w-1/4 ms-2">
                    <InputLabel :value="l.events.labels.startTime"></InputLabel>
                    <TextInput type="time" v-model="form.start_time" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                  <div class="w-1/4 ms-2">
                    <InputLabel :value="l.events.labels.endTime"></InputLabel>
                    <TextInput type="time" v-model="form.end_time" class="mt-3 w-full text-sm" disabled></TextInput>
                  </div>
                </div>

                <div class="w-full flex my-5">
                  <div class="w-1/3">
                    <InputLabel :value="l.events.labels.earlyAttendanceMinutes"></InputLabel>
                    <select v-model="form.early_attendance_min"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 dark:border-none rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3 dark:bg-gray-900  dark:text-white"
                      disabled>
                      <option value="" selected="">
                        Open this select early attendance minutes
                      </option>
                      <option value="15">15</option>
                      <option value="30">30</option>
                      <option value="45">45</option>
                      <option value="60">60</option>
                    </select>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="l.events.labels.lateAttendanceMinutes"></InputLabel>
                    <select v-model="form.late_attendance_min"
                      class="py-3 px-4 pe-9 block w-full border-gray-200 dark:border-none rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3 dark:bg-gray-900  dark:text-white"
                      disabled>
                      <option value="" selected="">
                        Open this select late attendance minutes
                      </option>
                      <option value="15">15</option>
                      <option value="30">30</option>
                      <option value="45">45</option>
                      <option value="60">60</option>
                    </select>
                  </div>
                  <div class="w-1/3 ms-2">
                    <InputLabel :value="l.events.labels.eventDescription"></InputLabel>
                    <div class="max-w-sm space-y-3">
                      <textarea
                        class="py-3 px-4 block w-full border-gray-200 dark:border-none rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-900 dark:text-white"
                        rows="3"  v-model="form.description" disabled></textarea>
                    </div>
                  </div>
                </div>

                <div class="w-full ms-2">
                  <InputLabel :value="l.events.labels.selfCheckIn"></InputLabel>
                  <input type="checkbox" id="hs-basic-usage" v-model="form.event_type" disabled
                    class="mt-3 relative w-[3.25rem] h-7 p-px bg-gray-300 border-transparent text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6 before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-blue-200" />
                  <InputError :message="form.errors.event_type"></InputError>
                </div>

                <div class="mt-10 w-full flex justify-end">
                  <Link href="/event/eventList"
                    class="inline-flex items-center px-4 py-2 bg-slate-100 border border-transparent rounded-md font-semibold text-xs text-slate-800 uppercase tracking-widest hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                    {{ l.events.button.back }}</Link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
