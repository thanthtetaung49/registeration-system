<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({ event: Object, room : String });

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
  <AuthenticatedLayout>
    <div class="min-h-screen bg-gray-50 dark:bg-neutral-900 py-10 px-4 sm:px-10 mb-16">

      <header class="max-w-6xl mx-auto mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 dark:border-neutral-700 pb-6">
        <div>
          <h3 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight">
            {{ l.events.eventViewTitle }}
          </h3>
          <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">Reviewing event details and logistics.</p>
        </div>
        <Link href="/event/eventList"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl shadow-sm text-sm font-bold text-gray-700 dark:text-neutral-300 hover:bg-gray-50 transition-all">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
          {{ l.events.button.back }}
        </Link>
      </header>

      <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-8">

          <section class="bg-white dark:bg-neutral-800 rounded-3xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden">
            <div class="px-8 py-5 border-b border-gray-50 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50">
              <h4 class="font-bold text-gray-800 dark:text-white text-xs uppercase tracking-widest">Event Overview</h4>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
              <div class="md:col-span-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-tight">{{ l.events.labels.eventName }}</label>
                <p class="text-lg font-bold text-gray-800 dark:text-white mt-1">{{ form.event_name }}</p>
              </div>
              <div>
                <label class="text-xs font-bold text-gray-400 uppercase tracking-tight">{{ l.events.labels.location }}</label>
                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200 mt-1">{{ form.location }}</p>
              </div>
              <div>
                <label class="text-xs font-bold text-gray-400 uppercase tracking-tight">{{ l.events.labels.category }}</label>
                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200 mt-1">{{ form.categories_id }}</p>
              </div>
              <div>
                <label class="text-xs font-bold text-gray-400 uppercase tracking-tight">{{ l.events.labels.leadInstructor }}</label>
                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200 mt-1">{{ form.lead_instructors_id }}</p>
              </div>
              <div>
                <label class="text-xs font-bold text-gray-400 uppercase tracking-tight">{{ l.events.labels.assistantInstructor }}</label>
                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200 mt-1">{{ form.assist_instructors_id }}</p>
              </div>
              <div class="md:col-span-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-tight">{{ l.events.labels.eventDescription }}</label>
                <p class="text-sm text-gray-600 dark:text-neutral-400 mt-2 leading-relaxed bg-gray-50 dark:bg-neutral-900/50 p-4 rounded-2xl italic">
                  "{{ form.description || 'No description provided.' }}"
                </p>
              </div>
            </div>
          </section>

          <section class="bg-white dark:bg-neutral-800 rounded-3xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden">
            <div class="px-8 py-5 border-b border-gray-50 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50 flex items-center gap-2">
              <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              <h4 class="font-bold text-gray-800 dark:text-white text-xs uppercase tracking-widest">Schedule & Logistics</h4>
            </div>
            <div class="p-8 grid grid-cols-2 md:grid-cols-4 gap-6">
              <div class="flex flex-col">
                <span class="text-xs font-bold text-gray-400 uppercase">{{ l.events.labels.startDate }}</span>
                <span class="text-sm font-bold text-gray-700 dark:text-neutral-200 mt-1">{{ form.start_date }}</span>
              </div>
              <div class="flex flex-col">
                <span class="text-xs font-bold text-gray-400 uppercase">{{ l.events.labels.endDate }}</span>
                <span class="text-sm font-bold text-gray-700 dark:text-neutral-200 mt-1">{{ form.end_date }}</span>
              </div>
              <div class="flex flex-col">
                <span class="text-xs font-bold text-gray-400 uppercase">{{ l.events.labels.startTime }}</span>
                <span class="text-sm font-bold text-blue-600 dark:text-blue-400 mt-1">{{ form.start_time }}</span>
              </div>
              <div class="flex flex-col">
                <span class="text-xs font-bold text-gray-400 uppercase">{{ l.events.labels.endTime }}</span>
                <span class="text-sm font-bold text-blue-600 dark:text-blue-400 mt-1">{{ form.end_time }}</span>
              </div>
            </div>
          </section>
        </div>

        <div class="lg:col-span-1 space-y-8">

          <div class="bg-blue-600 rounded-3xl p-8 text-white shadow-lg shadow-blue-200 dark:shadow-none">
            <div class="flex justify-between items-start">
              <div>
                <p class="text-blue-100 text-xs font-bold uppercase tracking-widest">{{ l.events.labels.maxSeat }}</p>
                <h4 class="text-4xl font-black mt-2">{{ form.max_seats }}</h4>
              </div>
              <div class="p-3 bg-white/20 rounded-2xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
              </div>
            </div>
            <div class="mt-8 pt-6 border-t border-white/10 grid grid-cols-2 gap-4">
              <div>
                <p class="text-blue-100 text-[10px] font-bold uppercase">{{ l.events.labels.credits }}</p>
                <p class="font-bold text-sm">{{ form.credits }}</p>
              </div>
              <div>
                <p class="text-blue-100 text-[10px] font-bold uppercase">Room</p>
                <p class="font-bold text-sm"># {{ room }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white dark:bg-neutral-800 rounded-3xl shadow-sm border border-gray-100 dark:border-neutral-700 p-8">
            <h4 class="font-bold text-gray-800 dark:text-white text-xs uppercase tracking-widest mb-6">Configuration</h4>

            <div class="space-y-6">
              <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-gray-600 dark:text-neutral-400">{{ l.events.labels.earlyAttendanceMinutes }}</span>
                <span class="px-3 py-1 bg-gray-100 dark:bg-neutral-700 rounded-lg text-xs font-bold">{{ form.early_attendance_min }}m</span>
              </div>
              <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-gray-600 dark:text-neutral-400">{{ l.events.labels.lateAttendanceMinutes }}</span>
                <span class="px-3 py-1 bg-gray-100 dark:bg-neutral-700 rounded-lg text-xs font-bold">{{ form.late_attendance_min }}m</span>
              </div>

              <div class="pt-6 border-t border-gray-50 dark:border-neutral-700 flex items-center justify-between">
                <div>
                  <p class="text-sm font-bold text-gray-800 dark:text-white">{{ l.events.labels.selfCheckIn }}</p>
                  <p class="text-xs text-gray-400 uppercase font-bold">{{ form.event_type ? 'Enabled' : 'Disabled' }}</p>
                </div>
                <div :class="form.event_type ? 'bg-blue-500' : 'bg-gray-300'" class="w-12 h-6 rounded-full relative transition-colors duration-300">
                  <div :class="form.event_type ? 'translate-x-6' : 'translate-x-1'" class="absolute top-1 w-4 h-4 bg-white rounded-full transition-transform duration-300 shadow-sm"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
