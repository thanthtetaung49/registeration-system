<script setup>
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import { defineComponent, ref } from "vue";
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from "vue-qrcode-reader";

defineComponent({ QrcodeStream, QrcodeDropZone, QrcodeCapture });

const code = ref(null);
const message = ref(null);

const onDetect = (detectedCodes) => {
  code.value = detectedCodes[0].rawValue;

  axios
    .post("/qrcode/scan", { code: code.value })
    .then((response) => {
      message.value = response.data.message;
    })
    .catch((error) => console.error(error));
};
</script>

<template>
  <div class="h-screen overflow-hidden">
    <div class="my-5 ms-10 w-full flex items-center">
      <button
        type="button"
        class="text-gray-700"
        aria-haspopup="dialog"
        aria-expanded="false"
        aria-controls="hs-offcanvas-example"
        data-hs-overlay="#hs-offcanvas-example"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="size-6"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"
          />
        </svg>
      </button>
      <div class="ms-5 text-bold text-blue-900 text-center"><span>Qr Code Scanner</span></div>
    </div>
    <div
      v-if="message"
      class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 dark:bg-teal-800/30"
      role="alert"
      tabindex="-1"
      aria-labelledby="hs-bordered-success-style-label"
    >
      <div class="flex">
        <div class="shrink-0">
          <!-- Icon -->
          <span
            class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400"
          >
            <svg
              class="shrink-0 size-4"
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path
                d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"
              ></path>
              <path d="m9 12 2 2 4-4"></path>
            </svg>
          </span>
          <!-- End Icon -->
        </div>
        <div class="ms-3">
          <h3
            id="hs-bordered-success-style-label"
            class="text-gray-800 font-semibold dark:text-white"
          >
            Successfully register.
          </h3>
          <p class="text-sm text-gray-700 dark:text-neutral-400">
            {{ message }}
          </p>
        </div>
      </div>
    </div>

    <div
      class=""
      style="
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        margin-top: 30px;
      "
    >
      <QrcodeStream
        @detect="onDetect"
        style="width: 300px; height: 300px; max-width: 100%"
      >
        <div v-if="boundingBox" class="bounding-box"></div>
      </QrcodeStream>
    </div>

    <!-- drawer -->
    <div
      id="hs-offcanvas-example"
      class="hs-overlay hs-overlay-open:translate-x-0 hidden -translate-x-full fixed top-0 start-0 transition-all duration-300 transform h-full max-w-xs w-full z-[80] bg-white border-e dark:bg-neutral-800 dark:border-neutral-700"
      role="dialog"
      tabindex="-1"
      aria-labelledby="hs-offcanvas-example-label"
    >
      <div
        class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700"
      >
        <h3
          id="hs-offcanvas-example-label"
          class="font-bold text-gray-800 dark:text-white"
        >
          Qr Code Scanner
        </h3>
        <button
          type="button"
          class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
          aria-label="Close"
          data-hs-overlay="#hs-offcanvas-example"
        >
          <span class="sr-only">Close</span>
          <svg
            class="shrink-0 size-4"
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
      <div class="p-4">
        <p class="text-gray-800 dark:text-neutral-400 text-sm border-b pb-5">
          Our web application features a powerful QR code scanner integrated seamlessly using the latest web technologies. The QR code scanner allows you to quickly and accurately scan QR codes directly from your device's camera.
        </p>
        <div class="mt-5 w-full">
            <Link :href="route('logout')" as="button" method="post" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Logout</Link>
        </div>
      </div>
    </div>
  </div>
</template>
