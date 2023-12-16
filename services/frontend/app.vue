<template>
  <v-container class="bg-red-lighten-4">
    <v-card class="bg-yellow">
      <v-card-text class="d-flexjustify-content center">
        <v-icon icon="mdi-check-circle" class="mr-6" />
        <v-btn class="mr-3"> Docker</v-btn>
        <v-btn color="primary" class="mr-3">Nuxt</v-btn>
        <v-btn class="mr-3 bg-red">Laravel</v-btn>
        <v-btn color="primary" class="mr-3">Nginx</v-btn>
      </v-card-text>
    </v-card>
    <v-card>
      <v-card-text>
        <v-btn color="green">API</v-btn>
        <v-list v-for="post in posts" :key="post.id">
          <v-card-title>{{ post }}</v-card-title>
        </v-list>
      </v-card-text>
    </v-card>
  </v-container>
  <NuxtWelcome />
</template>

<script setup lang="ts">
const {
  data: posts,
  error,
  refresh,
} = await useFetch("http://backend:8000/api");
</script>
