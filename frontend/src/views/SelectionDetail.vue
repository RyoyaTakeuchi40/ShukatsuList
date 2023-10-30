<script setup lang="ts">
import { useCounterStore } from '@/stores/counter'
import { useAuthStore } from '@/stores/auth'

const counter = useCounterStore()
const auth = useAuthStore()

counter.count++
</script>

<template>
  <v-sheet>詳細ページ</v-sheet>
  <div>Current Count: {{ counter.count }}</div>
  <v-card-text>username: {{ auth.name }}</v-card-text>
  <v-card-text>username: {{ auth.email }}</v-card-text>
  <v-btn @click="counter.increment">+1</v-btn>
  <v-divider />
  <v-btn>おりゃ</v-btn>
</template>

<style scoped></style>
