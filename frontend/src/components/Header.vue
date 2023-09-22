<template>
  <v-app-bar app color="primary">
    <template v-slot:prepend>
      <RouterLink :to="home.link">
        <v-icon>{{ home.icon }}</v-icon>
      </RouterLink>
    </template>
    <template v-slot:title>
      <v-app-bar-title>{{ title }}</v-app-bar-title>
    </template>
    <template v-slot:append>
      <v-app-bar-nav-icon></v-app-bar-nav-icon>
      <v-menu activator=".v-app-bar-nav-icon">
        <v-list nav dense>
          <v-list-item title="John Leider" value="name"></v-list-item>
          <v-divider></v-divider>
          <v-list-item
            prepend-icon="mdi-view-dashboard"
            title="Home"
            value="home"
            to="/"
          ></v-list-item>
          <v-list-item
            prepend-icon="mdi-forum"
            title="Detail"
            value="detail"
            to="/detail"
          ></v-list-item>
          <v-list-item 
            prepend-icon="mdi-forum"
            title="Logout"
            value="logout"
            to=""
          ></v-list-item>
        </v-list>
      </v-menu>
    </template>
  </v-app-bar>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink } from 'vue-router'

let menu = ref(false)

const title = '選考状況'
const home = {
  icon: 'mdi-home',
  link: '/'
}
</script>
