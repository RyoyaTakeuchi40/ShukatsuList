<template>
  <template v-if="error">
    <v-card>
      <v-card-title>エラーが発生しました。</v-card-title>
      <v-btn @click="refresh">リロード</v-btn>
      {{ error }}
    </v-card>
  </template>
  <template v-else>
    <Overlay :overlay="overlay" />
    <CompaniesDetail :item="item" @edit-btn-clicked="editItem" />
  </template>
</template>

<script setup lang="ts">
const route = useRoute();
const overlay = ref(true);

const {
  data: item,
  error,
  pending,
  refresh,
} = await useApiFetch(`/api/companies/${route.params.id}`, { method: "GET" });

const editItem = async () => {
  overlay.value = true;
  await useApiFetch(`/api/companies/${route.params.id}`, {
    method: "POST",
    body: item.value,
  })
    .then((res) => {
      const error = res.error.value;
      if (error) {
        console.log("error", error);
      } else {
        navigateTo("/companies");
      }
    })
    .catch(({ error }) => {
      console.log("exceptional...", error.value);
    });
};

onMounted(() => {
  overlay.value = false;
});
</script>

<style scoped></style>
