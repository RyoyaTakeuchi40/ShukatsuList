<script setup lang="ts">
import { ref } from 'vue'
import ListTable from '@/components/ListTable.vue'

const overlay = ref(true)
</script>

<template>
  <template v-if="overlay">
    <v-overlay v-model="overlay">
      <v-progress-circular
        indeterminate
        color="blue-grey"
      ></v-progress-circular>
      <v-btn 
        @click="overlay = false"
      >Stop Overlay</v-btn>
    </v-overlay>
  </template>
  <template v-else>
    <v-card>
      <ListTable />
    </v-card>
  </template>
</template>
