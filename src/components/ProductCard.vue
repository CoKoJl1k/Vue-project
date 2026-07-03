<script setup>
const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['add-to-cart'])

function formatPrice(price) {
  return price.toLocaleString('ru-RU') + ' ₽'
}
</script>

<template>
  <div class="card">
    <h3>{{ product.name }}</h3>
    <p class="price">{{ formatPrice(product.price) }}</p>
    <p>{{ product.description }}</p>
    <button @click="emit('add-to-cart', product.id)">В корзину</button>
  </div>
</template>

<style scoped>
.card {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 1rem;
  width: 250px;
}
.price {
  font-size: 1.4rem;
  font-weight: bold;
  color: #2c3e50;
}
button {
  margin-top: 8px;
  padding: 6px 16px;
  cursor: pointer;
}
</style>
