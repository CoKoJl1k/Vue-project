import { createRouter, createWebHistory } from 'vue-router'
import NotesPage from './pages/NotesPage.vue'
import HomePage from './pages/HomePage.vue'

const routes = [
  { path: '/', component: HomePage },
  { path: '/notes', component: NotesPage },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
