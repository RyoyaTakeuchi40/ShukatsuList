<template>
  <v-card>
    <v-card-title>予期せぬエラーが発生しました。</v-card-title>
    <v-card-text>
      <v-btn text="ログイン画面に戻る" @click="logout" />
    </v-card-text>
  </v-card>
</template>

<script setup lang="ts">
const { logout } = useAuth();
</script>
