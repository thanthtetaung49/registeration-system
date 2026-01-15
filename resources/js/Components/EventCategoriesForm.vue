<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    category_name: null,
});

const props = defineProps({ l: Object });
const l = props.l;

const saveCategories = () => form.post('/category/create', {
    onSuccess: () => form.reset('category_name')
});

</script>

<template>
  <div>
    <form v-on:submit.prevent="saveCategories">
      <div>
        <InputLabel :value="l.events.category.labels.category"></InputLabel>
        <TextInput :placeholder="l.events.category.placeholder.category" v-model="form.category_name" class="mt-3 w-[30%] text-sm"></TextInput>
        <InputError :message="form.errors.category_name"></InputError>
      </div>
      <div class="mt-5 w-full flex justify-end">
        <PrimaryButton type="submit" class="">{{ l.events.button.save }}</PrimaryButton>
      </div>
    </form>
  </div>
</template>
