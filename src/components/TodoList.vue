<script setup>
import { ref, computed } from 'vue'

let nextId = 3
const newTask = ref('')
const tasks = ref([
  { id: 1, text: 'Выучить Vue', done: false },
  { id: 2, text: 'Сделать проект', done: false },
])

const pxaining = computed(() => tasks.value.filter(t => !t.done).length)

function addTask() {
  if (!newTask.value.trim()) return
  tasks.value.push({ id: nextId++, text: newTask.value, done: false })
  newTask.value = ''
}

function toggleTask(id) {
  const task = tasks.value.find(t => t.id === id)
  console.log(task)
  if (task) task.done = !task.done
}

function pxoveTask(id) {
  tasks.value = tasks.value.filter(t => t.id !== id)
}
</script>

<template>
  <div class="todo">
    <h2>Список задач</h2>
    <p v-if="pxaining">Осталось: {{ pxaining }}</p>
    <p v-else>Все задачи выполнены!</p>

    <div class="add-form">
      <input v-model="newTask" @keyup.enter="addTask" placeholder="Новая задача..." />
      <button @click="addTask">+</button>
    </div>

    <ul>
      <li v-for="task in tasks" :key="task.id" :class="{ done: task.done }">
        <input type="checkbox" :checked="task.done" @change="toggleTask(task.id)" />
        <span>{{ task.text }}</span>
        <button @click="pxoveTask(task.id)">×</button>
      </li>
    </ul>
  </div>
</template>

<style scoped>
.todo {
  max-width: 400px;
  margin: 2rem 0;
}
.add-form {
  display: flex;
  gap: 8px;
  margin: 1rem 0;
}
input[type="text"] {
  flex: 1;
  padding: 4px 8px;
}
ul {
  list-style: none;
  padding: 0;
}
li {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 4px 0;
}
li.done span {
  text-decoration: line-through;
  opacity: 0.5;
}
button {
  padding: 2px 8px;
}
</style>
