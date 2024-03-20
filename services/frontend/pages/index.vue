<template>
  <v-card>
    <template v-if="pending">
      <p>now loading</p>
    </template>
    <template v-else-if="error">
      <p>error{{ error }}</p>
    </template>
    <template v-else>
      <p>data{{ data }}</p>
    </template>
    <v-btn @click="refresh">リロード</v-btn>
  </v-card>
</template>

<script setup>
const { data, error, pending, refresh } = await useApiFetch("/api/user");
</script>
