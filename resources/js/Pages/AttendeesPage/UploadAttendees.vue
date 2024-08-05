<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm } from "@inertiajs/vue3";
import SuccessAlert from "@/Components/SuccessAlert.vue";
import { ref } from "vue";
import InputError from "@/Components/InputError.vue";

const form = useForm({
  import_file: null,
});

const alertStatus = ref(false);

const importFile = () => {
  form.post("/attendees/import", {
    onSuccess: () => form.reset("import_file"),
  });
  if (!form.errors) {
    alertStatus.value = true;
  }
};

const excelExport = () => {
  window.location.href = "/attendees/template/export";
};
</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="px-10 py-10">
        <header class="mb-10">
          <h3 class="text-gray-800 text-2xl pb-1 bold">Attendees</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>

        <div class="w-full bg-white rounded-lg shadow-md">
          <div class="border-b border-gray-200 px-4">
            <AttendeesTabLayout></AttendeesTabLayout>

            <div class="mt-5">
              <form v-on:submit.prevent="importFile">
                <SuccessAlert
                  v-if="alertStatus"
                  :message="'Import successfully.'"
                ></SuccessAlert>

                <div class="w-full flex justify-end">
                  <button
                    type="button"
                    v-on:click="excelExport"
                    class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                  >
                    Sample template
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="size-5 ms-2"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"
                      />
                    </svg>
                  </button>
                </div>

                <div class="w-full flex mt-5">
                  <div class="w-1/2">
                    <InputLabel for="import_file" class="mb-3"
                      >Import attendees list</InputLabel
                    >
                    <input
                      @input="form.import_file = $event.target.files[0]"
                      type="file"
                      name="import_file"
                      id="file-input"
                      class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400"
                    />
                  </div>
                </div>
                <InputError :message="form.errors.import_file"></InputError>
                <div class="flex w-full justify-end mt-5 mb-10">
                  <PrimaryButton type="submit">Save</PrimaryButton>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
