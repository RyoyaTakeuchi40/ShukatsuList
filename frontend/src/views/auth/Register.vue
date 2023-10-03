<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
const router = useRouter()

const showPassword = ref(false)
const username = ref('')
const email = ref('')
const password = ref('')

function login() {
  router.push({ path: '/login' })
}

function register() {
  router.push({ path: '/' })
}
</script>

<template>
  <v-container>
    <v-card width="400px" class="mx-auto mt-5">
      <v-card-title> 新規登録 </v-card-title>
      <v-card-text>
        <v-form>
          <v-text-field
            prepend-icon="mdi-account-circle"
            label="ユーザー名"
            v-model="username"
          />
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
            <v-btn variant="text" @click="login">戻る</v-btn>
            <v-spacer />
            <v-btn @click="register">登録</v-btn>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>
