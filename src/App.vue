<script setup>
import { ref } from 'vue'
import TodoList from './components/TodoList.vue'
import ProductCard from './components/ProductCard.vue'
import ModalWindow from './components/ModalWindow.vue'

const count = ref(0)
const cart = ref([])
const showModal = ref(false)

const products = ref([
  { id: 1, name: 'Ноутбук', price: 75000, description: '16 ГБ ОЗУ, SSD 512 ГБ' },
  { id: 2, name: 'Мышь', price: 2500, description: 'Беспроводная, тихие клики' },
  { id: 3, name: 'Клавиатура', price: 5000, description: 'Механическая, RGB' },
])

function addToCart(productId) {
  const product = products.value.find(p => p.id === productId)
  cart.value.push(product)
}
</script>

<template>
  <header>
    <div class="wrapper">
      <p>Счётчик: {{ count }}</p>
      <button @click="count++">+</button>
      <button @click="count--">-</button>
    </div>
  </header>

  <section class="cart">
    <h2>Корзина ({{ cart.length }})</h2>
    <div class="products">
      <ProductCard
        v-for="item in cart"
        :key="item.id"
        :product="item"
      />
    </div>
  </section>

  <main>
    <TodoList />
    <hr />
    <h2>Товары</h2>
    <div class="products">
      <ProductCard
        v-for="product in products"
        :key="product.id"
        :product="product"
        @add-to-cart="addToCart"
      />
    </div>

    <button class="modal-btn" @click="showModal = true">Показать модалку</button>

    <ModalWindow :show="showModal" @close="showModal = false">
      <h2>Привет!</h2>
      <p>Это содержимое модального окна через слот.</p>
    </ModalWindow>
  </main>

</template>

<style scoped>
button {
  margin: 0 4px;
  padding: 4px 12px;
  font-size: 1.2rem;
}
.products {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
  margin-top: 1rem;
}
hr {
  margin: 2rem 0;
}
</style>
