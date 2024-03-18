<template>
  <v-card width="400px" class="mx-auto mt-5">
    <v-card-title class="text-center">就活管理　ログイン</v-card-title>
    <v-form v-model="valid">
      <v-card-text>
        {{ isAuth }}
        <v-text-field
          v-model="email"
          type="email"
          prepend-icon="mdi-email"
          label="メールアドレス"
          :rules="[(v) => !!v || 'メールアドレスを入力してください']"
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
          :rules="[(v) => !!v || 'パスワードを入力してください']"
          required
          variant="outlined"
          class="my-2"
        />
        <v-row>
          <v-btn
            text="新規登録"
            variant="text"
            @click="navigateTo('/register')"
          />
          <v-spacer />
          <v-btn
            color="info"
            text="ログイン"
            :disabled="!valid"
            @click="login"
          />
        </v-row>
      </v-card-text>
    </v-form>
  </v-card>
</template>

<script setup lang="ts">
const isAuth = useAuth();
const valid = ref(true);
const showPassword = ref(false);
const email = ref("");
const password = ref("");
const errors = ref({
  email: [],
  password: [],
});

const login = async () => {
  await useFetch("/api/login", {
    method: "POST",
    body: {
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
