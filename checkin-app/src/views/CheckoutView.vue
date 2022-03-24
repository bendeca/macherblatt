<script setup>
import Checkout from '@/components/Checkout.vue'
</script>

<template>
  <div class="header">
    Checkout
  </div>
  <checkout :userId="$route.query.userId"/>
</template>

<style>
@import '@/assets/base.css';
</style>
