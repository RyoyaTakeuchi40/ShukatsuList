<script setup lang="ts">
import { VDataTable } from 'vuetify/labs/components';

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
  { title: 'Iron (%)', align: 'end', key: 'iron' },
  { title: '', key: 'actions', sortable: false },
]
const desserts = [
          {
            id: 1,
            name: 'Frozen Yogurt',
            calories: 159,
            fat: 6.0,
            fat2: 441,
            carbs: 24,
            protein: 4.0,
            iron: 1,
          },
          {
            id: 2,
            name: 'Ice cream sandwich',
            calories: 237,
            fat: 9.0,
            carbs: 37,
            protein: 4.3,
            iron: 1,
          },
          {
            id: 3,
            name: 'Eclair',
            calories: 262,
            fat: 16.0,
            carbs: 23,
            protein: 6.0,
            iron: 7,
          },
          {
            id: 4,
            name: 'Cupcake',
            calories: 305,
            fat: 3.7,
            carbs: 67,
            protein: 4.3,
            iron: 8,
          },
          {
            id: 5,
            name: 'Gingerbread',
            calories: 356,
            fat: 16.0,
            carbs: 49,
            protein: 3.9,
            iron: 16,
          },
          {
            id: 6,
            name: 'Jelly bean',
            calories: 375,
            fat: 0.0,
            carbs: 94,
            protein: 0.0,
            iron: 0,
          },
          {
            id: 7,
            name: 'Lollipop',
            calories: 392,
            fat: 0.2,
            carbs: 98,
            protein: 0,
            iron: 2,
          },
          {
            id: 8,
            name: 'Honeycomb',
            calories: 408,
            fat: 3.2,
            carbs: 87,
            protein: 6.5,
            iron: 45,
          },
          {
            id: 9,
            name: 'Donut',
            calories: 452,
            fat: 25.0,
            carbs: 51,
            protein: 4.9,
            iron: 22,
          },
          {
            id: 10,
            name: 'KitKat',
            calories: 518,
            fat: 26.0,
            carbs: 65,
            protein: 7,
            iron: 6,
          },
]

const clickRow = (event: any, row: object) => {
  console.log(row.item.value)
  // window.open(`/${row.item.value}`, '_blanck')
}
</script>

<template>
  <v-data-table
    :headers="headers"
    :items="desserts"
    :hover="true"
    :items-per-page="5"
    item-value="id"
    class="elevation-1"
    @click:row="clickRow"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>My CRUD</v-toolbar-title>
      </v-toolbar>
    </template>

    <template v-slot:item.name="{ item }">
      {{ item.selectable.name }}
      <v-btn
        icon="mdi-open-in-new"
        size="small"
        variant="plain"
      ></v-btn>
    </template>

    <template v-slot:item.fat="{ item }">
      {{ item.selectable.fat }}    {{ item.selectable.fat2 }}
    </template>

    <template v-slot:item.actions>
      <v-btn
        icon="mdi-pencil"
        size="small"
        variant="plain"
      ></v-btn>
      <v-btn
        icon="mdi-delete"
        size="small"
        variant="plain"
      ></v-btn>
    </template>

    <template v-slot:no-data>
      <v-btn
        color="primary"
      >
        No Data
      </v-btn>
    </template>

  </v-data-table>
</template>

<style scoped>
.v-data-table {
  white-space : nowrap;
}
</style>