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
        href="/attendees/list"
        class="py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current('attendees.list.index'),
          'text-gray-500 ': !route().current('attendees.list.index'),
        }"
      >
        List attendees
      </Link>
      <Link
        href="/attendees/type"
        class="py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current('attendees.type.index'),
          'text-gray-500 ': !route().current('attendees.type.index'),
        }"
      >
        Attendees type
      </Link>
      <Link
        href="/attendees/group"
        class="py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current('attendees.group.index'),
          'text-gray-500 ': !route().current('attendees.group.index'),
        }"
      >
        Attendees group
      </Link>
      <Link
        href="/attendees/add"
        class="py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current('attendees.index'),
          'text-gray-500 ': !route().current('attendees.index'),
        }"
      >
        Attendees
      </Link>

      <Link
        href="/attendees/upload"
        class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current('attendees.upload.index'),
          'text-gray-500 ': !route().current('attendees.upload.index'),
        }"
      >
        Attendees import
      </Link>

      <Link
        href="/attendees/register"
        class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current(
            'attendees.register.index'
          ),
          'text-gray-500 ': !route().current('attendees.register.index'),
        }"
      >
        Register attendees
      </Link>

       <Link
        href="/attendees/unregister"
        class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-blue-500 font-bold': route().current(
            'attendees.unregister.index'
          ),
          'text-gray-500 ': !route().current('attendees.unregister.index'),
        }"
      >
        Unregister attendees
      </Link>
    </nav>


  </div>
</template>
