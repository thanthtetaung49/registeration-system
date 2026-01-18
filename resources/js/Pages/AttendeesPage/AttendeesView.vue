<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AttendeesTabLayout from "@/Layouts/AttendeesTabLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextInputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import defaultImage from "@/images/default_profile.png";
import { defineComponent, ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";

defineComponent({ defaultImage });

const props = defineProps({ user: Object, types: Object, groups: Object, baseUrl: String });
const user = props.user;
const page = usePage();
const l = page.props.language;

const form = useForm({
  name: user.name,
  age: user.age,
  gender: user.gender,
  phone_number: user.phone_number,
  nrc_number: user.nrc_number,
  edu_background: user.edu_background,
  position: user.position,
  department: user.department,
  address: user.address,
  email: user.email,
  avatar: user.profile_path,
  attendees_types_id:
    props.user.attendees_types !== null ? props.user.attendees_types.id : null,
  attendees_groups_id:
    props.user.attendees_groups !== null
      ? props.user.attendees_groups_id
      : null,
  teacher_id: user.teacher_id,
  parent_name: user.parent_name,
  birth_date: user.birth_date,
  nation: user.nation,
  join_date: user.join_date,
  place_of_duty: user.place_of_duty,
  service_year: user.service_year,
  service_year_benefit: user.service_year_benefit,
  monthly_benefit: user.monthly_benefit,
  last_place_of_duty: user.last_place_of_duty,
  current_address: user.current_address,
  training_conference: user.training_conference,
  type_of_teacher: user.type_of_teacher,
  grade_assigned: user.grade_assigned,
  subject_assigned: user.subject_assigned,
});
</script>

<template>
  <div>
    <AuthenticatedLayout>
      <div class="px-10 py-10">
        <header class="mb-10">
          <h3 class="text-gray-800 text-2xl pb-1 bold dark:text-white">{{ l.attendees.attendeesViewTitle }}</h3>
          <div class="w-10 h-1 bg-blue-800"></div>
        </header>

        <div class="w-full bg-white rounded-lg shadow-md dark:text-white dark:bg-gray-800">
          <div class="border-b border-gray-200 dark:border-none px-4 py-5 mb-10">
            <div class="mt-5">
              <form>
                <div class="w-1/3 my-3 flex items-end">
                  <img v-if="imageUrl && imageUrl != null" :src="imageUrl" alt="preview image"
                    class="w-20 rounded-md h-20" />
                  <img v-else :src="defaultImage" alt="default image" class="w-20 rounded-md h-20" />
                  <div class="ms-5">
                    <label for="file-input" class="mt-3 text-blue-700 underline text-sm font-medium">File upload</label>
                    <input @input="previewImage" type="file" name="import_file" id="file-input"
                      class="hidden w-full border border-gray-200 dark:border-none shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400 mt-3" />
                    <TextInputError :message="form.errors.avatar"></TextInputError>
                  </div>
                </div>

                <div class="w-full flex my-7">
                  <div class="w-1/3">
                    <InputLabel :value="l.attendees.createAttendees.labels.teacherID"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.teacherID" type="text"
                      v-model="form.teacher_id" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.teacher_id"></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesName"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.attendeesName" type="text"
                      v-model="form.name" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.name"></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.parentName"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.parentName" type="text"
                      v-model="form.parent_name" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.parent_name"></TextInputError>
                  </div>
                </div>

                <div class="w-full flex my-7">
                  <div class="w-1/3">
                    <InputLabel :value="l.attendees.createAttendees.labels.birthDate"></InputLabel>
                    <TextInput type="date" v-model="form.birth_date" class="mt-3 w-full text-sm"></TextInput>
                    <TextInputError :message="form.errors.birth_date"></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.Nationality"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.Nationality" type="text"
                      v-model="form.nation" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.nation"></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.joinDate"></InputLabel>
                    <TextInput type="date" v-model="form.join_date" class="mt-3 w-full text-sm"></TextInput>
                    <TextInputError :message="form.errors.join_date"></TextInputError>
                  </div>
                </div>

                <div class="w-full flex my-7">
                  <div class="w-1/3">
                    <InputLabel :value="l.attendees.createAttendees.labels.placeOfDuty"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.placeOfDuty" type="text"
                      v-model="form.place_of_duty" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.place_of_duty"></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.serviceYear"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.serviceYear" type="text"
                      v-model="form.service_year" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.service_year"></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.serviceYearBenefit"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.serviceYearBenefit" type="text"
                      v-model="form.service_year_benefit" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.service_year_benefit"></TextInputError>
                  </div>
                </div>

                <div class="w-full flex my-7">
                  <div class="w-1/3">
                    <InputLabel :value="l.attendees.createAttendees.labels.monthlyBenefit"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.monthlyBenefit" type="text"
                      v-model="form.monthly_benefit" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.monthly_benefit"></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.lastPlaceOfDuty"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.lastPlaceOfDuty" type="text"
                      v-model="form.last_place_of_duty" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.last_place_of_duty"></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.currentAddress"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.currentAddress" type="text"
                      v-model="form.current_address" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.current_address"></TextInputError>
                  </div>
                </div>

                <div class="w-full flex my-7">
                  <div class="w-1/3">
                    <InputLabel :value="l.attendees.createAttendees.labels.trainingConference"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.trainingConference" type="text"
                      v-model="form.training_conference" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.training_conference"></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.typeOfTeacher"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.typeOfTeacher" type="text"
                      v-model="form.type_of_teacher" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.type_of_teacher"></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.gradeAssigned"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.gradeAssigned" type="text"
                      v-model="form.grade_assigned" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.grade_assigned"></TextInputError>
                  </div>
                </div>

                <div class="w-full flex my-7">
                  <div class="w-1/3">
                    <InputLabel :value="l.attendees.createAttendees.labels.subjectAssigned"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.subjectAssigned" type="text"
                      v-model="form.subject_assigned" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.subject_assigned"></TextInputError>
                  </div>


                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesAge"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.attendeesAge" type="number"
                      v-model="form.age" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.age"></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesGender"></InputLabel>
                    <select v-model="form.gender"
                      class="py-2 px-4 pe-9 block w-full border-gray-200 dark:border-none rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3 dark:bg-gray-900">
                      <option value="">Open this select Gender</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>
                    <TextInputError :message="form.errors.name"></TextInputError>
                  </div>
                </div>


                <div class="w-full flex my-7">
                  <div class="w-1/3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesPhoneNumber"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.attendeesPhoneNumber" type="text"
                      v-model="form.phone_number" class="w-full mt-3 text-sm"></TextInput>
                    <TextInputError :message="form.errors.phone_number"></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesNRCNumber"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.attendeesNRCNumber" type="text"
                      v-model="form.nrc_number" class="w-full mt-3 text-sm"></TextInput>
                    <TextInputError :message="form.errors.nrc_number"></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesEducationBackground"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.attendeesEducationBackground"
                      type="text" v-model="form.edu_background" class="w-full mt-3 text-sm"></TextInput>
                    <TextInputError :message="form.errors.edu_background"></TextInputError>
                  </div>
                </div>

                <div class="w-full flex my-7">
                  <div class="w-1/3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesPosition"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.attendeesPosition" type="text"
                      v-model="form.position" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.position"></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesDepartment"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.attendeesDepartment" type="text"
                      v-model="form.department" class="w-full mt-3 text-sm"></TextInput>
                    <TextInputError :message="form.errors.department"></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesAddress"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.attendeesAddress" type="text"
                      v-model="form.address" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.address"></TextInputError>
                  </div>
                </div>

                <div class="w-full flex my-7">
                  <div class="w-1/3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesEmail"></InputLabel>
                    <TextInput :placeholder="l.attendees.createAttendees.placeholder.attendeesEmail" type="email"
                      v-model="form.email" class="w-full mt-3 text-sm">
                    </TextInput>
                    <TextInputError :message="form.errors.email"></TextInputError>
                  </div>
                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesType"></InputLabel>
                    <select placeholder="Attendees Type" v-model="form.attendees_types_id"
                      class="py-2 px-4 pe-9 block w-full border-gray-200 dark:border-none rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3 dark:bg-gray-900">
                      <option value="" selected="">
                        Open this attendees type
                      </option>

                      <option v-for="type in types" :key="type.id" :value="type.id">
                        {{ type.name }}
                      </option>
                    </select>
                    <TextInputError :message="form.errors.attendees_types_id"></TextInputError>
                  </div>

                  <div class="w-1/3 ms-3">
                    <InputLabel :value="l.attendees.createAttendees.labels.attendeesGroup"></InputLabel>
                    <select v-model="form.attendees_groups_id"
                      class="py-2 px-4 pe-9 block w-full border-gray-200 dark:border-none rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none mt-3 dark:bg-gray-900">
                      <option value="" selected="">
                        Open this attendees group
                      </option>

                      <option v-for="group in groups" :key="group.id" :value="group.id">
                        {{ group.name }}
                      </option>
                    </select>
                    <TextInputError :message="form.errors.attendees_groups_id"></TextInputError>
                  </div>
                </div>

                <div class="mt-5 w-full flex justify-end">
                  <Link href="/attendees/attendeesLists"
                    class="inline-flex items-center px-4 py-2 bg-slate-100 border border-transparent rounded-md font-semibold text-xs text-slate-800 uppercase tracking-widest hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                    {{ l.events.button.back }}</Link>

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
