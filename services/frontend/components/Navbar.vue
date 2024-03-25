<template>
  <Overlay :overlay="overlay" />
  <v-app-bar color="primary">
    <v-app-bar-title class="font-weight-bold">就活管理</v-app-bar-title>
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
const overlay = ref(false);

const handleLogout = async () => {
  overlay.value = true;
  await logout();
  overlay.value = false;
};

const items = [
  {
    title: "一覧",
    value: "List",
    props: {
      prependIcon: "mdi-format-list-bulleted",
      to: "/companies",
    },
  },
  {
    title: "ログアウト",
    value: "log-out",
    props: {
      prependIcon: "mdi-logout",
      onClick: handleLogout,
    },
  },
];
</script>
