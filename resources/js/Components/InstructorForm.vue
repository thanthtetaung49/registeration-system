<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: null,
});

const saveInstructor = () => form.post('/instructor/create', {
    onSuccess: () => form.reset('name'),
});

</script>

<template>
  <div>
    <form v-on:submit.prevent="saveInstructor">
      <div>
        <InputLabel :value="'Instructor'"></InputLabel>
        <TextInput v-model="form.name" class="mt-3 w-[30%]"></TextInput>
        <InputError :message="form.errors.name"></InputError>
      </div>
      <div class="mt-5 w-full flex justify-end">
        <PrimaryButton type="submit" class="">Save</PrimaryButton>
      </div>
    </form>
  </div>
</template>
