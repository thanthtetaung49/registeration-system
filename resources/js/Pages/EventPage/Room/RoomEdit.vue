<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
  room: Object,
});

const room = props.room;

const form = useForm({
    room_number: room.room_number,
});

const updateRoomNumber = () => form.post(`/room/update/${room.id}`);
</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="px-10 py-10">
        <header class="mb-10">
          <h3 class="text-gray-800 text-2xl pb-1 bold dark:text-white">Event's Room Edit</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>

        <div class="w-full bg-white rounded-lg shadow-md dark:text-white dark:bg-gray-800">
          <div class="border-b border-gray-200 dark:border-none px-4 py-5">
            <div class="mt-5">
              <form v-on:submit.prevent="updateRoomNumber">
                <div>
                  <InputLabel :value="'Room Number'"></InputLabel>
                  <TextInput
                    v-model="form.room_number "
                    class="mt-3 w-[30%] text-sm"
                  ></TextInput>
                  <InputError :message="form.errors.room_number"></InputError>
                </div>
                <div class="mt-5 w-full flex justify-end">
                     <Link
                    href="/room"
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
