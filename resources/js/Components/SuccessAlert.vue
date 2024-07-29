<script setup>
const props = defineProps({ message: Object });

</script>

<template>
  <div>
    <div
      class="mt-2 bg-teal-500 text-sm text-white rounded-lg p-4"
      role="alert"
      tabindex="-1"
      aria-labelledby="hs-solid-color-success-label"
    >
      alert! You should check in on some of those fields below.
    </div>
  </div>
</template>