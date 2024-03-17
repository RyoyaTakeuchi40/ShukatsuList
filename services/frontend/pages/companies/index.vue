<template>
  <NuxtPage />
  <template v-if="error">
    <v-card>
      <v-card-title>エラーが発生しました。</v-card-title>
      <v-btn @click="refresh">リロード</v-btn>
      {{ error }}
    </v-card>
  </template>
  <template v-else>
    <v-overlay :model-value="overlay" class="align-center justify-center">
      <v-progress-circular
        color="primary"
        size="64"
        indeterminate
      ></v-progress-circular>
    </v-overlay>
    <CompaniesListTable
      :items="items"
      :headers="headers"
      @overlay-start="overlay = true"
      @need-refresh="refresh"
    />
  </template>
</template>

<script setup lang="ts">
const overlay = ref(true);
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
} = await useFetch("/api/companies", { method: "GET" });

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
  for (
    let i = 0;
    headers.value.length - 8 < findMaxInterviewLength(items.value);
    i++
  ) {
    headers.value.splice(-1, 0, {
      title: `${i + 1}次面接`,
      key: i,
      align: "center",
    });
  }
};

onMounted(() => {
  addInterviewsToHeaders();
  overlay.value = false;
});

watch(pending, () => {
  if (pending.value == true) {
    overlay.value = true;
  } else {
    addInterviewsToHeaders();
    overlay.value = false;
  }
});
</script>

<style scoped></style>
