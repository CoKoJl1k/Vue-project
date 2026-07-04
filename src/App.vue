<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header>
    <nav>
      <RouterLink to="/">Главная</RouterLink>
      <RouterLink to="/products">Товары</RouterLink>
      <RouterLink to="/cart">Корзина</RouterLink>
      <RouterLink to="/register">Регистрация</RouterLink>
    </nav>
  </header>

  <main>
    <RouterView />
  </main>
</template>

<style scoped>
nav {
  display: flex;
  gap: 1rem;
  padding: 1rem;
  border-bottom: 1px solid #ccc;
}
a {
  text-decoration: none;
  color: #2c3e50;
  font-weight: 500;
}
a.router-link-active {
  color: #42b883;
}
</style>
