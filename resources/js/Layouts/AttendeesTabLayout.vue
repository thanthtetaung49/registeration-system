<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const registerAttendeesRoutes = [
  'attendees.registerAttendees.*'
];

const isRegisterAttendeesActive = computed(() =>
  registerAttendeesRoutes.some(name => route().current(name))
);

const props = defineProps({ l: Object });
const l = props.l;

// console.log(l.attendees.tabs.attendee);
</script>

<template>
  <div class="w-full">
    <nav class="mx-2" aria-label="Tabs" role="tablist"
      aria-orientation="horizontal">
      <Link href="/attendees/attendeesLists"
        class="py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab" :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('attendees.list.index'),
          'text-gray-500 ': !route().current('attendees.list.index'),
        }">
        {{ l.attendees.tabs.attendeesList }}
      </Link>
      <Link href="/attendees/attendeesType"
        class="py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab" :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('attendees.type.index'),
          'text-gray-500 ': !route().current('attendees.type.index'),
        }">
        {{ l.attendees.tabs.attendeesType }}
      </Link>
      <Link href="/attendees/attendeesGroup"
        class="py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab" :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('attendees.group.index'),
          'text-gray-500 ': !route().current('attendees.group.index'),
        }">
        {{ l.attendees.tabs.attendeesGroup }}
      </Link>
      <Link href="/attendees"
        class="py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab" :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('attendees.index'),
          'text-gray-500 ': !route().current('attendees.index'),
        }">
       {{ l.attendees.tabs.createAttendees }}
      </Link>

      <Link href="/attendees/upload/file"
        class="py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab" :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('attendees.upload.index'),
          'text-gray-500 ': !route().current('attendees.upload.index'),
        }">
        {{ l.attendees.tabs.importAttendees }}
      </Link>

      <Link href="/attendees/registerAttendees"
        class="py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab" :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('attendees.registerAttendees.index') || route().current('attendees.registerAttendees.search') || route().current('attendees.registerAttendees.filter'),
          'text-gray-500 ': !route().current('attendees.registerAttendees.index') || !route().current('attendees.registerAttendees.search') || !route().current('attendees.registerAttendees.filter'),
        }">
        {{ l.attendees.tabs.registerAttendees }}
      </Link>

      <Link href="/attendees/unregisterAttendees"
        class="py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab" :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current(
            'attendees.unregisterAttendees.index'
          ),
          'text-gray-500 ': !route().current('attendees.unregisterAttendees.index'),
        }">
        {{ l.attendees.tabs.unregisterAttendees }}
      </Link>
    </nav>
  </div>
</template>
