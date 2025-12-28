<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
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
          <h3 class="text-gray-800 text-2xl pb-1 bold  dark:text-white">Instructor Edit</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>

        <div class="w-full bg-white rounded-lg shadow-md dark:bg-gray-800 dark:text-white">
          <div class="border-b border-gray-200 dark:border-none px-4 py-5">
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
                     <Link
                    href="/instructors"
                   class="inline-flex items-center px-4 py-2 bg-slate-100 border border-transparent rounded-md font-semibold text-xs text-slate-800 uppercase tracking-widest hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3"
                    >Back</Link
                  >
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
