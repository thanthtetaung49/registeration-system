<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    room_number: null,
});

const saveRoomNumber = () => form.post('/room/create', {
    onSuccess: () => form.reset('room_number'),
});

</script>

<template>
  <div>
    <form v-on:submit.prevent="saveRoomNumber">
      <div>
        <InputLabel :value="'Event Room Location'"></InputLabel>
        <TextInput placeholder="Event Room Location" v-model="form.room_number" class="mt-3 w-[30%] text-sm"></TextInput>
        <InputError  :message="form.errors.room_number"></InputError>
      </div>
      <div class="mt-5 w-full flex justify-end">
        <PrimaryButton type="submit" class="">Save</PrimaryButton>
      </div>
    </form>
  </div>
</template>
