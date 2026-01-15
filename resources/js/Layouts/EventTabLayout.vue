<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({ l: Object });
const l = props.l;
</script>

<template>
  <div>
    <nav
      class="flex gap-x-2"
      aria-label="Tabs"
      role="tablist"
      aria-orientation="horizontal"
    >
     <Link
        href="/event/eventList"
        class="py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('event.list.index'),
          'text-gray-500 ': !route().current('event.list.index'),
        }"
      >
        {{ l.events.tabs.eventLists }}
      </Link>
       <Link
        href="/event"
        class="hs-tab-active:font-semibold hs-tab-active:bordsubmitCategoryer-blue-600 py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap   focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('event.index'),
          'text-gray-500 ': !route().current('event.index'),
        }"
      >
        {{ l.events.tabs.createEvent }}
      </Link>

      <Link
        href="/instructors"
        class="py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('instructor.index'),
          'text-gray-500 ': !route().current('instructor.index'),
        }"
      >
        {{ l.events.tabs.instructors }}
      </Link>
      <Link
        href="/category"
        class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('category.index'),
          'text-gray-500 ': !route().current('category.index'),
        }"
      >
        {{ l.events.tabs.eventCategories }}
      </Link>
      <Link
        href="/room"
        class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap   focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('roomNumber.index'),
          'text-gray-500 ': !route().current('roomNumber.index'),
        }"
      >
        {{ l.events.tabs.eventRoomLocations }}
      </Link>

      <Link
        href="/event/report"
        class="hs-tab-active:font-semibold hs-tab-active:bordsubmitCategoryer-blue-600 py-2 my-3 px-4 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap   focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-700': route().current('event.report.index'),
          'text-gray-500 ': !route().current('event.report.index'),
        }"
      >
        {{ l.events.tabs.eventReports }}
      </Link>
    </nav>
  </div>
</template>
