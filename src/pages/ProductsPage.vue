<script setup>
import { ref } from 'vue'
import ProductCard from '../components/ProductCard.vue'

const products = ref([
  { id: 1, name: 'Ноутбук', price: 75000, description: '16 ГБ ОЗУ, SSD 512 ГБ' },
  { id: 2, name: 'Мышь', price: 2500, description: 'Беспроводная, тихие клики' },
  { id: 3, name: 'Клавиатура', price: 5000, description: 'Механическая, RGB' },
])
</script>

<template>
  <div>
    <h1>Товары</h1>
    <div class="products">
      <ProductCard v-for="product in products" :key="product.id" :product="product" />
    </div>
  </div>
</template>

<style scoped>
.products { display: flex; gap: 1rem; flex-wrap: wrap; }
</style>
