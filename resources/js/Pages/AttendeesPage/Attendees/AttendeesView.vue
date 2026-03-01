<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextInputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import defaultImage from "@/images/default_profile.png";
import { defineComponent, ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";

defineComponent({ defaultImage });

const props = defineProps({
  user: Object,
  types: Object,
  groups: Object,
  baseUrl: String,
  trainingLists: Object,
  teacherTypes: Object,
  courses: Object
});
const user = props.user;
const page = usePage();
const l = page.props.language;

const form = useForm({
  name: user.name,
  secondary_name: user.secondary_name,
  age: user.age,
  gender: user.gender,
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
  teacher_id: user.teacher_id,
  parent_name: user.parent_name,
  birth_date: user.birth_date,
  nation: user.nation,
  join_date: user.join_date,
  place_of_duty: user.place_of_duty,
  service_year: user.service_year,
  service_year_benefit: user.service_year_benefit,
  monthly_benefit: user.monthly_benefit,
  last_place_of_duty: user.last_place_of_duty,
  current_address: user.current_address,
  training_list_id: user.training_list_id,
  teacher_type_id: user.teacher_type_id,
  course_id: user.course_id,
  subject_assigned: user.subject_assigned,
});
</script>

<template>
  <AuthenticatedLayout>
    <div class="min-h-screen bg-gray-50 dark:bg-neutral-900 py-10 px-4 sm:px-10">
      <header
        class="max-w-6xl mx-auto mb-8 flex justify-between items-end border-b border-gray-200 dark:border-neutral-700 pb-6">
        <div>
          <h3 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight">
            {{ l.attendees.attendeesViewTitle }}
          </h3>
          <div class="w-12 h-1.5 bg-blue-600 mt-2 rounded-full"></div>
        </div>
        <Link href="/attendees/attendeesLists"
          class="px-5 py-2.5 bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl shadow-sm text-sm font-bold text-gray-700 dark:text-neutral-300 hover:bg-gray-50 transition-all">
          {{ l.events.button.back }}
        </Link>
      </header>

      <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
        <div class="lg:col-span-4 space-y-6">
          <div
            class=" bg-white dark:bg-neutral-800 rounded-3xl shadow-sm border border-gray-100 dark:border-neutral-700 p-8 text-center">
            <span :class="[
              'mb-5 inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wider border',
              form.status === 'active'
                ? 'bg-green-100 text-green-700 border-green-200 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20'
                : 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-500/10 dark:text-yellow-400 dark:border-yellow-500/20'
            ]">
              <span
                :class="['w-1.5 h-1.5 rounded-full', form.status === 'active' ? 'bg-green-500 animate-pulse' : 'bg-yellow-500']"></span>
              {{ form.status || 'Pending' }}
            </span>

            <div class="relative inline-block group">
              <img v-if="imageUrl" :src="imageUrl"
                class="w-40 h-40 rounded-3xl object-cover ring-8 ring-blue-50 dark:ring-neutral-700/50 shadow-xl mx-auto" />
              <img v-else-if="user.profile_path" :src="`/storage/${user.profile_path}`"
                class="w-40 h-40 rounded-3xl object-cover ring-8 ring-blue-50 dark:ring-neutral-700/50 shadow-xl mx-auto" />
              <img v-else :src="defaultImage"
                class="w-40 h-40 rounded-3xl object-cover ring-8 ring-blue-50 dark:ring-neutral-700/50 shadow-xl mx-auto" />
            </div>

            <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">{{ form.name }}</h2>
            <p class="text-blue-600 dark:text-blue-400 font-semibold uppercase tracking-wider text-xs mt-1">{{
              form.position || 'Attendee' }}</p>

            <div class="mt-8 pt-8 border-t border-gray-100 dark:border-neutral-700 space-y-4 text-left">
              <div class="flex items-center text-gray-600 dark:text-neutral-400">
                <div class="p-2 bg-gray-50 dark:bg-neutral-700 rounded-lg mr-3 text-blue-500">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </div>
                <span class="text-sm font-medium truncate">{{ form.email }}</span>
              </div>
              <div class="flex items-center text-gray-600 dark:text-neutral-400">
                <div class="p-2 bg-gray-50 dark:bg-neutral-700 rounded-lg mr-3 text-green-500">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                </div>
                <span class="text-sm font-medium">{{ form.phone_number }}</span>
              </div>
            </div>
          </div>
        </div>

        <div class="lg:col-span-8 space-y-8">

          <div
            class="bg-white dark:bg-neutral-800 rounded-3xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden">
            <div class="px-8 py-5 border-b border-gray-50 dark:border-neutral-700 flex items-center gap-2">
              <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
              <h3 class="font-bold text-gray-800 dark:text-white text-sm uppercase tracking-widest">General Information
              </h3>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
              <div class="flex flex-col">
                <label class="text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase mb-1">{{
                  l.attendees.createAttendees.labels.teacherID }}</label>
                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200">{{ form.teacher_id || '—' }}</p>
              </div>
              <div class="flex flex-col">
                <label class="text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase mb-1">{{
                  l.attendees.createAttendees.labels.secondaryName }}</label>
                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200">{{ form.secondary_name || '—' }}
                </p>
              </div>
              <div class="flex flex-col">
                <label class="text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase mb-1">{{
                  l.attendees.createAttendees.labels.parentName }}</label>
                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200">{{ form.parent_name || '—' }}</p>
              </div>
              <div class="flex flex-col">
                <label class="text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase mb-1">{{
                  l.attendees.createAttendees.labels.birthDate }}</label>
                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200">{{ form.birth_date }} <span
                    v-if="age" class="text-blue-500 ml-1">({{ age }} yrs)</span></p>
              </div>
              <div class="flex flex-col">
                <label class="text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase mb-1">{{
                  l.attendees.createAttendees.labels.Nationality }}</label>
                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200">{{ form.nation || '—' }}</p>
              </div>
              <div class="flex flex-col">
                <label class="text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase mb-1">{{
                  l.attendees.createAttendees.labels.attendeesNRCNumber }}</label>
                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200">{{ form.nrc_number || '—' }}</p>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div
              class="bg-white dark:bg-neutral-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-neutral-700">
              <h3 class="font-bold text-gray-800 dark:text-white mb-6 text-sm uppercase tracking-widest">{{
                l.attendees.createAttendees.labels.trainingConference }}</h3>
              <div class="space-y-4">
                <div v-for="t in trainingLists" :key="t.id"
                  class="flex items-center p-3 bg-blue-50/50 dark:bg-neutral-900 rounded-xl">
                  <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span class="text-sm font-medium text-gray-700 dark:text-neutral-300">{{ t.training_name }}</span>
                </div>
              </div>
            </div>

            <div
              class="bg-white dark:bg-neutral-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-neutral-700">
              <h3 class="font-bold text-gray-800 dark:text-white mb-6 text-sm uppercase tracking-widest">{{
                l.attendees.createAttendees.labels.gradeAssigned }}</h3>
              <div class="space-y-4">
                <div v-for="c in courses" :key="c.id"
                  class="flex items-center p-3 bg-purple-50/50 dark:bg-neutral-900 rounded-xl">
                  <svg class="w-5 h-5 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.082.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                  <span class="text-sm font-medium text-gray-700 dark:text-neutral-300">{{ c.course_name }}</span>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
