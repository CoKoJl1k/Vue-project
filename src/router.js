import { createRouter, createWebHistory } from 'vue-router'
import NotesPage from './pages/NotesPage.vue'

const routes = [
  { path: '/', redirect: '/notes' },
  { path: '/notes', component: NotesPage },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
