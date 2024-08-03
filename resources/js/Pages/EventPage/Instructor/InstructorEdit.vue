<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  instructor: Object,
});

const form = useForm({
    name: props.instructor.name,
});

const instructor = props.instructor;

const updateInstructor = () => form.post(`/instructor/update/${instructor.id}`);

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
          <div class="border-b border-gray-200 px-4 py-5">
            <div class="mt-5">
              <form v-on:submit.prevent="updateInstructor">
                <div>
                  <InputLabel :value="'Instructor'"></InputLabel>
                  <TextInput
                    v-model="form.name"
                    class="mt-3 w-[30%] text-sm"
                  ></TextInput>
                  <InputError :message="form.errors.name"></InputError>
                </div>
                <div class="mt-5 w-full flex justify-end">
                  <PrimaryButton type="submit" class="">Save</PrimaryButton>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
