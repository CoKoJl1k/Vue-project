<script setup>
import { ref } from 'vue'

const count = ref(0)
</script>

<template>
  <div>
    <h1>Главная</h1>
    <p>Счётчик: {{ count }}</p>
    <button @click="count++">+</button>
    <button @click="count--">-</button>
  </div>
</template>
