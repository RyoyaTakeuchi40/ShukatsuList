<template>
  <v-app>
    <NuxtLayout>
      <v-main>
        <v-container>
          <v-card>
            <v-card-title>エラーが発生しました。</v-card-title>
            <v-card-text>
              {{ error.statusCode }}
              <br />
              {{ error.message }}
              <v-btn
                text="ログイン画面に戻る"
                @click="handleLogout"
                class="my-2 d-block"
              />
            </v-card-text>
          </v-card>
        </v-container>
      </v-main>
    </NuxtLayout>
  </v-app>
</template>

<script setup lang="ts">
const error = useError();
const { logout } = useAuth();

const handleLogout = async () => {
  await logout();
  window.location.href = "/login";
};
</script>
