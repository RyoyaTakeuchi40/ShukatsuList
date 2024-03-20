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
const isAuth = useAuth();

const logout = async () => {
  await useFetch("/api/logout", {
    method: "POST",
  })
    .then((res) => {
      const data = res.data.value;
      const error = res.error.value;
      if (error) {
        console.log("error", error.data);
      } else {
        isAuth.value = false;
        console.log("data", data);
        navigateTo("/");
      }
    })
    .catch(({ error }) => {
      console.log("exceptional...", error.value);
    });
};

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
