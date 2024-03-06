<template>
  <v-card>
    <v-container>
      <v-text-field label="会社名" />
      <v-text-field label="URL" />
      <v-text-field label="ログインID" />
      <v-text-field label="ES" />
      <v-text-field label="テスト" />
      <v-text-field label="GD" />
      <v-text-field label="1次面接" />
      <v-text-field label="2次面接" />
      <v-text-field label="3次面接" />
      <v-text-field label="結果" />
    </v-container>
  </v-card>
</template>

<script setup lang="ts">
const item = {
  id: "18",
  name: "Simplex",
  favorite: "1",
  es: null,
  check_es: "0",
  memo_es: "",
  test: null,
  test_type: "0",
  check_test: "0",
  interview_1: null,
  check_1: "0",
  memo_1: "",
  interview_2: null,
  check_2: "0",
  memo_2: "",
  interview_3: null,
  check_3: "0",
  memo_3: "",
  result: "1",
  url: "https://mypage.3150.i-webs.jp/simplex2025/",
  login: "S25002021",
  interview_dates: null,
};
</script>
