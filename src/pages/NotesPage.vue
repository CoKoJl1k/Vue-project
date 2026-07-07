<script setup>
import { ref, computed } from 'vue'
import { useNotesStore } from '../stores/notes.js'
import ModalWindow from '../components/ModalWindow.vue'

const store = useNotesStore()

const query = ref('')
const newTitle = ref('')
const newText = ref('')

const editTitle = ref('')
const editText = ref('')
const editId = ref(null)
const showEditModal = ref(false)

const showDeleteModal = ref(false)
const deleteId = ref(null)

const filtered = computed(() => {
  if (!query.value.trim()) return store.sorted
  const q = query.value.toLowerCase()
  return store.sorted.filter(
    (n) => n.title.toLowerCase().includes(q) || n.text.toLowerCase().includes(q),
  )
})

function addNote() {
  if (!newTitle.value.trim()) return
  store.add(newTitle.value, newText.value)
  newTitle.value = ''
  newText.value = ''
}

function openEditModal(note) {
  editId.value = note.id
  editTitle.value = note.title
  editText.value = note.text
  showEditModal.value = true
}

function saveNote() {
  if (!editTitle.value.trim()) return
  store.update(editId.value, editTitle.value, editText.value)
  showEditModal.value = false
  editId.value = null
}

function openDeleteModal(id) {
  deleteId.value = id
  showDeleteModal.value = true
}

function deleteNote() {
  store.remove(deleteId.value)
  showDeleteModal.value = false
  deleteId.value = null
}
</script>

<template>
  <div class="notes-page">
    <h1>Заметки</h1>

    <input v-model="query" placeholder="Поиск..." class="search" />

    <div class="form">
      <h3>Новая заметка</h3>
      <input v-model="newTitle" placeholder="Заголовок" />
      <textarea v-model="newText" placeholder="Текст" />
      <button @click="addNote">Добавить</button>
    </div>

    <div class="notes-list">
      <div v-for="note in filtered" :key="note.id" class="note">
        <div>
          <h3>{{ note.title }}</h3>
          <p>{{ note.text }}</p>
        </div>
        <div class="note-actions">
          <button @click="openEditModal(note)">✏️</button>
          <button class="remove" @click="openDeleteModal(note.id)">🗑️</button>
        </div>
      </div>
      <p v-if="!filtered.length" class="empty">Нет заметок</p>
    </div>

    <ModalWindow :show="showEditModal" @close="showEditModal = false">
      <h2>Редактировать</h2>
      <input v-model="editTitle" placeholder="Заголовок" class="modal-input" />
      <textarea v-model="editText" placeholder="Текст" class="modal-input" />
      <div class="modal-actions">
        <button @click="saveNote">Сохранить</button>
        <button class="cancel" @click="showEditModal = false">Отмена</button>
      </div>
    </ModalWindow>

    <ModalWindow :show="showDeleteModal" @close="showDeleteModal = false">
      <h2>Удалить заметку?</h2>
      <p>Это действие нельзя отменить.</p>
      <button class="remove" @click="deleteNote">Удалить</button>
      <button @click="showDeleteModal = false">Отмена</button>
    </ModalWindow>
  </div>
</template>

<style scoped>
.notes-page {
  max-width: 600px;
}
.search {
  width: 100%;
  padding: 6px 10px;
  margin: 1rem 0;
  box-sizing: border-box;
  background: var(--bg);
  color: var(--text);
  border: 1px solid var(--border);
}
.form {
  border: 1px solid var(--border);
  padding: 1rem;
  border-radius: 6px;
  margin-bottom: 1rem;
}
.form input, .form textarea {
  width: 100%;
  padding: 6px;
  margin-top: 6px;
  box-sizing: border-box;
  background: var(--bg);
  color: var(--text);
  border: 1px solid var(--border);
}
.form textarea {
  min-height: 80px;
  resize: vertical;
}
.form-actions {
  display: flex;
  gap: 8px;
  margin-top: 8px;
}
.notes-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.note {
  border: 1px solid var(--border);
  padding: 0.8rem;
  border-radius: 6px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}
.note h3, .note p {
  margin: 0 0 4px;
}
.note-actions {
  display: flex;
  gap: 4px;
  flex-shrink: 0;
}
button {
  padding: 4px 12px;
}
.remove {
  background: var(--btn, #ccc);
  border: none;
  border-radius: 8px;
}
.cancel {
  background: var(--btn, #ccc);
  border: none;
  border-radius: 8px;
}
.empty {
  color: #999;
  text-align: center;
}
.modal-input {
  width: 100%;
  padding: 6px;
  margin-top: 8px;
  box-sizing: border-box;
  background: var(--bg);
  color: var(--text);
  border: 1px solid var(--border);
}
.modal-input textarea {
  min-height: 80px;
  resize: vertical;
}
.modal-actions {
  display: flex;
  gap: 8px;
  margin-top: 12px;
}
</style>
