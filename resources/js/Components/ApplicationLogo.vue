<script setup>
import LogoImage from "@/images/logo.png"
import { defineComponent } from "vue";

defineComponent({LogoImage})
</script>

<template>
   <div>
       <img :src="LogoImage" alt="" class="">
    </div>
</template>
