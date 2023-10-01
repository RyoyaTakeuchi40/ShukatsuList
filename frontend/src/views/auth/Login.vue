<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
const router = useRouter()

const showPassword = ref(false)
const email = ref('')
const password = ref('')

const login = () => {
  router.push({ path: '/' })
}

const register = () => { 
  router.push({ path: '/register' })
}
</script>

<template>
  <v-container>
    <v-card width="400px" class="mx-auto mt-5">
      <v-card-title> ログイン </v-card-title>
      <v-card-text>
        <v-form>
          <v-text-field
            type="email"
            prepend-icon="mdi-email"
            label="メールアドレス"
            v-model="email"
          />
          <v-text-field
            :type="showPassword ? 'text' : 'password'"
            prepend-icon="mdi-lock"
            :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
            @click:append-inner="showPassword = !showPassword"
            label="パスワード"
            v-model="password"
          />
          <v-row>
            <v-btn variant="text" @click="register">新規登録</v-btn>
            <v-spacer />
            <v-btn @click="login">ログイン</v-btn>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>
