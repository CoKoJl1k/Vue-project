import { createRouter, createWebHistory } from 'vue-router'
import HomePage from './pages/HomePage.vue'
import ProductsPage from './pages/ProductsPage.vue'
import CartPage from './pages/CartPage.vue'

const routes = [
  { path: '/', component: HomePage },
  { path: '/products', component: ProductsPage },
  { path: '/cart', component: CartPage },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
