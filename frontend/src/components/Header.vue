<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()

const home = {
  icon: 'mdi-home',
  link: '/'
}
const title = 'リスト'

const listItems = [
        {
          title: 'My Page',
          value: 'my-page',
          props: {
            prependIcon: 'mdi-account',
            to: '/account',
          },
        },
        {
          title: 'Home',
          value: 'home',
          props: {
            prependIcon: 'mdi-home',
            to: '/',
          },
        },
        {
          title: 'Dtail',
          value: 'detail',
          props: {
            prependIcon: 'mdi-close',
            to: '/detail',
          },
        },
        {
          title: 'Log Out',
          value: 'log-out',
          props: {
            prependIcon: 'mdi-logout',
            to: '/login',
          },
        },
        {
          title: 'サンプル',
          value: 'sample',
          props: {
            prependIcon: 'mdi-checkbox-marked-circle',
            onClick: reset,
          },
        },
]

function reset() {
  auth.$reset()
}

</script>

<template>
  <v-app-bar app color="blue">
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
        <v-list
          :items="listItems"
          dense
        >
        </v-list>
      </v-menu>
    </template>
  </v-app-bar>
</template>