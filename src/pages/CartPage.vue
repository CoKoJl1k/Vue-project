<script setup>
import { ref } from 'vue'
import ProductCard from '../components/ProductCard.vue'

const cart = ref([])

function addToCart(product) {
  cart.value.push(product)
}
</script>

<template>
  <div>
    <h1>Корзина ({{ cart.length }})</h1>
    <div class="products">
      <ProductCard v-for="item in cart" :key="item.id" :product="item" />
    </div>
    <p v-if="!cart.length">Корзина пуста</p>
  </div>
</template>

<style scoped>
.products { display: flex; gap: 1rem; flex-wrap: wrap; }
</style>
