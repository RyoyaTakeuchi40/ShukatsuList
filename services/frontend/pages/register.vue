<template>
  <v-card width="400px" class="mx-auto mt-5">
    <v-card-title class="text-center">就活管理　新規登録</v-card-title>
    <v-card-text>
      <v-form>
        <v-text-field
          v-model="name"
          type="text"
          prepend-icon="mdi-account"
          label="ニックネーム"
          :error-messages="errors.name"
          required
          variant="outlined"
          class="my-2"
        />
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
          class="my-2"
        />
        <v-row class="my-2">
          <v-btn text="ログイン" variant="text" @click="navigateTo('/login')" />
          <v-spacer />
          <v-btn text="新規登録" color="info" @click="register" />
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
const errors = ref({
  name: [],
  email: [],
  password: [],
});

const register = async () => {
  await useFetch("/api/register", {
    method: "POST",
    body: {
      name: name.value,
      email: email.value,
      password: password.value,
    },
  })
    .then((res) => {
      const data = res.data.value;
      const error = res.error.value;
      if (error) {
        if (error.data?.statusCode == 422) {
          errors.value = error.data.data.errors;
          console.log("422", errors.value);
        } else {
          console.log("error", error);
        }
      } else {
        navigateTo("/login");
      }
    })
    .catch(({ error }) => {
      console.log("exceptional...", error.value);
    });
};
</script>
