<template>
  <template v-if="loading">
    <v-card>
      <v-card-title>now loading...</v-card-title>
    </v-card>
  </template>
  <template v-else-if="error">
    <v-card>
      <v-card-title>エラーが発生しました。{{ error }}</v-card-title>
      <v-btn @click="refresh">リロード</v-btn>
    </v-card>
  </template>
  <template v-else>
    <v-btn @click="refresh">リロード</v-btn>
    <ListTable :items="items" :headers="headers" />
  </template>
</template>

<script setup lang="ts">
const userId = ref(1);
const loading = ref(true);
const headers = ref([
  { title: "", key: "result", sortable: false },
  { title: "", key: "name", sortable: false },
  { title: "", key: "favorite", align: "center" },
  {
    title: "ログインID",
    key: "login",
    class: "bg-blue-lighten-3",
    align: "center",
    sortable: false,
  },
  { title: "ES", key: "es", align: "center" },
  { title: "テスト", key: "test", align: "center" },
  { title: "GD", key: "gd", align: "center" },
  { title: "", key: "delete", sortable: false },
]);

const {
  data: items,
  error,
  pending,
  refresh,
} = await useFetch("http://backend:8000/api/companies", {
  query: { userId },
  mode: "cors",
});

const findMaxInterviewLength = (items: Array<any>) => {
  let maxLength = 0;
  for (const item of items) {
    if (item.interviews && item.interviews.length > maxLength) {
      maxLength = item.interviews.length;
    }
  }
  return maxLength;
};

const addInterviewsToHeaders = () => {
  for (let i = 0; i < findMaxInterviewLength(items.value); i++) {
    headers.value.splice(-1, 0, {
      title: `${i + 1}次面接`,
      key: i,
      align: "center",
    });
  }
};

onMounted(() => {
  addInterviewsToHeaders();
  loading.value = false;
});
</script>

<style scoped></style>
