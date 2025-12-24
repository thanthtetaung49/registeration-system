<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    category_name: null,
});

const saveCategories = () => form.post('/category/create', {
    onSuccess: () => form.reset('category_name')
});

</script>

<template>
  <div>
    <form v-on:submit.prevent="saveCategories">
      <div>
        <InputLabel :value="'Category'"></InputLabel>
        <TextInput placeholder="Cateogry" v-model="form.category_name" class="mt-3 w-[30%] text-sm"></TextInput>
        <InputError :message="form.errors.category_name"></InputError>
      </div>
      <div class="mt-5 w-full flex justify-end">
        <PrimaryButton type="submit" class="">Save</PrimaryButton>
      </div>
    </form>
  </div>
</template>
