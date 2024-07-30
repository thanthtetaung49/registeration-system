<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import { defineComponent, onMounted, ref } from "vue";

defineComponent({
  FullCalendar,
});

const props = defineProps({ events: Object });

const calendarOptions = ref({
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: "dayGridMonth",
    events: [],
});

onMounted(() => {
  const events = props.events;
  const newEvents = [];

  events.forEach((event) => {
      const objects = {
      title: event.event_name,
      start: event.start_date,
      end: addOneDay(event.end_date),
    };

    newEvents.push(objects);
  });
  calendarOptions.value.events = newEvents;
});

const addOneDay = (date) =>
{
    const newDate = new Date(date);
    newDate.setDate(newDate.getDate() + 1);
    return newDate.toISOString().split('T')[0];
}

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
      <div class="max-w-full mx-auto sm:px-6 lg:px-8">
        <header class="mb-10">
          <h3 class="text-gray-800 text-2xl pb-1 bold">Calendar</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>
        <div
          class="bg-white text-sm overflow-hidden shadow-sm sm:rounded-lg p-10 w-full"
        >
          <FullCalendar :options="calendarOptions"></FullCalendar>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
