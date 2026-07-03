<script setup>
defineProps({
  show: Boolean,
})

const emit = defineEmits(['close'])
</script>

<template>
  <Teleport to="body">
    <div v-if="show" class="overlay" @click.self="emit('close')">
      <div class="modal">
        <button class="close" @click="emit('close')">×</button>
        <slot />
      </div>
    </div>
  </Teleport>
</template>

<style scoped>
.overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal {
  background: #fff;
  padding: 2rem;
  border-radius: 8px;
  min-width: 300px;
  position: relative;
}
.close {
  position: absolute;
  top: 8px;
  right: 12px;
  font-size: 1.4rem;
  border: none;
  background: none;
  cursor: pointer;
}
</style>
