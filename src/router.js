import { createRouter, createWebHashHistory } from 'vue-router'
import NotesPage from './pages/NotesPage.vue'
import HomePage from './pages/HomePage.vue'
import CurrencyPage from "@/pages/CurrencyPage.vue";

const routes = [
  { path: '/', component: HomePage },
  { path: '/notes', component: NotesPage },
  { path: '/currency', component: CurrencyPage },
]

export default createRouter({
  history: createWebHashHistory(),
  routes,
})
