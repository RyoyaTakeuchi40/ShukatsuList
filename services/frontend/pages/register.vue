<template>
  <v-card width="400px" class="mx-auto mt-5">
    <v-card-title class="text-center">就活管理　新規登録</v-card-title>
    <v-card-text>
      <v-form>
        <v-text-field
          type="text"
          prepend-icon="mdi-account"
          label="ニックネーム"
          v-model="name"
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
          <v-btn text="新規登録" variant="text" @click="register" />
          <v-spacer />
          <v-btn text="ログイン" @click="login" color="info" />
        </v-row>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script setup lang="ts">
const showPassword = ref(false);
const name = ref("");
const email = ref("");
const password = ref("");

function login() {
  console.log(name.value, email.value, password.value);
  navigateTo("/");
}

function register() {
  console.log("register");
  navigateTo("/register");
}
</script>
