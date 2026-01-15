<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: null,
});

const saveInstructor = () => form.post('/instructors/create', {
    onSuccess: () => form.reset('name'),
});

const props = defineProps({ l: Object });
const l = props.l;

</script>

<template>
  <div>
    <form v-on:submit.prevent="saveInstructor">
      <div>
        <InputLabel :value="l.events.instructors.labels.instructor"></InputLabel>
        <TextInput :placeholder="l.events.instructors.placeholder.instructor" v-model="form.name" class="mt-3 w-[30%] text-sm"></TextInput>
        <InputError :message="form.errors.name"></InputError>
      </div>
      <div class="mt-5 w-full flex justify-end">
        <PrimaryButton type="submit" >{{ l.events.button.save }}</PrimaryButton>
      </div>
    </form>
  </div>
</template>
