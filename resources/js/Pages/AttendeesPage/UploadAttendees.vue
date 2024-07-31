<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import SuccessAlert from "@/Components/SuccessAlert.vue";
import { ref } from "vue";

const form = useForm({
  import_file: null,
});

const alertStatus = ref(false);

const importFile = () => {
  form.post("/attendees/import", {
    onSuccess: () => form.reset("import_file"),
  });
  alertStatus.value = true;
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
