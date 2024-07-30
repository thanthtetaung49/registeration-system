<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  href: {
    type: String,
    required: true,
  },
  active: {
    type: Boolean,
  },
});

const classes = computed(() =>
  props.active
    ? "flex items-center px-2 py-3 rounded-md  text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-blue-700 transition duration-150 ease-in-out bg-blue-700 text-white"
    : "flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700   transition duration-150 ease-in-out"
);
</script>

<template>
  <Link :href="href" :class="classes" >
    <slot />
  </Link>
</template>
