<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue'

const query = ref('')
const debouncedQuery = ref('')
let timer = null

watch(query, (val) => {
  clearTimeout(timer)
  timer = setTimeout(() => {
    debouncedQuery.value = val
  }, 300)
})

onMounted(() => {
  console.log('SearchInput смонтирован')
})

onUnmounted(() => {
  clearTimeout(timer)
  console.log('SearchInput размонтирован')
})
</script>

<template>
  <div class="search">
    <input v-model="query" placeholder="Поиск..." />
    <p>Сейчас: {{ query }}</p>
    <p>С задержкой: {{ debouncedQuery }}</p>
  </div>
</template>

<style scoped>
.search {
  margin: 1rem 0;
}
input {
  padding: 6px 12px;
  font-size: 1rem;
  width: 250px;
}
</style>
