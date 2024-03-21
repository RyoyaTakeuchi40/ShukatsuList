<template>
  <v-card max-width="600px" class="mx-auto mt-5">
    <v-card-title class="text-center">ログイン</v-card-title>
    <v-form v-model="valid">
      <v-card-text>
        <v-text-field
          v-model="email"
          type="email"
          prepend-icon="mdi-email"
          label="メールアドレス"
          :error-messages="errors.email"
          required
          variant="outlined"
          class="my-2"
        />
        <v-text-field
          v-model="password"
          :type="showPassword ? 'text' : 'password'"
          prepend-icon="mdi-lock"
          :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
          @click:append-inner="showPassword = !showPassword"
          label="パスワード"
          :error-messages="errors.password"
          required
          variant="outlined"
          class="mt-2 mb-8"
        />
        <v-row>
          <v-btn text="新規登録" @click="navigateTo('/register')" />
          <v-spacer />
          <v-btn color="info" text="ログイン" @click="login" />
        </v-row>
      </v-card-text>
    </v-form>
  </v-card>
</template>

<script setup lang="ts">
const valid = ref(true);
const showPassword = ref(false);
const email = ref("");
const password = ref("");
const errors = ref({
  email: [],
  password: [],
});

const login = async () => {
  await useApiFetch("/sanctum/csrf-cookie");
  await useApiFetch("/login", {
    method: "POST",
    body: {
      email: email.value,
      password: password.value,
    },
  })
    .then(async (res) => {
      const data = res.data.value;
      const error = res.error.value;
      if (error) {
        if (error.data?.errors) {
          errors.value = error.data.errors;
          console.log("422", errors.value);
        } else {
          console.log("error", error.data);
        }
      } else {
        navigateTo("/");
      }
    })
    .catch(({ error }) => {
      console.log("exceptional...", error.value);
    });
};
</script>
