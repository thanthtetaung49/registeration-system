<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EventForm from "@/Components/EventForm.vue";
import { defineComponent } from "vue";
import EventTabLayout from "@/Layouts/EventTabLayout.vue";

defineComponent({ EventForm });

const props = defineProps({ instructors: Object, categories: Object, rooms: Object })

</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="px-10 py-10">
        <header class="mb-10">
          <h3 class="text-gray-800 text-2xl pb-1 bold">Event</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>

        <div class="w-full bg-white rounded-lg shadow-md">
          <div class="border-b border-gray-200 px-4 pb-5 mb-10">
            <EventTabLayout></EventTabLayout>

            <div class="my-5">
              <EventForm :instructors="instructors" :categories="categories" :rooms="rooms"></EventForm>
            </div>

          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
