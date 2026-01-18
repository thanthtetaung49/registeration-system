<script setup>
const props = defineProps({ message: Object });

</script>

<template>
  <div>
    <div
      class="mt-2 bg-green-50 border border-green-200 text-sm text-green-800 rounded-lg p-4 dark:bg-gray-800 dark:text-white-500 shadow-lg" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-success-label">
      {{ props.message }}
    </div>
  </div>
</template>
