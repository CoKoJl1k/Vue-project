import { defineStore } from 'pinia'

export const useNotesStore = defineStore('notes', {
  state: () => ({
    list: [
      { id: 1, title: 'Купить продукты', text: 'Молоко, хлеб, яйца' },
      { id: 2, title: 'Vue', text: 'Повторить emit и slots' },
    ],
    nextId: 3,
  }),
  getters: {
    sorted: (state) => [...state.list].reverse(),
  },
  actions: {
    add(title, text) {
      this.list.push({ id: this.nextId++, title, text })
    },
    remove(id) {
      this.list = this.list.filter((n) => n.id !== id)
    },
    update(id, title, text) {
      const note = this.list.find((n) => n.id === id)
      if (note) {
        note.title = title
        note.text = text
      }
    },
  },
})
