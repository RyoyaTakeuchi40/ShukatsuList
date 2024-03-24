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
    <CompaniesDetailForm
      :item="item"
      @editBtnClicked="editItem"
      @addInterview="addInterview"
      @deleteInterview="deleteInterview"
    />
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
const addInterview = () => {
  item.value.interviews.push({
    date: "",
    note: "",
    result: 0,
  });
};
const deleteInterview = () => {
  item.value.interviews.pop();
};

onMounted(() => {
  overlay.value = false;
});
</script>

<style scoped></style>
