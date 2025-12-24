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
        href="/attendees"
        class="py-2 my-3 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-500': route().current('attendees.list.index'),
          'text-gray-500 ': !route().current('attendees.list.index'),
        }"
      >
        Attendees Lists
      </Link>
      <Link
        href="/attendees/type"
        class="py-2 my-3 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-500': route().current('attendees.type.index'),
          'text-gray-500 ': !route().current('attendees.type.index'),
        }"
      >
        Attendees Type
      </Link>
      <Link
        href="/attendees/group"
        class="py-2 my-3 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-500': route().current('attendees.group.index'),
          'text-gray-500 ': !route().current('attendees.group.index'),
        }"
      >
        Attendees Group
      </Link>
      <Link
        href="/attendees/add"
        class="py-2 my-3 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-500': route().current('attendees.index'),
          'text-gray-500 ': !route().current('attendees.index'),
        }"
      >
        Create Attendees
      </Link>

      <Link
        href="/attendees/upload"
        class="py-2 my-3 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-500': route().current('attendees.upload.index'),
          'text-gray-500 ': !route().current('attendees.upload.index'),
        }"
      >
        Import Attendees
      </Link>

      <Link
        href="/attendees/register"
        class="py-2 my-3 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-500': route().current(
            'attendees.register.index'
          ),
          'text-gray-500 ': !route().current('attendees.register.index'),
        }"
      >
        Register Attendees
      </Link>

       <Link
        href="/attendees/unregister"
        class="py-2 my-3 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap  focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
        role="tab"
        :class="{
          'text-white rounded-md font-bold bg-blue-500': route().current(
            'attendees.unregister.index'
          ),
          'text-gray-500 ': !route().current('attendees.unregister.index'),
        }"
      >
        Unregister Attendees
      </Link>
    </nav>


  </div>
</template>
