<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import { defineComponent } from "vue";

const components = defineComponent({
  FullCalendar,
});

const calendarOptions = {
  plugins: [dayGridPlugin, interactionPlugin],
  initialView: "dayGridMonth",
  events: [
    { title: "title 1", date: "2024-07-01" , backgroundColor: 'red'},
    { title: "title 2", date: "2024-07-26" , backgroundColor: 'blue'},
  ],
};
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white text-sm overflow-hidden shadow-sm sm:rounded-lg px-5 py-10 w-full"
        >
          <FullCalendar :options="calendarOptions">

          </FullCalendar>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
