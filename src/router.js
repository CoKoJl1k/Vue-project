import { createRouter, createWebHistory } from 'vue-router'
import NotesPage from './pages/NotesPage.vue'
import MainPage from './pages/MainPage.vue'

const routes = [
  { path: '/', component: MainPage },
  { path: '/notes', component: NotesPage },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
