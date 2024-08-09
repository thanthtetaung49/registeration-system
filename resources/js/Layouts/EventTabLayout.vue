<script setup>
import { Link } from "@inertiajs/vue3";
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
        href="/event/list"
        class="py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current('event.list.index'),
          'text-gray-500 ': !route().current('event.list.index'),
        }"
      >
        Event list
      </Link>
      <Link
        href="/instructor"
        class="py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current('instructor.index'),
          'text-gray-500 ': !route().current('instructor.index'),
        }"
      >
        Instructor
      </Link>
      <Link
        href="/category"
        class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current('category.index'),
          'text-gray-500 ': !route().current('category.index'),
        }"
      >
        Event categories
      </Link>
      <Link
        href="/room"
        class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current('roomNumber.index'),
          'text-gray-500 ': !route().current('roomNumber.index'),
        }"
      >
        Room
      </Link>
      <Link
        href="/event"
        class="hs-tab-active:font-semibold hs-tab-active:bordsubmitCategoryer-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current('event.index'),
          'text-gray-500 ': !route().current('event.index'),
        }"
      >
        Event detail & time
      </Link>
      <Link
        href="/event/report"
        class="hs-tab-active:font-semibold hs-tab-active:bordsubmitCategoryer-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"  
        :class="{
          'text-blue-500 font-bold': route().current('event.report.index'),
          'text-gray-500 ': !route().current('event.report.index'),
        }"
      >
        Event report
      </Link>
    </nav>
  </div>
</template>
