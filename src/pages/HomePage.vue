<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const slides = ref([
  {
    title: 'Super IT',
    subtitle: 'Технологии будущего уже сегодня',
    img: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80',
  },
  {
    title: 'Разработка ПО',
    subtitle: 'Веб, мобильные приложения, API',
    img: 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?w=800&q=80',
  },
  {
    title: 'Облачные решения',
    subtitle: 'AWS, Azure, Google Cloud',
    img: 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=800&q=80',
  },
  {
    title: 'Кибербезопасность',
    subtitle: 'Защита данных и инфраструктуры',
    img: 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=800&q=80',
  },
])

const current = ref(0)
let timer = null

onMounted(() => {
  timer = setInterval(() => {
    current.value = (current.value + 1) % slides.value.length
  }, 5000)
})

onUnmounted(() => {
  clearInterval(timer)
})
</script>

<template>
  <div class="home">
    <div class="hero" :style="{ backgroundImage: `url(${slides[current].img})` }">
      <div class="overlay">
        <h1>{{ slides[current].title }}</h1>
        <p>{{ slides[current].subtitle }}</p>
        <div class="dots">
          <span
            v-for="(slide, i) in slides"
            :key="i"
            :class="{ active: i === current }"
            @click="current = i"
          />
        </div>
      </div>
    </div>

    <section class="about">
      <h2>О компании</h2>
      <p>
        Super IT — ведущий поставщик IT-решений с 2015 года.
        Мы создаём продукты, которые меняют бизнес.
      </p>
    </section>

    <section class="services">
      <div class="card">
        <h3>🚀 Разработка</h3>
        <p>Веб-сайты, SPA, мобильные приложения под ключ</p>
      </div>
      <div class="card">
        <h3>☁️ Облака</h3>
        <p>Миграция, оптимизация, поддержка облачной инфраструктуры</p>
      </div>
      <div class="card">
        <h3>🔒 Безопасность</h3>
        <p>Аудит, мониторинг, защита от атак</p>
      </div>
    </section>
  </div>
</template>

<style scoped>
.home {
  max-width: 800px;
}
.hero {
  border-radius: 12px;
  min-height: 350px;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  transition: background-image 0.8s;
  margin-bottom: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
.overlay {
  background: rgba(0, 0, 0, 0.45);
  padding: 3rem 2rem;
  border-radius: 12px;
  text-align: center;
  color: #fff;
  width: 100%;
}
.hero h1 {
  font-size: 2.5rem;
  margin: 0 0 0.5rem;
}
.hero p {
  font-size: 1.2rem;
  opacity: 0.9;
}
.dots {
  margin-top: 1.5rem;
  display: flex;
  justify-content: center;
  gap: 8px;
}
.dots span {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: rgba(255,255,255,0.4);
  cursor: pointer;
  transition: background 0.3s;
}
.dots span.active {
  background: #fff;
}
.about {
  margin-bottom: 2rem;
}
.services {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}
.card {
  flex: 1;
  min-width: 200px;
  border: 1px solid var(--border);
  padding: 1.5rem;
  border-radius: 10px;
  background: var(--bg);
}
.card h3 {
  margin-top: 0;
}
</style>
