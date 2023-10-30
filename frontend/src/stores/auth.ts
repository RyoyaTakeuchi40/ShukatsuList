import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', () => {
  const name = ref('')
  const email = ref('')
  const userId = ref('')
  
  const changeName = computed(() => name.value = '竹内綾哉')
  
  function changeUserId() {
    userId.value = 'SOS'
  }

  return { name, email, userId, changeName, changeUserId }
})