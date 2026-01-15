<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EventForm from "@/Components/EventForm.vue";
import { defineComponent } from "vue";
import EventTabLayout from "@/Layouts/EventTabLayout.vue";
import { usePage } from "@inertiajs/vue3";

defineComponent({ EventForm });

const props = defineProps({ instructors: Object, categories: Object, rooms: Object })
const page = usePage();
const l = page.props.language;

</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="px-10 py-10">
        <header class="mb-10">
          <h3 class="text-gray-800 text-2xl pb-1 bold dark:text-white">Create Event</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>

        <div class="w-full bg-white rounded-lg shadow-md dark:text-white dark:bg-gray-800">
          <div class="border-b border-gray-200 dark:border-none px-4 pb-5 mb-10">
            <div class="border-b">
              <EventTabLayout :l="l"></EventTabLayout>
            </div>

            <div class="my-5">
              <EventForm :instructors="instructors" :categories="categories" :rooms="rooms" :l="l"></EventForm>
            </div>

          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
