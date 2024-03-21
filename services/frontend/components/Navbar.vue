<template>
  <v-app-bar color="primary">
    <v-app-bar-title class="font-weight-bold"
      >就活管理 {{ isLoggedIn }}</v-app-bar-title
    >
    <template v-slot:append>
      <v-menu v-if="isLoggedIn">
        <template v-slot:activator="{ props }">
          <v-app-bar-nav-icon v-bind="props" />
        </template>
        <v-list :items="items" />
      </v-menu>
    </template>
  </v-app-bar>
</template>

<script setup lang="ts">
const { isLoggedIn, logout } = useAuth();

const items = [
  {
    title: "List",
    value: "List",
    props: {
      prependIcon: "mdi-format-list-bulleted",
      to: "/companies",
    },
  },
  {
    title: "Log Out",
    value: "log-out",
    props: {
      prependIcon: "mdi-logout",
      to: "/login",
      onClick: logout,
    },
  },
  {
    title: "リセット",
    value: "reset",
    props: {
      prependIcon: "mdi-checkbox-marked-circle",
    },
  },
];
</script>
