import { ref } from 'vue'

const isDark = ref(false)

export function useTheme() {
  function toggle() {
    isDark.value = !isDark.value
    document.documentElement.setAttribute('data-theme', isDark.value ? 'dark' : 'light')
  }

  return { isDark, toggle }
}
