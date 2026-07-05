<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { useTheme } from './composables/useTheme.js'

const theme = useTheme()
</script>

<template>
  <div :class="{ dark: theme.isDark.value }">
    <header>
      <nav>
        <RouterLink to="/">Главная</RouterLink>
        <RouterLink to="/currency">Курсы валют</RouterLink>
        <RouterLink to="/notes">Заметки</RouterLink>
        <button @click="theme.toggle">
          {{ theme.isDark.value ? '☀️' : '🌙' }}
        </button>
      </nav>
    </header>

    <main>
      <RouterView />
    </main>
  </div>
</template>

<style>
body {
  background: var(--bg);
  color: var(--text);
  transition: background 0.3s, color 0.3s;
  --bg: #fff;
  --text: #2c3e50;
  --border: #ccc;
}
body:has(.dark) {
  --bg: #1a1a2e;
  --text: #eee;
  --border: #444;
}
</style>

<style scoped>
nav {
  display: flex;
  gap: 1rem;
  padding: 1rem;
  border-bottom: 1px solid var(--border);
  align-items: center;
}
a {
  text-decoration: none;
  color: var(--text);
  font-weight: 500;
}
a.router-link-active {
  color: #42b883;
}
button {
  margin-left: auto;
  font-size: 1.3rem;
  background: none;
  border: 1px solid var(--border);
  border-radius: 6px;
  padding: 4px 10px;
  cursor: pointer;
}
</style>
