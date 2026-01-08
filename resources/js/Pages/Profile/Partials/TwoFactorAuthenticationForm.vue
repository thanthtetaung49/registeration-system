<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router, useForm, usePage } from '@inertiajs/vue3'
import axios from 'axios';
import { computed, ref } from 'vue';

const page = usePage();
let user = computed(() => page.props.auth.user);

const enableForm = useForm({})
const disableForm = useForm({})

const recoveryCodes = ref([]);
const showingCodes = ref(false);


const enable2FA = () => {
    enableForm.post('/user/two-factor-authentication', {
        preserveScroll: true
    })
}

const disable2FA = () => {
    disableForm.delete('/user/two-factor-authentication', {
        preserveScroll: true
    })
}

const showRecoveryCodes = () => {
    axios.get('/user/two-factor-recovery-codes')
        .then(response => {
            recoveryCodes.value = response.data;
            showingCodes.value = true;
        })
        .catch(error => {
            if (error.response && error.response.status === 423) {
                router.get(route('password.confirm'));
            }
        });
}

</script>

<template>
    <section class="border rounded p-6 w-full flex">
        <div class="w-1/2">
            <h2 class="text-lg font-semibold mb-2">
                Two Factor Authentication
            </h2>

            <p class="text-sm text-gray-600 mb-4">
                Add additional security to your account using an authenticator app.
            </p>

            <PrimaryButton @click="enable2FA" v-if="!user.two_factor_secret" :disabled="enableForm.processing">Enable
            </PrimaryButton>

            <div v-else>
                <p class="text-sm text-gray-600 mb-2">
                    Scan this QR code using Google Authenticator or Microsoft Authenticator.
                </p>

                <div v-html="user.two_factor_qr_code_svg"></div>

                <div class="mt-5">
                    <DangerButton :class="{ 'opacity-25': disableForm.processing }" :disabled="disableForm.processing"
                        @click="disable2FA">
                        Disable
                    </DangerButton>
                </div>
            </div>
        </div>

        <div class="w-1/2">
            <h2 class="text-lg font-semibold mb-2">
                Recovery Code
            </h2>


            <div v-if="showingCodes" class="bg-gray-100 p-4 rounded">
                <p class="text-sm text-red-500 mb-4">
                    Please Copy and don't forget
                </p>
                <div class="grid grid-cols-2 gap-2">
                    <p v-for="code in recoveryCodes" :key="code" class="text-sm">
                        {{ code }}
                    </p>
                </div>
            </div>

            <div v-else>
                <PrimaryButton @click="showRecoveryCodes">Show Recovery Codes
                </PrimaryButton>
            </div>
        </div>
    </section>
</template>
