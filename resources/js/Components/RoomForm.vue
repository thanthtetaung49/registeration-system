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

const props = defineProps({
  l: Object,
});

const l = props.l;

</script>

<template>
  <div>
    <form v-on:submit.prevent="saveRoomNumber">
      <div>
        <InputLabel :value="l.events.eventRoom.labels.eventRoom"></InputLabel>
        <TextInput  :placeholder="l.events.eventRoom.placeholder.eventRoom" v-model="form.room_number" class="mt-3 w-[30%] text-sm"></TextInput>
        <InputError  :message="form.errors.room_number"></InputError>
      </div>
      <div class="mt-5 w-full flex justify-end">
        <PrimaryButton type="submit" >{{ l.events.button.save }}</PrimaryButton>
      </div>
    </form>
  </div>
</template>
