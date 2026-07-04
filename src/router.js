import { createRouter, createWebHistory } from 'vue-router'
import HomePage from './pages/HomePage.vue'
import ProductsPage from './pages/ProductsPage.vue'
import CartPage from './pages/CartPage.vue'
import RegisterPage from './pages/RegisterPage.vue'

const routes = [
  { path: '/', component: HomePage },
  { path: '/products', component: ProductsPage },
  { path: '/cart', component: CartPage },
  { path: '/register', component: RegisterPage },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
