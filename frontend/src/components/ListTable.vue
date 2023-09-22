<template>
  <v-data-table
    :headers="headers"
    :items="desserts"
    item-value="name"
    class="my-table"
  ></v-data-table>
</template>

<script setup lang="ts">
import { VDataTable } from 'vuetify/labs/components'

const headers = [
  {
    title: 'Dessert (100g serving)',
    align: 'start',
    sortable: false,
    key: 'name'
  },
  { title: 'Calories', align: 'end', key: 'calories' },
  { title: 'Fat (g)', align: 'end', key: 'fat' },
  { title: 'Carbs (g)', align: 'end', key: 'carbs' },
  { title: 'Protein (g)', align: 'end', key: 'protein' },
  { title: 'Iron (%)', align: 'end', key: 'iron' }
]

const desserts = [
  {
    name: 'Frozen Yogurt',
    calories: 159,
    fat: 6.0,
    carbs: 24,
    protein: 4.0,
    iron: '1'
  },
  {
    name: 'Jelly bean',
    calories: 375,
    fat: 0.0,
    carbs: 94,
    protein: 0.0,
    iron: '0'
  }
]
</script>
