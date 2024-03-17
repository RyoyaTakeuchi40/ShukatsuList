<template>
  <template v-if="loading">
    <v-card>
      <v-card-title>now loading...</v-card-title>
    </v-card>
  </template>
  <template v-else-if="error">
    <v-card>
      <v-card-title>エラーが発生しました。</v-card-title>
      <v-btn @click="refresh">リロード</v-btn>
      {{ error }}
    </v-card>
  </template>
  <template v-else>
    <CompaniesDetail :item="item" @edit-btn-clicked="editItem" />
  </template>
</template>

<script setup lang="ts">
const route = useRoute();
const loading = ref(true);

const {
  data: item,
  error,
  pending,
  refresh,
} = await useFetch(`/api/companies/${route.params.id}`, { method: "GET" });

const editItem = async () => {
  await useFetch(`/api/companies/${route.params.id}`, {
    method: "POST",
    body: item.value,
  })
    .then(() => {
      navigateTo("/companies");
    })
    .catch(({ error }) => {
      console.log(error.value);
    });
};

onMounted(() => {
  loading.value = false;
});

watch(pending, () => {
  if (pending.value == true) {
    loading.value = true;
  } else {
    loading.value = false;
  }
});
</script>

<style scoped></style>
