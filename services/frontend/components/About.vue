<template>
  <v-container v-if="pending">
    <v-card>
      <v-card-title>now loading...</v-card-title>
    </v-card>
  </v-container>
  <v-container v-else class="bg-red-lighten-4">
    <v-card class="bg-yellow">
      <v-card-text class="d-flexjustify-content center">
        <v-icon icon="mdi-check-circle" class="mr-6" />
        <v-btn class="mr-3">Docker</v-btn>
        <v-btn color="primary" class="mr-3">Nuxt</v-btn>
        <v-btn class="mr-3 bg-red">Laravel</v-btn>
        <v-btn color="primary" class="mr-3">Nginx</v-btn>
        <v-btn @click="toHome()" color="black" class="mr-3">HOME</v-btn>
      </v-card-text>
    </v-card>
    <nuxt-link to="/">HOME</nuxt-link>
    <v-card>
      <v-card-text>
        <v-btn @click="refresh" color="green">API</v-btn>
        <v-list v-for="post in posts" :key="post">
          <v-card-title>{{ post }}</v-card-title>
        </v-list>
      </v-card-text>
    </v-card>
    <v-card>
      <v-card-text>
        <v-btn color="yellow">TEST</v-btn>
        <v-card-title>{{ test }}</v-card-title>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup lang="ts">
const {
  data: posts,
  error,
  pending,
  refresh,
} = await useFetch("http://backend:8000/api");

const { data: test } = await useFetch("http://backend:8000/api/test", {
  method: "post",
});

const toHome = () => {
  navigateTo("/about");
};
</script>
