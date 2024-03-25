<template>
  <template v-if="error">
    <ErrorCard />
  </template>
  <template v-else>
    <Overlay :overlay="overlay" />
    <CompaniesDetailForm
      :item="item"
      :errors="errors"
      @overlayStart="overlay = true"
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
const errors = ref({
  name: [],
});

const editItem = async () => {
  overlay.value = true;
  await useApiFetch(`/api/companies/${route.params.id}`, {
    method: "POST",
    body: item.value,
  })
    .then((res) => {
      const error = res.error.value;
      if (error) {
        if (error.data?.errors) {
          errors.value = error.data.errors;
          console.log("422", errors.value);
        } else {
          console.log("error", error.data);
        }
        overlay.value = false;
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
