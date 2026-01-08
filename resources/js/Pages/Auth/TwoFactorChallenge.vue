<script setup>
import { onMounted, ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    code: '',
    recovery_code: '',
})

const useRecoveryCode = ref(false)

const submit = () => {
    form.post('/two-factor-challenge')
}
</script>

<template>
    <Head title="Two Factor Challenge" />

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-6 rounded shadow">
            <h1 class="text-xl font-semibold mb-4 text-center">
                Two Factor Authentication
            </h1>

            <p class="text-sm text-gray-600 mb-4 text-center">
                Please confirm access to your account by entering the authentication code.
            </p>

            <!-- OTP -->
            <form @submit.prevent="submit">
                <div v-if="!useRecoveryCode">
                    <input
                        v-model="form.code"
                        type="text"
                        placeholder="Authentication code"
                        class="w-full border rounded px-3 py-2 mb-3"
                    />
                </div>

                <!-- Recovery Code -->
                <div v-else>
                    <input
                        v-model="form.recovery_code"
                        type="text"
                        placeholder="Recovery code"
                        class="w-full border rounded px-3 py-2 mb-3"
                    />
                </div>

                <PrimaryButton type="submit" class="w-full flex justify-center items-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirm
                </PrimaryButton>
            </form>

            <button
                class="mt-4 text-sm text-blue-600 underline w-full"
                @click="useRecoveryCode = !useRecoveryCode"
            >
                {{ useRecoveryCode
                    ? 'Use authentication code'
                    : 'Use recovery code' }}
            </button>
        </div>
    </div>
</template>
