<script setup>
import { ref, computed } from 'vue'

const form = ref({
  name: '',
  email: '',
  password: '',
  confirm: '',
})

const errors = ref({})

function validate() {
  errors.value = {}

  if (!form.value.name.trim()) {
    errors.value.name = 'Имя обязательно'
  }
  if (!form.value.email.includes('@')) {
    errors.value.email = 'Некорректный email'
  }
  if (form.value.password.length < 6) {
    errors.value.password = 'Пароль минимум 6 символов'
  }
  if (form.value.password !== form.value.confirm) {
    errors.value.confirm = 'Пароли не совпадают'
  }

  return !Object.keys(errors.value).length
}

function handleSubmit() {
  if (!validate()) return
  alert('Регистрация успешна!')
}
</script>

<template>
  <div class="register">
    <h1>Регистрация</h1>
    <form @submit.prevent="handleSubmit">
      <label>Имя</label>
      <input v-model.trim="form.name" />
      <span v-if="errors.name" class="error">{{ errors.name }}</span>

      <label>Email</label>
      <input v-model="form.email" type="email" />
      <span v-if="errors.email" class="error">{{ errors.email }}</span>

      <label>Пароль</label>
      <input v-model="form.password" type="password" />
      <span v-if="errors.password" class="error">{{ errors.password }}</span>

      <label>Подтверждение</label>
      <input v-model="form.confirm" type="password" />
      <span v-if="errors.confirm" class="error">{{ errors.confirm }}</span>

      <button type="submit">Зарегистрироваться</button>
    </form>
  </div>
</template>

<style scoped>
.register {
  max-width: 400px;
  margin: 2rem 0;
}
label {
  display: block;
  margin-top: 1rem;
  font-weight: 500;
}
input {
  width: 100%;
  padding: 6px 10px;
  margin-top: 4px;
  box-sizing: border-box;
}
.error {
  color: red;
  font-size: 0.85rem;
}
button {
  margin-top: 1.5rem;
  padding: 8px 24px;
}
</style>
