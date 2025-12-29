<script setup>
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import { defineComponent, ref } from "vue";
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from "vue-qrcode-reader";

defineComponent({ QrcodeStream, QrcodeDropZone, QrcodeCapture });

const props = defineProps({ user: Object });
const auth = props.user;

const code = ref(null);
const successMessage = ref(null);
const alreadyRegisterMessage = ref(null);
const notRegisterMessage = ref(null);

const paused = ref(false);
const errorMessage = ref("");

const showScanConfirmation = ref(false);

const selectedConstraints = ref({ facingMode: 'environment' })

const onDetect = async (detectedCodes) => {
  console.log("detectedCodes:", detectedCodes);

  if (paused.value) {
    return;
  }

  code.value = detectedCodes[0].rawValue;
  paused.value = true;
  // await new Promise((resolve) => setTimeout(resolve, 3000));

  try {
    auth.is_admin == 2 ? await securityScan() : await selfCheckinUserScan();
  } catch (error) {
    console.error("Error during scan processing:", error);
  } finally {
    setTimeout(() => {
      paused.value = false;
    }, 2000);
  }

  // auth.is_admin == 2 ? securityScan() : selfCheckinUserScan();
  // paused.value = false;
};

// security function
const securityScan = () => {
  console.log("security scan is working");
  axios
    .post("/selfCheckInUser/security/QRCode/scan", { code: code.value })
    .then((response) => {
      console.log(response.data);
      let setSuccessMessage = response.data.successMessage;
      let setAlreadyRegisterMessage = response.data.alreadyRegisterMessage;
      let setNotRegisterMessage = response.data.notRegisterMessage;

      if (setSuccessMessage) {
        successMessage.value = setSuccessMessage;

        setTimeout(() => {
          successMessage.value = null;
        }, 3000);
      } else if (setAlreadyRegisterMessage) {
        alreadyRegisterMessage.value = setAlreadyRegisterMessage;

        setTimeout(() => {
          alreadyRegisterMessage.value = null;
        }, 3000);
      } else {
        notRegisterMessage.value = setNotRegisterMessage;

        setTimeout(() => {
          notRegisterMessage.value = null;
        }, 3000);
      }
    })
    .catch((error) => console.error(error));
};

// self check-in user scan
const selfCheckinUserScan = () => {
  console.log("self check in work");
  axios
    .post("/selfCheckInUser/attendees/QRCode/scan", {
      code: code.value,
      authId: auth.id,
    })
    .then((response) => {
      console.log(response);
      let setSuccessMessage = response.data.successMessage;
      let setAlreadyRegisterMessage = response.data.alreadyRegisterMessage;
      let setNotRegisterMessage = response.data.notRegisterMessage;

      if (setSuccessMessage) {
        successMessage.value = setSuccessMessage;

        setTimeout(() => {
          successMessage.value = null;
        }, 3000);
      } else if (setAlreadyRegisterMessage) {
        alreadyRegisterMessage.value = setAlreadyRegisterMessage;

        setTimeout(() => {
          alreadyRegisterMessage.value = null;
        }, 3000);
      } else {
        notRegisterMessage.value = setNotRegisterMessage;

        setTimeout(() => {
          notRegisterMessage.value = null;
        }, 3000);
      }
    })
    .catch((error) => console.error(error));
};

// track function
const paintBoundingBox = (detectedCodes, ctx) => {
  for (const detectedCode of detectedCodes) {
    const {
      boundingBox: { x, y, width, height },
    } = detectedCode;

    ctx.lineWidth = 2;
    ctx.strokeStyle = "#007bff";
    ctx.strokeRect(x, y, width, height);
  }
};
// track function

// error function
const onError = (err) => {
  errorMessage.value = `[${err.name}] `

  if (err.name === "NotAllowedError") {
    errorMessage.value += "You need to grant camera permission"
  } else if (err.name === "NotFoundError") {
    errorMessage.value += "No camera found on this device"
  } else if (err.name === "NotSupportedError") {
    errorMessage.value += "Secure context required (HTTPS or localhost)"
  } else if (err.name === "NotReadableError") {
    errorMessage.value += "Camera already in use"
  } else if (err.name === "OverconstrainedError") {
    errorMessage.value += "Camera does not meet constraints"
  } else if (err.name === "StreamApiNotSupportedError") {
    errorMessage.value += "Browser does not support MediaStream API"
  } else if (err.name === "InsecureContextError") {
    errorMessage.value += "Camera only works on HTTPS or localhost"
  } else {
    errorMessage.value += err.message
  }

  console.error(err)
};
// error function

// camera function
const onCameraOn = () => {
  showScanConfirmation.value = false;
};

const onCameraOff = () => {
  showScanConfirmation.value = true;
};

// camera function
</script>

<template>
  <div class="h-screen overflow-hidden">
    <div class="my-5 ms-7 w-full flex items-center">
      <div class="text-bold text-blue-900 text-center">
        <span>Scanner</span>
      </div>
    </div>
    <Transition name="slide-fade">
      <!-- success message -->
      <div v-if="successMessage" class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 dark:bg-teal-800/30"
        role="alert" tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
        <div class="flex">
          <div class="shrink-0">
            <!-- Icon -->
            <span
              class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
              <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                <path d="m9 12 2 2 4-4"></path>
              </svg>
            </span>
            <!-- End Icon -->
          </div>
          <div class="ms-3">
            <h3 id="hs-bordered-success-style-label" class="text-gray-800 font-semibold dark:text-white">
              Successfully register.
            </h3>
            <p class="text-sm text-gray-700 dark:text-neutral-400">
              {{ successMessage }}
            </p>
          </div>
        </div>
      </div>
    </Transition>

    <Transition>
      <!-- already register message -->
      <div v-if="alreadyRegisterMessage"
        class="bg-yellow-50 border-t-2 border-yellow-500 rounded-lg p-4 dark:bg-yellow-800/30" role="alert"
        tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
        <div class="flex">
          <div class="shrink-0">
            <!-- Icon -->
            <span
              class="inline-flex justify-center items-center size-8 rounded-full border-4 border-yellow-100 bg-yellow-200 text-yellow-800 dark:border-yellow-900 dark:bg-yellow-800 dark:text-yellow-400">
              <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                <path d="m9 12 2 2 4-4"></path>
              </svg>
            </span>
            <!-- End Icon -->
          </div>
          <div class="ms-3">
            <h3 id="hs-bordered-success-style-label" class="text-gray-800 font-semibold dark:text-white">
              Already register.
            </h3>
            <p class="text-sm text-gray-700 dark:text-neutral-400">
              {{ alreadyRegisterMessage }}
            </p>
          </div>
        </div>
      </div>
    </Transition>

    <Transition>
      <!-- not register -->
      <div v-if="notRegisterMessage" class="bg-red-50 border-t-2 border-red-500 rounded-lg p-4 dark:bg-red-800/30"
        role="alert" tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
        <div class="flex">
          <div class="shrink-0">
            <!-- Icon -->
            <span
              class="inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800 dark:border-red-900 dark:bg-red-800 dark:text-red-400">
              <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                <path d="m9 12 2 2 4-4"></path>
              </svg>
            </span>
            <!-- End Icon -->
          </div>
          <div class="ms-3">
            <h3 id="hs-bordered-success-style-label" class="text-gray-800 font-semibold dark:text-white">
              Not register.
            </h3>
            <p class="text-sm text-gray-700 dark:text-neutral-400">
              {{ notRegisterMessage }}
            </p>
          </div>
        </div>
      </div>
    </Transition>

    <Transition>
      <!-- not register -->
      <div v-if="errorMessage" class="bg-red-50 border-t-2 border-red-500 rounded-lg p-4 dark:bg-red-800/30"
        role="alert" tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
        <div class="flex">
          <div class="shrink-0">
            <!-- Icon -->
            <span
              class="inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800 dark:border-red-900 dark:bg-red-800 dark:text-red-400">
              <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                <path d="m9 12 2 2 4-4"></path>
              </svg>
            </span>
            <!-- End Icon -->
          </div>
          <div class="ms-3">
            <h3 id="hs-bordered-success-style-label" class="text-gray-800 font-semibold dark:text-white">
              Error occurred.
            </h3>
            <p class="text-sm text-gray-700 dark:text-neutral-400">
              {{ errorMessage }}
            </p>
          </div>
        </div>
      </div>
    </Transition>

    <div class="w-full flex justify-center mt-20">
      <QrcodeStream @detect="onDetect" :paused="paused" :track="paintBoundingBox" @camera-on="onCameraOn"
        @camera-off="onCameraOff" @error="onError" class="w-80 h-80" :constraints="selectedConstraints">
        <div v-if="boundingBox" class="bounding-box"></div>
      </QrcodeStream>
    </div>

    <div class="px-10 pb-5 mt-10">
      <p class="text-gray-800 dark:text-neutral-400 text-sm border-b pb-5">
        Our web application features a powerful QR code scanner integrated seamlessly
        using the latest web technologies. The QR code scanner allows you to quickly and
        accurately scan QR codes directly from your device's camera.
      </p>
      <div class="mt-5 w-full flex justify-end">
        <Link :href="route('logout')" as="button" method="post"
          class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
          Logout</Link>
      </div>
    </div>
  </div>
</template>

<style>
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>
