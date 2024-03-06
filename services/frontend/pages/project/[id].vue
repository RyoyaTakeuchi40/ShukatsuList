<template>
  <h1>プロジェクトNo.: {{ route.params.id }}</h1>
  <v-card v-for="index in test"> ここ {{ index }}</v-card>
</template>

<script setup>
const route = useRoute();
const test = 5;
let num = 3;

while (num < 100) {
  console.log(num);
  num = num * 3;
}

console.log("end");
</script>
