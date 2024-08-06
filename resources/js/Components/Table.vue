<script setup>
import { ref, watch } from "vue";

const props = defineProps({ users: Object });
const users = ref(props.users);

watch(users, (newUsers) =>
{
    console.log(newUsers);
    console.log('hi');
})
</script>

<template>
  <div>
    <!-- {{ users }} table -->
    
  </div>
</template>
