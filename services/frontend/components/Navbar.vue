<template>
  <v-app-bar color="primary">
    <v-app-bar-title class="font-weight-bold">就活管理</v-app-bar-title>
    <template v-slot:append>
      <v-app-bar-nav-icon />
      <v-menu activator=".v-app-bar-nav-icon">
        <v-list :items="items" />
      </v-menu>
    </template>
  </v-app-bar>
</template>

<script setup lang="ts">
const reset = () => {
  console.log("reset");
};
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
    title: "Home",
    value: "home",
    props: {
      prependIcon: "mdi-home",
      to: "/",
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
  // {
  //   title: "Log Out",
  //   value: "log-out",
  //   props: {
  //     prependIcon: "mdi-logout",
  //     to: "/login",
  //   },
  // },
  {
    title: "リセット",
    value: "reset",
    props: {
      prependIcon: "mdi-checkbox-marked-circle",
      onClick: reset,
    },
  },
  {
    title: "about",
    value: "about",
    props: { to: "/about" },
  },
  {
    title: "project1",
    value: "project1",
    props: { to: "/project/1" },
  },
  {
    title: "project2",
    value: "project2",
    props: { to: "/project/2" },
  },
];
</script>
