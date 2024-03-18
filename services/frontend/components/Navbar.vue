<template>
  <v-app-bar color="primary">
    <v-app-bar-title class="font-weight-bold">就活管理</v-app-bar-title>
    <template v-slot:append>
      <v-menu>
        <template v-slot:activator="{ props }">
          <v-app-bar-nav-icon v-bind="props" />
        </template>
        <v-list :items="items" />
      </v-menu>
    </template>
  </v-app-bar>
</template>

<script setup lang="ts">
const items = [
  // {
  //   title: "My Page",
  //   value: "my-page",
  //   props: {
  //     prependIcon: "mdi-account",
  //     to: "/account",
  //   },
  // },
  {
    title: "List",
    value: "List",
    props: {
      prependIcon: "mdi-format-list-bulleted",
      to: "/companies",
    },
  },
  // {
  //   title: "Dtail",
  //   value: "detail",
  //   props: {
  //     prependIcon: "mdi-close",
  //     to: "/detail",
  //   },
  // },
  {
    title: "Log Out",
    value: "log-out",
    props: {
      prependIcon: "mdi-logout",
      to: "/login",
      // onClick: handleLogout,
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
